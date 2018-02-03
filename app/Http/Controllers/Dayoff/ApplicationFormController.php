<?php namespace App\Http\Controllers\Dayoff;

use Illuminate\Http\Request;
use App\Model\ApplicationForm;

use App\Http\Controllers\Api\ApplicationTemplateController;

class ApplicationFormController extends Controller {

	protected function init()
	{
		parent::init();

		$this->model = new ApplicationForm();
		$this->model->organization_id = $this->organization_id;
		// $this->model->status = 0; //Applied
		// $this->model->applied_user_id = \Auth::id();
		$this->data['applied_user_name'] = "";
		// $this->model->datetime_from = date("Y-m-d 00:00");
		// $this->model->datetime_to = date("Y-m-d 23:00");
		$this->data["view_mode"] = false;

		$column_list = array();
		$column_list["application_form.organization_id"] = $this->organization_id;
		if(isset($this->logged_in_user->permission_flag) && ($this->logged_in_user->permission_flag != "Manager")){
			$column_list["application_form.applied_user_id"] = \Auth::id();
		}
		$this->data["request_data"]["where"]["column_list"] = $column_list;

		$this->url_pattern = "dayoff.application-form";
		$this->data["url_pattern"] = "/dayoff/application-form";
	}

	public function add()
	{
		// if($this->form_input && (count($this->form_input) > 0)){ // Submit
		// 	unset($this->model->applied_user_name);
		// }

		$this->model->status = 0; //Applied
		// $this->model->organization_id = $this->organization_id;
		$this->model->applied_user_id = \Auth::id();
		$this->data['applied_user_name'] = \Auth::user()->name;
		$this->model->datetime_from = date("Y-m-d 00:00");
		$this->model->datetime_to = date("Y-m-d 23:00");

		$controller = new ApplicationTemplateController($this->request);
		$template_list = $controller->getList();

		$this->data["template_list"] = $template_list;

		return parent::add();
	}

	public function view($id)
	{
		$model = $this->model;
		$model = $model->join("users", "application_form.applied_user_id", "=", "users.id");
		$model = $model->select(["application_form.*",
			\DB::raw("users.name AS APPLIED_USER_NAME"),
			\DB::raw("CASE application_form.status WHEN 1 THEN 'Approved'
						WHEN 2 THEN 'Rejected'
						ELSE ''
						END AS STATUS_LABEL"),
		]);
		$model = $model->where("application_form.id", "=", $id);
		$model = $model->first();

		$this->data['applied_user_name'] = $model->APPLIED_USER_NAME;
		$this->data["view_mode"] = true;

		$url = $this->url_pattern . '.edit';
		return view($url, array('data'=>$this->data, "logged_in_user"=>$this->logged_in_user, 'model'=>$model));
	}

	public function approve($id)
	{
		$status = 1; // Approved
		return $this->statusUpdate($id, $status);
	}

	public function reject($id)
	{
		$status = 2; // Rejected
		return $this->statusUpdate($id, $status);
	}

	private function statusUpdate($id, $status)
	{
		$message = NULL;
		$alert_type = NULL;

		$model = &$this->model;
		$model = $model->where("id", "=", $id);
		$model = $model->where("organization_id", "=", $this->organization_id);

		$model = $model->first();

		if(!$model){
			$message = "データが存在していません。";
			return redirect("/" . str_replace(".", "/", $this->url_pattern))->with(['data' => $this->data, 'message'=>$message]);
		}

		if(!(($this->logged_in_user->permission_flag == "Manager") || ($model->applied_user_id == $this->user_id))){
			$message = "データの追加修正削除に関しては、システム管理者までお問い合わせください。";
		}else{
			$model->status = $status;
			$model->approved_user_id = $this->user_id;
			$model->update();
			$alert_type = "success";
			$message = "データ変更完了。";
		}

		$url = $this->data["url_pattern"];
		return redirect($url)->with(['data' => $this->data, 'message'=>$message, "alert_type" => $alert_type]);

	}

}
