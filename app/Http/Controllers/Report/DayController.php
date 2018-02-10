<?php namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Model\Project;
// use App\Model\WorkingDate;
// use App\Model\WorkingTime;
// use App\Model\ApplicationForm;

class DayController extends Controller {

	// protected $sRequestYearMonth = ""; //yyyy-mm
	// private $sDbRequestDate;
	// private $lastDayOfMonth;

	protected function init()
	{
		parent::init();

		$this->blade_url = $this->url_pattern . '.day';
		$this->data["url_pattern"] = "/" . str_replace(".", "/", $this->blade_url);

		// $form_input = $this->form_input;
		// if(isset($form_input["year_month"])){
		// 	$this->sRequestYearMonth = $this->form_input["year_month"];
		// }

		// if(empty($this->sRequestYearMonth)){
		// 	$date = date("Y-m-t");
		// }else{
		// 	$date = $this->sRequestYearMonth . "-01";
		// 	$date = date("Y-m-t", strtotime($date));
		// }
		// $arrDate = explode("-", $date);

		// $this->requestYear 					= $arrDate[0];
		// $this->requestMonth 				= $arrDate[1];

		// $this->sDbRequestDate 				= $date;
		// $this->sRequestYearMonth 			= $arrDate[0] . "-" . $arrDate[1];
		// $this->lastDayOfMonth 				= end($arrDate);
	}

	public function index()
	{
		$url = $this->blade_url;
		return view($url, ["data"=>$this->data
						, "logged_in_user" 					=> $this->logged_in_user
				]);

	}

}
