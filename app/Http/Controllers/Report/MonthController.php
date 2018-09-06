<?php namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Model\Project;
use App\Model\WorkingDate;
use App\Model\WorkingTime;

class MonthController extends Controller {

	private $sDbRequestDate;

	protected $arrMonth = [
		"01"			=> "01月",
		"02"			=> "02月",
		"03"			=> "03月",
		"04"			=> "04月",
		"05"			=> "05月",
		"06"			=> "06月",
		"07"			=> "07月",
		"08"			=> "08月",
		"09"			=> "09月",
		"10"			=> "10月",
		"11"			=> "11月",
		"12"			=> "12月",
	];

	protected function init()
	{
		parent::init();

		$this->blade_url = $this->url_pattern . '.month';
		$this->data["url_pattern"] = "/" . str_replace(".", "/", $this->blade_url);

		if(isset($this->form_input["year"])){
			$this->requestYear = $this->form_input["year"];
		}else{
			$this->requestYear = date("Y");
		}
	}

	public function index()
	{
		$user_id = $this->user_id;

		// Assign variables for user screen
		$data = $this->data;

		$data["arrMonth"] = $this->arrMonth;
		$data["title"] 					= __("message.menu.report.summary_by_month");

		$this->data = $data;

		return view("/" . str_replace(".", "/", $this->blade_url)
						, [
								'data'=>$this->data
								, "logged_in_user" => $this->logged_in_user
								, "requestYear"=> $this->requestYear
								, "sDbRequestDate"=> $this->sDbRequestDate
								, "arrMonth" => $this->arrMonth
						]);
	}

}
