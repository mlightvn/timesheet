<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Session;

class AdminSessionController extends AdminController {

	protected function init()
	{
		parent::init();

		$this->model = new Session();

		// 新規追加画面、デフォルトの価値を定義
		$this->model->organization_id 		= $this->organization_id;
		$this->url_pattern = "admin.session";
		$this->data["url_pattern"] = "/admin/session";
		$this->logical_delete = true;
	}

	public function index()
	{
		$url = $this->url_pattern . '.index';

		// $data["logged_in_user"] = $this->logged_in_user;

		$keyword = null;
		if(isset($this->form_input["keyword"])){
			$keyword = $this->form_input["keyword"];
		}
		$this->data["keyword"] = $keyword;

		$arrSessions = $this->getSessions(true, NULL, NULL, $keyword);

		return view("/" . str_replace(".", "/", $url), ['data'=>$this->data, "logged_in_user"=>$this->logged_in_user, "arrSessions"=>$arrSessions]);
	}

	public function add()
	{
		if(in_array($this->logged_in_user->permission_flag, array("Administrator", "Manager"))){
			return parent::add();
		}else{
			return redirect("/" . str_replace(".", "/", $this->url_pattern))->with(["message"=>"セッションの追加修正削除に関しては、システム管理者までお問い合わせください。"]);
		}
	}

	public function edit($id)
	{
		$url = $this->url_pattern . '.edit';
		$this->model = $this->model->find($id);

		$message = NULL;
		$alert_type = NULL;

		if(!$this->model){
			return redirect("/" . str_replace(".", "/", $this->url_pattern) . '/add')->with(["message"=>"セッションが存在していませんから、セッション追加画面に遷移しました。", "alert_type" => $alert_type]);
		}

		if($this->form_input){ // Submit
			$is_manager = in_array($this->logged_in_user->permission_flag, array("Administrator", "Manager"));
			if($is_manager){

				$this->model->fill($this->form_input);
				$this->model->update();
				$alert_type = "success";
				$message = "修正完了。";
			}else{
				$message = "セッションの追加修正削除に関しては、システム管理者までお問い合わせください。";
			}
		}

		return view("/" . str_replace(".", "/", $url), ['data'=>$this->data, "logged_in_user"=>$this->logged_in_user, "model"=>$this->model])->with(["message"=>$message, "alert_type" => $alert_type]);
	}

}
