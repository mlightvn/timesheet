<?php namespace App\Http\Controllers;

class DashboardController extends Controller {

	protected function init()
	{
		// $this->middleware('auth');
		$this->middleware('admin');

		parent::init();

		$this->url_pattern 					= "dashboard";
		$this->data["url_pattern"] 			= "/dashboard";
	}

}
