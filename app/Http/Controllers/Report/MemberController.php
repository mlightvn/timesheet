<?php namespace App\Http\Controllers\Report;

class MemberController extends Controller {

	protected function init()
	{
		parent::init();

		$this->blade_url = $this->url_pattern . '.member';
		$this->data["url_pattern"] = "/" . str_replace(".", "/", $this->blade_url);

	}

	public function index()
	{
		$url = $this->blade_url;
		$this->data["title"] 					= __("screen.menu.report.summary_by_member");

		return view($url, ["data"=>$this->data
						, "logged_in_user" 					=> $this->logged_in_user
				]);

	}

}
