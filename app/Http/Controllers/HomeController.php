<?php namespace App\Http\Controllers;

class HomeController extends Controller {

	protected function init()
	{
		// $this->middleware('auth');

		parent::init();

		$this->url_pattern 					= "";
		$this->data["url_pattern"] 			= "/";
	}

	public function introduction()
	{
		return view("introduction");
	}

	public function price()
	{
		return view("price");
	}

}
