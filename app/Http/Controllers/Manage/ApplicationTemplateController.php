<?php namespace App\Http\Controllers\Manage;

use App\Model\ApplicationTemplate;

class ApplicationTemplateController extends Controller {

	protected function init()
	{
		parent::init();

		$this->model = new ApplicationTemplate();

		// 新規追加画面、デフォルトの価値を定義
		$this->model->organization_id 		= $this->organization_id;
		$this->url_pattern = "manage.application-template";
		$this->data["url_pattern"] = "/manage/application-template";
	}

}
