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

		$arrTasks = $this->model->getAllList($this->user_id, $keyword);

		return $this->toJson($arrTasks);
	}
}
