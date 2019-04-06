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

	public function aboutme()
	{
		$html = "My LinkedId: <a href=\"https://www.linkedin.com/in/nguyenngocnam/\">https://www.linkedin.com/in/nguyenngocnam/</a><br><br>";
		$html .= "<a href=\"/\">Homepage</a>";
		return $html;
	}

	public function price()
	{
		return view("price");
	}

}
