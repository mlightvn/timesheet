<?php namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
// use Illuminate\Contracts\Auth\Authenticatable;
// use Illuminate\Contracts\Auth\Guard;
// use Illuminate\Foundation\Auth\AuthenticatesUsers;

// use Illuminate\Foundation\Auth\ThrottlesLogins;

class Controller extends \App\Http\Controllers\Controller {

	// use AuthenticatesUsers;

	protected $administrator;
	protected $redirectTo = '/admin';
	protected $model;

	protected function init()
	{
		parent::init();

		$this->url_pattern = "admin";
		// $this->logical_delete = true;
	}

	// public function dashboard()
	// {
	// 	$url = $this->url_pattern . '.index';

	// 	return view($url, ['data'=>$this->data, "logged_in_user"=>$this->logged_in_user]);
	// }

}
