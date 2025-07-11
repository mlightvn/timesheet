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
		$this->data["title"] 					= __("screen.user.list");

	}

	public function list()
	{
		if($this->organization_id == 1){
			$allow_adding = true;
		}else{
			$organization = \App\Model\Organization::find($this->organization_id);
			$member_limitation = $organization->member_limitation;
			$user_list = new \App\Model\User();
			$user_list = $user_list->where("organization_id", $this->organization_id);
			$member_amount = $user_list->count();

			$allow_adding = false;
			if(
					($member_amount < $member_limitation)
				 && (in_array($this->logged_in_user->role, array("Owner", "Manager")))
			){
				$allow_adding = true;
			}

		}

		$this->data["allow_adding"] = $allow_adding;

		return parent::list();
	}

	public function add()
	{
		if($this->organization_id == 1){
			$allow_adding = true;
		}else{
			$arrSelectSessions = $this->getSelectDepartments();
			$this->data["arrSelectSessions"] 		= $arrSelectSessions;
			$this->data["title"] 					= __("screen.user.add");

			$organization = \App\Model\Organization::find($this->organization_id);
			$member_limitation = $organization->member_limitation;
			$user_list = new \App\Model\User();
			$user_list = $user_list->where("organization_id", $this->organization_id);
			$member_amount = $user_list->count();

			if($member_amount < $member_limitation){
				$allow_adding = true;
			}else{
				$allow_adding = false;
			}
		}

		if($allow_adding){
			$role = $this->logged_in_user->role;
			if(in_array($role, array("Owner", "Manager"))){
				return parent::add();
			}else{
				return redirect("/" . str_replace(".", "/", $this->url_pattern))->with(["message"=>"ユーザーの追加修正削除に関しては、システム管理者までお問い合わせください。"]);
			}
		}else{
			return redirect("/" . str_replace(".", "/", $this->url_pattern))->with(["message"=>"Limitation for user amount. Please register for more users."]);
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
		$exist_flag = ($this->model) ? true : false;

		if(!$exist_flag){
			return redirect("/" . str_replace(".", "/", $this->url_pattern) . '/add')->with(["message"=>"ユーザーが存在していませんので、ユーザー追加画面に遷移しました。", "alert_type" => $alert_type]);
		}

		// get session list
		$arrSelectSessions = $this->getSelectDepartments();
		$this->data["arrSelectSessions"] = $arrSelectSessions;

		// Submit
		if($this->form_input){
			$role = $this->logged_in_user->role;

			if(($this->model instanceof \App\Model\User) && ($this->logged_in_user->id != 1) && ($id == 1))
			{

				// $alert_type = "alert";
				$message = "Permission Denied.";

			}else{
				$is_allow_edit = (
						in_array($role, array("Owner", "Manager"))
						|| ($this->logged_in_user->id == $id)
					);

				if($is_allow_edit){
					if(empty($this->form_input["password"])){
						unset($this->form_input["password"]);
					}

					$this->model->fill($this->form_input);
					$this->model->update();
					$alert_type = "success";
					$message = __("message.status.done.edit");
				}else{
					$message = "ユーザーの追加修正削除に関しては、システム管理者までお問い合わせください。";
				}

			}

		}

		$this->data["title"] 					= __("screen.user.edit");
		return view("/" . str_replace(".", "/", $url), ['data'=>$this->data, "logged_in_user"=>$this->logged_in_user, "model"=>$this->model, "arrSelectSessions"=>$arrSelectSessions])->with(["message"=>$message, "alert_type" => $alert_type]);
	}

	public function editUserInfo($id)
	{
		$url = $this->url_pattern . '.user_info';
		$this->model = $this->model->find($id);

		$arrSelectSessions = $this->getSelectDepartments();
		$this->data["arrSelectSessions"] = $arrSelectSessions;

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
		if($this->logged_in_user->role == "Owner"){
			$allow_change_permission = true;
		}else{
			if(in_array($this->logged_in_user->role, array("Manager"))){
				if(in_array($this->model->role, array("Manager", "Member"))){
					$allow_change_permission = true;
				}
			}
		}
		$this->data["allow_change_permission"] = $allow_change_permission;

		if($this->form_input){ // Submit
			$role = $this->logged_in_user->role;
			if((in_array($role, array("Owner", "Manager"))) || ($this->logged_in_user->id == $this->form_input["id"])){

				$this->model->fill($this->form_input);
				$this->model->update();
				$alert_type = "success";
				$message = __("message.status.done.edit");
			}else{
				$message = "ユーザーの追加修正削除に関しては、システム管理者までお問い合わせください。";
			}
		}

		$this->data["title"] 					= __("screen.user.info");

		return view("/" . str_replace(".", "/", $url), ['data'=>$this->data, "logged_in_user"=>$this->logged_in_user, "model"=>$this->model, "arrSelectSessions"=>$arrSelectSessions])->with(["message"=>$message, "alert_type" => $alert_type]);
	}

	public function getSelectDepartments($id = NULL, $name = NULL)
	{
		$arrSessions = parent::getDepartments($id, $name);
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

		$this->model = $this->model->join("department", "department.id", "=", "users.department_id");
		$this->model = $this->model->where("users.id", "=", $id);
		$this->model = $this->model->select([
				"users.*",
				\DB::raw("department.name AS department_name"),
		]);
		$this->model = $this->model->first();

		// get session list
		$arrSelectSessions = $this->getSelectDepartments();
		$this->data["arrSelectSessions"] = $arrSelectSessions;

		if(!$this->model){
			return redirect("/" . str_replace(".", "/", $this->url_pattern))->with(["message"=>"データが存在していませんので、追加画面に遷移しました。", "alert_type" => $alert_type]);
		}

		$this->data["title"] 					= __("screen.user.view");

		return view($this->blade_url, ['data'=>$this->data, "logged_in_user"=>$this->logged_in_user, "model"=>$this->model, "arrSelectSessions"=>$arrSelectSessions]);

	}

	public function language()
	{
		$id = $this->logged_in_user->id;
		$url = $this->url_pattern . '.language';
		$this->model = $this->model->find($id);
		$arrSelectSessions = $this->getSelectDepartments();
		$this->data["arrSelectSessions"] = $arrSelectSessions;

		$message = NULL;
		$alert_type = NULL;

		if(!$this->model){
			return redirect("/" . str_replace(".", "/", $this->url_pattern) . '/add')->with(["message"=>"ユーザーが存在していませんから、ユーザー追加画面に遷移しました。", "alert_type" => $alert_type]);
		}

		if(isset($this->form_input) && isset($this->form_input["language"])){ // Submit
			$language = $this->form_input["language"];
			\App::setLocale($language);


			$this->model->language = $this->form_input["language"];
			$this->model->update();

			$alert_type = "success";
			$message = __("message.status.done.edit");

		}

		return view("/" . str_replace(".", "/", $url), ['data'=>$this->data, "logged_in_user"=>$this->logged_in_user, "model"=>$this->model, "arrSelectSessions"=>$arrSelectSessions])->with(["message"=>$message, "alert_type" => $alert_type]);
	}

}
