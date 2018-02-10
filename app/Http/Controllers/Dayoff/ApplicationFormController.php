<?php namespace App\Http\Controllers\Dayoff;

use Illuminate\Http\Request;
use App\Model\ApplicationForm;

use App\Http\Controllers\Api\ApplicationTemplateController;

class ApplicationFormController extends Controller {

	protected function init()
	{
		parent::init();

		$this->model = new ApplicationForm();
		// $this->model->organization_id = $this->organization_id;
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
		$url = $this->url_pattern . '.edit';

		$this->model->organization_id = $this->organization_id;
		$this->model->applied_user_id = \Auth::id();
		$this->data['applied_user_name'] = \Auth::user()->name;

		$controller = new ApplicationTemplateController($this->request);
		$template_list = $controller->getList();

		$this->data["template_list"] = $template_list;

		$is_submit = false;

		if($this->form_input && (count($this->form_input) > 0)){ // Submit
			// Insert into Application Form table
			$this->model->fill($this->form_input);
			$this->model->save();

			$is_submit = true;

			// Insert into Application Date table
			{
				$date_list_s = $this->form_input["date_list"];

				$dates = array();
				$length = 0;
				if($date_list_s){
					$dates = explode("\n", $date_list_s);
				}
				$length = count($dates);

				if($length > 0){
					$application_form_id = $this->model->id;

					foreach ($dates as $key => $date) {
						$model 							= new \App\Model\ApplicationDate();
						$model->application_form_id 	= $application_form_id;
						$model->organization_id 		= $this->organization_id;
						$model->status 					= 0;
						$model->applied_date 			= $date;
						$model->save();
					}
				}

			}

			$alert_type = "success";
			$message = "新規作成完了";

			$url = "/" . str_replace(".", "/", $this->url_pattern) . "/" . $application_form_id . "/view";
			return redirect($url)->with(["message"=>$message, "alert_type" => $alert_type]);
		}

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
						ELSE 'Applied'
						END AS STATUS_LABEL"),
			\DB::raw("CASE application_form.status WHEN 1 THEN 'w3-green'
						WHEN 2 THEN 'w3-gray'
						ELSE 'w3-yellow'
						END AS STATUS_COLOR"),
		]);
		$model = $model->where("application_form.id", "=", $id);
		$model = $model->first();

		$this->data['applied_user_name'] = $model->APPLIED_USER_NAME;
		$this->data["view_mode"] = true;
		$this->data["date_list"] = $this->getApplicationDateList($id);

		$url = $this->url_pattern . '.edit';
		return view($url, array('data'=>$this->data, "logged_in_user"=>$this->logged_in_user, 'model'=>$model));
	}

	private function getApplicationDateList($application_form_id)
	{
		$model = new \App\Model\ApplicationDate();
		$model = $model->where("application_form_id", "=", $application_form_id);
		$model_list = $model->get();

		return $model_list;
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

			// Update status for application_date table
			{
				unset($model);

				$model = new \App\Model\ApplicationDate();
				$model = $model->where("application_form_id", "=", $id);
				$model = $model->where("organization_id", "=", $this->organization_id);

				$update_a = ["approved_user_id" => $this->user_id, "status" => $status];
				$model->update($update_a);
			}

			$alert_type = "success";
			$message = "データ変更完了。";
		}

		$url = $this->data["url_pattern"];
		return redirect($url)->with(['data' => $this->data, 'message'=>$message, "alert_type" => $alert_type]);

	}

}
