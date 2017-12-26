<?php namespace App\Http\Controllers\Admin\Profile;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Model\Organization;

class OrganizationController extends AdminController {

	protected function init()
	{
		parent::init();

		$this->model = new Organization();

		// 新規追加画面、デフォルトの価値を定義
		if($this->logged_in_user->organization_id){
			$this->model->organization_id 		= $this->logged_in_user->organization_id;
		}
		$this->url_pattern = "admin.profile.organization";
		$this->data["url_pattern"] = "/admin/profile/organization";
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

	public function edit($id = NULL)
	{
		$url = $this->url_pattern . '.edit';

		$organization_id = \Auth::user()->organization_id | null;

		if(!$organization_id){ // 新規追加の場合 ($organization_idが存在していないので)
			// return parent::add();
		}else{ // 修正の場合
			$this->model = $this->model->find($organization_id);
		}

		$message = NULL;
		$alert_type = NULL;

		if(!$this->model){
			$this->model = new Organization();
			return redirect("/" . str_replace(".", "/", $this->url_pattern) . '/edit')->with(["message"=>"企業が存在していませんから、企業追加画面に遷移しました。", "alert_type" => $alert_type]);
		}

		if($this->form_input){ // Submit
			$permission_flag = $this->logged_in_user->permission_flag;
			$is_manager = in_array($permission_flag, array("Administrator", "Manager"));
			if($is_manager){
				$this->model->fill($this->form_input);
				$this->model->save();

				$organization_id = \Auth::user()->organization_id;
				if(is_null($organization_id)){
					$organization_id = $this->model->id;

					$user = new \App\Model\User();
					$user = $user->find(\Auth::user()->id);
					$user->organization_id = $organization_id;
					$user->update();
				}

				$alert_type = "success";
				$message = "修正完了。";
			}else{
				$message = "企業の追加修正削除に関しては、システム管理者までお問い合わせください。";
			}
		}

		return view("/" . str_replace(".", "/", $url), ['data'=>$this->data, "logged_in_user"=>$this->logged_in_user, "model"=>$this->model])->with(["message"=>$message, "alert_type" => $alert_type]);
	}

}
