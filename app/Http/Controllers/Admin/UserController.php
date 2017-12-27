<?php namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Model\User;

class UserController extends Controller {

	protected function init()
	{
		parent::init();

		$this->model = new User();

		// 新規追加画面、デフォルトの価値を定義
		$this->model->organization_id 		= $this->organization_id;
		$this->url_pattern = "admin.user";
		$this->data["url_pattern"] = "/admin/user";
		$this->logical_delete = true;
	}

	public function index()
	{
		$url = $this->url_pattern . '.index';

		$data["logged_in_user"] = $this->logged_in_user;

		$keyword = null;
		if(isset($this->form_input["keyword"])){
			$keyword = $this->form_input["keyword"];
		}
		$this->data["keyword"] = $keyword;

		$arrUsers = $this->getUsers(true, NULL, NULL, NULL, $keyword);

		return view("/" . str_replace(".", "/", $url), ['data'=>$this->data, "logged_in_user"=>$this->logged_in_user, "arrUsers"=>$arrUsers]);
	}

	public function add()
	{
		$arrSelectSessions = $this->getSelectSessions();
		$this->data["arrSelectSessions"] = $arrSelectSessions;

		if($this->logged_in_user->permission_flag == "Manager"){
			return parent::add();
		}else{
			return redirect("/" . str_replace(".", "/", $this->url_pattern))->with(["message"=>"ユーザーの追加修正削除に関しては、システム管理者までお問い合わせください。"]);
		}
	}

	public function edit($id)
	{
		$url = $this->url_pattern . '.edit';

		$this->model = $this->model->where("id", $id);
		$this->model = $this->model->where("organization_id", \Auth::user()->organization_id);
		$this->model = $this->model->first();

		$arrSelectSessions = $this->getSelectSessions();
		$this->data["arrSelectSessions"] = $arrSelectSessions;

		$message = NULL;
		$alert_type = NULL;

		if(!$this->model){
			return redirect("/" . str_replace(".", "/", $this->url_pattern) . '/add')->with(["message"=>"ユーザーが存在していませんから、ユーザー追加画面に遷移しました。", "alert_type" => $alert_type]);
		}

		if($this->form_input){ // Submit
			$is_manager = $this->logged_in_user->permission_flag;
			if(($is_manager == "Manager") || ($this->logged_in_user->id == $this->form_input["id"])){
				if(empty($this->form_input["password"])){
					unset($this->form_input["password"]);
				}

				if(isset($this->form_input["permission_flag"])){
					$this->form_input["permission_flag"] = "Manager";
				}else{
					$this->form_input["permission_flag"] = "Member";
				}

				$this->model->fill($this->form_input);
				$this->model->update();
				$alert_type = "success";
				$message = "修正完了。";
			}else{
				$message = "ユーザーの追加修正削除に関しては、システム管理者までお問い合わせください。";
			}
		}

		return view("/" . str_replace(".", "/", $url), ['data'=>$this->data, "logged_in_user"=>$this->logged_in_user, "model"=>$this->model, "arrSelectSessions"=>$arrSelectSessions])->with(["message"=>$message, "alert_type" => $alert_type]);
	}

	public function getSelectSessions($id = NULL, $name = NULL)
	{
		$arrSessions = parent::getSessions($id, $name);
		$arrResult = array();
		$arrItems = array();
		$arrDeletedItemStyles = array();

		foreach ($arrSessions as $key => $session) {
			$arrItems[$session->id] = $session->name;

			if($session->is_deleted){
				$arrDeletedItemStyles[$session->id] = array("class" => "w3-gray");
			}
		}

		$arrResult["items"] = $arrItems;
		$arrResult["deletedItemStyles"] = $arrDeletedItemStyles;

		return $arrResult;
	}
}
