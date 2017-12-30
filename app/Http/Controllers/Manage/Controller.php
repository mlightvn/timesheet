<?php namespace App\Http\Controllers\Manage;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
// use Illuminate\Contracts\Auth\Authenticatable;
// use Illuminate\Contracts\Auth\Guard;
// use Illuminate\Foundation\Auth\AuthenticatesUsers;

// use Illuminate\Foundation\Auth\ThrottlesLogins;

class Controller extends \App\Http\Controllers\Controller {

	// use AuthenticatesUsers;

	protected $administrator;
	protected $redirectTo = 'manage';
	protected $model;

	protected function init()
	{
		parent::init();

		$this->url_pattern = "manage";
		// $this->logical_delete = true;
	}

	public function dashboard()
	{
		$url = $this->url_pattern . '.index';

		return view($url, ['data'=>$this->data, "logged_in_user"=>$this->logged_in_user]);
	}

	public function index()
	{
		$url = "";
		if($this->url_pattern){
			$url = $this->url_pattern . '.index';
		}else{
			$url = 'manage.index';
		}

		$keyword = "";
		if(isset($this->form_input["keyword"])){
			$keyword = $this->form_input["keyword"];
		}

		$model_list = $this->model->paginate(env('NUMBER_OF_RECORD_PER_PAGE'));

		$this->data["keyword"] = $keyword;
		$this->data["model_list"] = $model_list;

		return view($url, ['data'=>$this->data, "logged_in_user"=>$this->logged_in_user, 'model_list'=>$model_list]);
	}

	public function add()
	{
		$url = $this->url_pattern . '.edit';
		$message = NULL;
		$alert_type = NULL;

		if($this->form_input && (count($this->form_input) > 0)){ // Submit
			$form_input = $this->form_input;

			$this->model->fill($this->form_input);
			$this->model->save(); //insert
			$alert_type = "success";
			$message = "追加完了。";

			return redirect("/" . str_replace(".", "/", $this->url_pattern))->with(["message"=>$message, "alert_type" => $alert_type]);
		}

		return view("/" . str_replace(".", "/", $url), ['data'=>$this->data, "logged_in_user"=>$this->logged_in_user, "model"=>$this->model]);
	}

	public function edit($id)
	{
		$this->blade_url = $this->url_pattern . '.edit';
		$message = NULL;
		$alert_type = NULL;

		// $this->model = $this->model->find($id);
		$this->model = $this->model->where("id", $id);
		$this->model = $this->model->where("organization_id", \Auth::user()->organization_id);
		$this->model = $this->model->first();


		if(!$this->model){
			return redirect("/" . str_replace(".", "/", $this->url_pattern) . '/add')->with(["message"=>"データが存在していませんから、追加画面に遷移しました。", "alert_type" => $alert_type]);
		}

		if($this->form_input){ // Submit
			$form_input = $this->form_input;

			$this->model->fill($this->form_input);
			$this->model->update();
			$alert_type = "success";
			$message = "データ（ID: " . $id . "）が修正完了。";
		}

		return view("/" . str_replace(".", "/", $this->blade_url), ['data'=>$this->data, "logged_in_user"=>$this->logged_in_user, "model"=>$this->model])->with(["message"=>$message, "alert_type" => $alert_type]);
	}

	public function delete($id)
	{
		$message = NULL;
		$alert_type = NULL;

		$this->model = $this->model->find($id);

		if(!$this->model){
			$message = "データ（ID: " . $id . "）が存在していません。";
			return redirect("/" . str_replace(".", "/", $this->url_pattern))->with(['data' => $this->data, 'message'=>$message]);
		}

		if(!in_array($this->logged_in_user->permission_flag, array("Administrator", "Manager"))){
			$message = "データの追加修正削除に関しては、システム管理者までお問い合わせください。";
		}else{
			if($this->logical_delete){
				$this->model->is_deleted = 1;
				$this->model->update();
			}else{
				$this->model->delete();
			}
			$alert_type = "success";
			$message = "データ（ID: " . $id . "）が削除完了。";
		}

		return redirect("/" . str_replace(".", "/", $this->url_pattern))->with(['data' => $this->data, 'message'=>$message, "alert_type" => $alert_type]);

	}

	public function recover($id)
	{
		$message = NULL;
		$alert_type = NULL;

		$this->model = $this->model->find($id);

		if(!$this->model){
			$message = "データ（ID: " . $id . "）が存在していません。";
			return redirect("/" . str_replace(".", "/", $this->url_pattern))->with(['data' => $this->data, 'message'=>$message]);
		}

		if(!in_array($this->logged_in_user->permission_flag, array("Administrator", "Manager"))){
			$message = "データの追加修正削除に関しては、システム管理者までお問い合わせください。";
		}else{
			$this->model->is_deleted = 0;
			$this->model->update();

			$alert_type = "success";
			$message = "データ（ID: " . $id . "）が復元完了。";
		}

		return redirect("/" . str_replace(".", "/", $this->url_pattern))->with(['data' => $this->data, 'message'=>$message, "alert_type" => $alert_type]);

	}

}
