<?php namespace App\Http\Controllers\Manage;

// use Illuminate\Http\Request;

// use Illuminate\Support\Facades\Auth;
// use Illuminate\Contracts\Auth\Authenticatable;
// use Illuminate\Contracts\Auth\Guard;
// use Illuminate\Foundation\Auth\AuthenticatesUsers;

// use Illuminate\Foundation\Auth\ThrottlesLogins;

class Controller extends \App\Http\Controllers\Controller {

	// use AuthenticatesUsers;

	protected $administrator;
	protected $redirectTo = 'manage';
	protected $model;

	protected function init()
	{
		parent::init();

		$this->url_pattern = "manage";
	}

}
