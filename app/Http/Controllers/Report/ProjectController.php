<?php namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
// use App\Model\Project;
use App\Model\ProjectTask;

class ProjectController extends Controller {

	protected $sRequestYearMonth = ""; //yyyy-mm
	private $sDbRequestDate;
	private $lastDayOfMonth;

	protected function init()
	{
		parent::init();

		$this->blade_url = $this->url_pattern . '.project';
		$this->data["url_pattern"] = "/" . str_replace(".", "/", $this->blade_url);

		$form_input = $this->form_input;
		if(isset($form_input["year_month"])){
			$this->sRequestYearMonth = $this->form_input["year_month"];
		}

		if(empty($this->sRequestYearMonth)){
			$date = date("Y-m-t");
		}else{
			$date = $this->sRequestYearMonth . "-01";
			$date = date("Y-m-t", strtotime($date));
		}
		$arrDate = explode("-", $date);

		$this->requestYear = $arrDate[0];
		$this->requestMonth = $arrDate[1];

		$this->sDbRequestDate = $date;
		$this->sRequestYearMonth = $arrDate[0] . "-" . $arrDate[1];
		$this->lastDayOfMonth = end($arrDate);
	}

	public function index()
	{
		$report_user_id = $this->reportUser->id;

		$user = \App\Model\User::find($report_user_id);

		$timeSheet = new ProjectTask();
		$timeSheetList = $timeSheet->getTimeSheetList($user, $this->requestYear, $this->requestMonth);

		// Assign variables for user screen
		$data = $this->data;

		$data["lastDayOfMonth"] 						= $this->lastDayOfMonth;
		$data["sRequestYearMonth"] 						= $this->sRequestYearMonth;
		$data["timeSheetList"] 							= $timeSheetList;

		$data["title"] 					= __("screen.menu.report.summary_by_project");

		$this->data = $data;

		return view("/" . str_replace(".", "/", $this->blade_url)
				, [
						"data" 								=> $this->data,
						"logged_in_user" 					=> $this->logged_in_user,
						"requestYear" 						=> $this->requestYear,
						"requestMonth" 						=> $this->requestMonth,
						"sRequestYearMonth" 				=> $this->sRequestYearMonth,
						"sDbRequestDate" 					=> $this->sDbRequestDate,
						"lastDayOfMonth" 					=> $this->lastDayOfMonth,
						"report_user_id"					=> $this->reportUser->id,
				]);
	}

}
