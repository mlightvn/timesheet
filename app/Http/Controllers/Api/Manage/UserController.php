<?php namespace App\Http\Controllers\Api\Manage;

use Illuminate\Http\Request;
use App\Model\User;

class UserController extends \App\Http\Controllers\Api\Controller {

	protected function init()
	{
		parent::init();

		$this->model = new User();

		// 新規追加画面、デフォルトの価値を定義
		$this->model->organization_id 		= $this->organization_id;
	}

	public function list()
	{

		$keyword = null;
		if(isset($this->form_input["keyword"])){
			$keyword = $this->form_input["keyword"];
		}
		$this->data["keyword"] = $keyword;

		$arrUsers = $this->getUsers(true, NULL, NULL, NULL, $keyword);

		return $this->toJson($arrUsers);
	}

}
