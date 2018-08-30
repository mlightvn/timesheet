<?php namespace App\Http\Controllers\Api\Manage;

use Illuminate\Http\Request;
use App\Model\ProjectTask;

class ProjectTaskController extends \App\Http\Controllers\Api\Controller {

	protected function init()
	{
		parent::init();

		$this->model = new ProjectTask();

		// 新規追加画面、デフォルトの価値を定義
		$this->model->organization_id 		= $this->organization_id;
		$this->url_pattern = "manage.project_task";
		$this->data["url_pattern"] = "/manage/project_task";
		$this->logical_delete = true;
	}

	protected function querySetup()
	{
		$orderBy_a = array();
		$orderBy_a["is_deleted"] 					= "ASC";
		$orderBy_a["id"] 							= "DESC";
		$this->data["request_data"]["orderBy"] 		= $orderBy_a;
	}

	public function list()
	{

		$keyword = null;
		if(isset($this->form_input["keyword"])){
			$keyword = $this->form_input["keyword"];
		}
		$this->data["keyword"] = $keyword;

		$whereCondition = array("user_id"=>$this->user_id, "keyword"=>$keyword);
		$arrTasks = $this->model->getAllList($whereCondition);

		return $this->toJson($arrTasks);
	}

	public function myTask($project_task_id)
	{

		$returnData = array("status"=>0, "message"=>"Done");

		if(!isset($project_task_id)){
			$returnData = array("status"=>1, "message"=>"IDを入力してください。");
		}

		$flag = $this->form_input["flag"];
		if($flag === NULL || $flag === false || $flag == 0 || $flag == 1){
			if($flag == 1){
				$flag = "1";
			}else{
				$flag = "0";
			}
		}

		$user_id = \Auth::id();
		$model = App\Model\UserProjectTask();
		$model = $model->where("project_task_id" , $project_task_id);
		$model = $model->where("user_id" , $user_id);
		$model = $model->delete();

		if($flag){
			$model->save();
		}

		$json = $this->toJson($returnData);
		return $json;

	}

	public function excelFlag($project_task_id)
	{

		$returnData = array("status"=>0, "message"=>"Done");

		if(!isset($project_task_id)){
			$returnData = array("status"=>1, "message"=>"IDを入力してください。");
		}

		$flag = $this->form_input["flag"];
		if($flag === NULL || $flag === false || $flag == 0 || $flag == 1){
			if($flag == 1){
				$flag = "1";
			}else{
				$flag = "0";
			}
		}

		$model = $this->model->find($project_task_id);
		$model->excel_flag = $flag;
		$result = $model->update();
		if($result){
			$returnData = array("status"=>99, "message"=>"Unknownエラー。管理者に連絡してください。");
		}

		$json = $this->toJson($returnData);
		return $json;

	}

}
