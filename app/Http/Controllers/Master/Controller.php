<?php namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
// use Illuminate\Contracts\Auth\Authenticatable;
// use Illuminate\Contracts\Auth\Guard;
// use Illuminate\Foundation\Auth\AuthenticatesUsers;

// use Illuminate\Foundation\Auth\ThrottlesLogins;

class Controller extends \App\Http\Controllers\Controller {

	// use AuthenticatesUsers;

	// protected $administrator;
	// protected $redirectTo = '/master';
	// protected $model;

	public function getLoggedInUser(){
		$this->logged_in_user = parent::getLoggedInUser();

		if(!isset($this->logged_in_user)){
			abort(404);
		}else{
			$role = $this->logged_in_user->role;
			if($role != "Master"){
				abort(404);
			}
		}

		return $this->logged_in_user;
	}

	protected function init()
	{
		parent::init();

		$this->url_pattern = "master";
		// $this->logical_delete = true;
	}

	// public function dashboard()
	// {
	// 	$url = $this->url_pattern . '.index';

	// 	return view($url, ['data'=>$this->data, "logged_in_user"=>$this->logged_in_user]);
	// }

	public function add()
	{
		$url = $this->url_pattern . '.edit';
		$message = NULL;
		$alert_type = NULL;

		if($this->form_input && (count($this->form_input) > 0)){ // Submit

			$this->model->fill($this->form_input);
			$this->model->save(); //insert
			$alert_type = "success";
			$message = __("message.status.done.add");

			return redirect("/" . str_replace(".", "/", $this->url_pattern))->with(["message"=>$message, "alert_type" => $alert_type]);
		}

		return view($url, ['data'=>$this->data, "logged_in_user"=>$this->logged_in_user, "model"=>$this->model]);
	}

	public function edit($id)
	{
		$this->blade_url = $this->url_pattern . '.edit';
		$message = NULL;
		$alert_type = NULL;

		$this->model = $this->model->find($id);

		$exist_flag = true;
		$exist_flag = ($this->model) ? true : false;

		if(!$exist_flag){
			return redirect("/" . str_replace(".", "/", $this->url_pattern) . '/add')->with(["message"=>"データが存在していませんから、追加画面に遷移しました。", "alert_type" => $alert_type]);
		}

		if($this->form_input){ // Submit
			$form_input = $this->form_input;

			$this->model->fill($this->form_input);
			$this->model->update();
			$alert_type = "success";
			$message = __("message.status.done.edit");

		}

		return view($this->blade_url, ['data'=>$this->data, "logged_in_user"=>$this->logged_in_user, "model"=>$this->model])->with(["message"=>$message, "alert_type" => $alert_type]);

	}

}
