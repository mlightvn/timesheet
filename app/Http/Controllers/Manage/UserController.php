<?php namespace App\Http\Controllers\Manage;

// use Illuminate\Http\Request;
use App\Model\User;

class UserController extends Controller {

	protected function init()
	{
		parent::init();

		$this->model = new User();

		// 新規追加画面、デフォルトの価値を定義
		$this->model->organization_id 			= $this->organization_id;
		$this->url_pattern 						= "manage.user";
		$this->data["url_pattern"] 				= "/manage/user";
	}

	public function add()
	{
		$arrSelectSessions = $this->getSelectSessions();
		$this->data["arrSelectSessions"] 		= $arrSelectSessions;

		$permission_flag = $this->logged_in_user->permission_flag;
		if(in_array($permission_flag, array("Owner", "Manager"))){
			$this->model->permission_flag 		= "Member";
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

		$message = NULL;
		$alert_type = NULL;

		// Check model exist
		$exist_flag = true;
		$exist_flag = ($this->model) ? true : false;
		// Check same organization
		if($exist_flag){
			$exist_flag = (($this->model->organization_id == $this->organization_id) ? true : false);
		}
		if(!$exist_flag){
			return redirect("/" . str_replace(".", "/", $this->url_pattern) . '/add')->with(["message"=>"ユーザーが存在していませんので、ユーザー追加画面に遷移しました。", "alert_type" => $alert_type]);
		}

		// Allow changing permission flag
		$allow_change_permission = false;
		if($this->logged_in_user->permission_flag == "Owner"){
			$allow_change_permission = true;
		}else{
			if(in_array($this->logged_in_user->permission_flag, array("Manager", "Administrator"))){
				if(in_array($this->model->permission_flag, array("Manager", "Administrator", "Member"))){
					$allow_change_permission = true;
				}
			}
		}
		$this->data["allow_change_permission"] = $allow_change_permission;

		// get session list
		$arrSelectSessions = $this->getSelectSessions();
		$this->data["arrSelectSessions"] = $arrSelectSessions;

		// Submit
		if($this->form_input){
			$permission_flag = $this->logged_in_user->permission_flag;

			if(($this->model instanceof \App\Model\User) && ($this->logged_in_user->id != 1) && ($id == 1))
			{

				// $alert_type = "alert";
				$message = "Permission Denied.";

			}else{
				$is_allow_edit = (
						in_array($permission_flag, array("Owner", "Manager"))
						|| ($this->logged_in_user->id == $id)
					);

				if($is_allow_edit){
					if(empty($this->form_input["password"])){
						unset($this->form_input["password"]);
					}

					$this->model->fill($this->form_input);
					$this->model->update();
					$alert_type = "success";
					$message = "修正完了。";
				}else{
					$message = "ユーザーの追加修正削除に関しては、システム管理者までお問い合わせください。";
				}

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

	public function view($id)
	{
		$this->blade_url = $this->url_pattern . '.view';
		$message = NULL;
		$alert_type = NULL;

		$this->model = $this->model->join("session", "session.id", "=", "users.session_id");
		$this->model = $this->model->where("users.id", "=", $id);
		$this->model = $this->model->select([
				"users.*",
				\DB::raw("session.name AS session_name"),
		]);
		$this->model = $this->model->first();

		if(!$this->model){
			return redirect("/" . str_replace(".", "/", $this->url_pattern))->with(["message"=>"データが存在していませんので、追加画面に遷移しました。", "alert_type" => $alert_type]);
		}

		return view($this->blade_url, ['data'=>$this->data, "logged_in_user"=>$this->logged_in_user, "model"=>$this->model]);

	}

}
