<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Task;
use App\Model\WorkingDate;
use App\Model\WorkingTime;

class AdminReportMonthController extends AdminReportController {

	private $sDbRequestDate;

	protected $arrMonth = [
		1			=> "1月",
		2			=> "2月",
		3			=> "3月",
		4			=> "4月",
		5			=> "5月",
		6			=> "6月",
		7			=> "7月",
		8			=> "8月",
		9			=> "9月",
		10			=> "10月",
		11			=> "11月",
		12			=> "12月",
	];

	protected function init()
	{
		parent::init();

		$this->blade_url = $this->url_pattern . '.month';
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
