<?php namespace App\Http\Controllers\Api\Manage;

use Illuminate\Http\Request;
use App\Model\Department;

class DepartmentController extends \App\Http\Controllers\Api\Controller {

	protected function init()
	{
		parent::init();

		$this->model = new Department();

		// 新規追加画面、デフォルトの価値を定義
		$this->model->organization_id 		= $this->organization_id;
		$this->url_pattern = "manage.department";
		$this->data["url_pattern"] = "/manage/department";
		$this->logical_delete = true;
	}

	public function list()
	{
		$url = $this->url_pattern . '.index';

		$keyword = null;
		if(isset($this->form_input["keyword"])){
			$keyword = $this->form_input["keyword"];
		}
		$this->data["keyword"] = $keyword;

		$arrSessions = $this->getDepartments(true, NULL, NULL, $keyword);

		return $this->toJson($arrSessions);
	}

}
