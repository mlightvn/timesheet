<?php namespace App\Http\Controllers\Dayoff;

class Controller extends \App\Http\Controllers\Controller {

	// use AuthenticatesUsers;

	protected $administrator;
	protected $redirectTo = 'dayoff';
	protected $model;

	protected function init()
	{
		parent::init();

		$this->url_pattern = "dayoff";
		$this->data["url_pattern"] = "/dayoff";
	}

}
