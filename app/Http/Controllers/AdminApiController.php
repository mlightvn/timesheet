<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminApiController extends AdminController {


	protected $administrator;
	protected $redirectTo = '/admin';
	protected $model;
	protected $logical_delete = false;

	protected function init()
	{
		parent::init();

		$this->url_pattern = "admin.api";
	}

	public function list($objectType = "users", $keyword = NULL, $where = NULL)
	{
		$objectType = "\\App\\Model\\" . ucfirst($objectType);
		$this->model = new $objectType;

		if(!$where){
			if(isset($keyword)){
				$keyword = str_replace("'", "''", $keyword);
				$where = "((name LIKE '%{KEYWORD}%') OR (id LIKE '%{KEYWORD}%'))";
				$where = str_replace("{KEYWORD}", $keyword, $where);

				$this->model = $this->model->whereRaw($where);
			}
		}else{
			$this->model = $this->model->whereRaw($where);
		}

		$this->model = $this->model->get();
		$json = $this->model->toJson();

		return $json;
	}

	public function get($objectType = "users", $id = NULL)
	{
		$objectType = "\\App\\Model\\" . ucfirst($objectType);
		$this->model = new $objectType;

		if($id){
			$this->model = $this->model->find($id);
		}else{
			$this->model = $this->model->get();
		}

		$json = $this->model->toJson();

		return $json;
	}

	public function add($objectType = "users")
	{
		$objectType = "\\App\\Model\\" . ucfirst($objectType);
		$this->model = new $objectType;

		$arrRet = array("status" => "error", "message" => "追加エラー");

		if($this->form_input && (count($this->form_input) > 0)){ // Submit
			$form_input = $this->form_input;

$ele = \Illuminate\Support\Facades\Input::get('is_off_task');
$json = json_encode($ele);
return $json;
			$this->model->fill($this->form_input);
			$this->model->save(); //insert
			$arrRet["status"] = "success";
			$arrRet["message"] = "追加完了。";
		}
		$json = json_encode($arrRet);

		return $json;
	}

	public function edit($objectType = "users", $id = NULL)
	{
		$objectType = "\\App\\Model\\" . ucfirst($objectType);
		$this->model = new $objectType;

		$arrRet = array("status" => "error", "message" => "修正エラー");

		$this->model = $this->model->find($id);

		if(!$this->model){
			$arrRet = array("status" => "not_exist", "message" => "データ（ID: " . $id . "）が存在していません。");
		}elseif($this->form_input){ // Submit
			$form_input = $this->form_input;

			$this->model->fill($this->form_input);
			$this->model->update();
			$arrRet = array("status" => "success", "message" => "データ（ID: " . $id . "）が修正完了。");
		}

		$json = json_encode($arrRet);
		return $json;
	}

	public function delete($objectType = "users", $id = NULL)
	{
		$objectType = "\\App\\Model\\" . ucfirst($objectType);
		$this->model = new $objectType;

		$arrRet = array("status" => "error", "message" => "修正エラー");

		$this->model = $this->model->find($id);

		if(!$this->model){
			$arrRet = array("status" => "not_exist", "message" => "データ（ID: " . $id . "）が存在していません。");
		}

		if($this->logged_in_user->permission_flag != "Manager"){
			$arrRet = array("status" => "no_delete_permision", "message" => "権限がありませんので、データ（ID: " . $id . "）が削除できません。");
		}else{
			$physical_delete = $this->form_input["physical_delete"];
			if(in_array($physical_delete, array("1", "On", "ON", "true", "TRUE", "True"))){
				$this->model->delete();
			}else{
				$this->model->is_deleted = 1;
				$this->model->update();
			}
			$arrRet = array("status" => "success", "message" => "データ（ID: " . $id . "）が削除完了。");
		}

		$json = json_encode($arrRet);
		return $json;
	}

	public function recover($objectType = "users", $id = NULL)
	{
		$objectType = "\\App\\Model\\" . ucfirst($objectType);
		$this->model = new $objectType;

		$arrRet = array("status" => "error", "message" => "修正エラー");

		$this->model = $this->model->find($id);

		if(!$this->model){
			$arrRet = array("status" => "not_exist", "message" => "データ（ID: " . $id . "）が存在していません。");
		}

		if($this->logged_in_user->permission_flag != "Manager"){
			$arrRet = array("status" => "no_permision", "message" => "権限がありませんので、データ（ID: " . $id . "）が復元できません。");
		}else{
			$this->model->is_deleted = 0;
			$this->model->update();

			$arrRet = array("status" => "no_permision", "message" => "データ（ID: " . $id . "）が復元完了。");
		}

		$json = json_encode($arrRet);
		return $json;
	}

}
