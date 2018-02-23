<?php namespace App\Http\Controllers\Api\Master;

use App\Model\User;

class UserController extends Controller {

	protected function init()
	{
		parent::init();

		$this->model = new User();

	}

	public function getModelList()
	{

		$keyword = null;
		if(isset($this->form_input["keyword"])){
			$keyword = $this->form_input["keyword"];
		}
		$this->data["keyword"] = $keyword;

		$arrUsers = $this->getUsers(true, NULL, NULL, NULL, $keyword);

		return parent::getModelList();
	}

	// protected function querySetup()
	// {
	// }

}
