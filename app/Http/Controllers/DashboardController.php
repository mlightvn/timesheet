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

	public function dashboard()
	{
		$url = $this->url_pattern . '.index';

		$workDateTime = $this->getCurrentWorkDateTime();
		if(!$workDateTime){
			$workDateTime = new \App\Model\WorkDateTime();
		}

		return view($url, ['data'=>$this->data, "logged_in_user"=>$this->logged_in_user, 'workDateTime'=>$workDateTime]);
	}

}
