<?php namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
// use Illuminate\Contracts\Auth\Authenticatable;
// use Illuminate\Contracts\Auth\Guard;
// use Illuminate\Foundation\Auth\AuthenticatesUsers;

// use Illuminate\Foundation\Auth\ThrottlesLogins;

class Controller extends \App\Http\Controllers\Controller {

	// use AuthenticatesUsers;

	// protected $administrator;
	// protected $redirectTo = '/master';
	// protected $model;

	public function getLoggedInUser(){
		$this->logged_in_user = parent::getLoggedInUser();

		if(!isset($this->logged_in_user)){
			abort(404);
		}else{
			$permission_flag = $this->logged_in_user->permission_flag;
			if($permission_flag != "Master"){
				abort(404);
				exit;
			}
		}

		return $this->logged_in_user;
	}

	protected function init()
	{
		parent::init();

		$this->url_pattern = "master";
		// $this->logical_delete = true;
	}

	// public function dashboard()
	// {
	// 	$url = $this->url_pattern . '.index';

	// 	return view($url, ['data'=>$this->data, "logged_in_user"=>$this->logged_in_user]);
	// }

}
