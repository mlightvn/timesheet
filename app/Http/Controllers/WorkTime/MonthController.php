<?php namespace App\Http\Controllers\WorkTime;

class MonthController extends Controller {

	protected function init()
	{
		parent::init();

		$this->blade_url = $this->url_pattern . '.month';
		$this->data["url_pattern"] = "/" . str_replace(".", "/", $this->blade_url);

	}

	public function index()
	{
		$url = $this->blade_url;
		$data = $this->data;
		if(isset($this->form_input["user_id"])){
			$data["user_id"] = $this->form_input["user_id"];
		}else{
			$data["user_id"] = $this->user_id;
		}

		$this->data = $data;
		return view($url, ["data"=>$this->data
						, "logged_in_user" 					=> $this->logged_in_user
				]);

	}

}
