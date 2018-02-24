<?php namespace App\Http\Controllers\User;

// use Illuminate\Http\Request;
use App\Model\User;

class UserController extends Controller {

	protected function init()
	{
		parent::init();

		$this->model = new User();

		// 新規追加画面、デフォルトの価値を定義
		$this->model->organization_id 			= $this->organization_id;
		$this->url_pattern 						= "user.user";
		$this->data["url_pattern"] 				= "/user/user";
	}

	public function edit($id)
	{
		$id = \Auth::id(); // current logged in user only.

		return parent::edit($id);
	}

}
