<?php namespace App\Http\Controllers\Api\User;

use App\Model\Session;

class SessionController extends \App\Http\Controllers\Api\Controller {

	protected function init()
	{
		parent::init();

		$this->model = new Session();

		// 新規追加画面、デフォルトの価値を定義
		$this->model->organization_id 		= $this->organization_id;
		$this->url_pattern = "manage.session";
		$this->data["url_pattern"] = "/manage/session";
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

		$arrSessions = $this->getSessions(true, NULL, NULL, $keyword);

		return $this->toJson($arrSessions);
	}

}
