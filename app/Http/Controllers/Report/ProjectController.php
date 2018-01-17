<?php namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Model\Project;
use App\Model\WorkingDate;
use App\Model\WorkingTime;

class ProjectController extends Controller {

	// protected $requestYear = "";
	// protected $sRequestMonth = "";
	protected $sRequestYearMonth = ""; //yyyy-mm
	private $sDbRequestDate;
	private $lastDayOfMonth;

	protected function init()
	{
		parent::init();

		$this->blade_url = $this->url_pattern . '.project';
		$this->data["url_pattern"] = "" . str_replace(".", "/", $this->blade_url);

		$form_input = $this->form_input;
		if(isset($form_input["year_month"])){
			$this->sRequestYearMonth = $this->form_input["year_month"];
		}

		if(isset($form_input["user_id"])){
			$this->user_id = $this->form_input["user_id"];
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

		$total_working_minutes = 0;

		$arrTasks = $this->getProjectSheet($report_user_id, $this->requestYear, $this->requestMonth);

		$arrOffTaskSheet = array();
		$arrOnTaskSheet = array();
		$arrOffTaskSheet["task"] = array();
		$arrOnTaskSheet["task"] = array();
		$arrOffTaskSheet["total_minutes"] = 0;
		$arrOnTaskSheet["total_minutes"] = 0;
		$arrOffTaskSheet["total_working_hours_label"] = "";
		$arrOnTaskSheet["total_working_hours_label"] = "";

		foreach ($arrTasks as $key => $oTask) {
			$iWorkingMinutes = intval($oTask->total_working_minutes);
			if($oTask->is_off_task == 1){
				$arrOffTaskSheet["task"][$oTask->id] = $oTask;
				$arrOffTaskSheet["total_minutes"] += $iWorkingMinutes;
			}else{
				$arrOnTaskSheet["task"][$oTask->id] = $oTask;
				$arrOnTaskSheet["total_minutes"] += $iWorkingMinutes;
			}
			$total_working_minutes += $iWorkingMinutes;
		}
		$total_working_hours_label = $this->minutes2HourLabel($total_working_minutes, "%02d時%02d分");
		$arrOffTaskSheet["total_working_hours_label"] = $this->minutes2HourLabel($arrOffTaskSheet["total_minutes"], "%02d時%02d分");
		$arrOnTaskSheet["total_working_hours_label"] = $this->minutes2HourLabel($arrOnTaskSheet["total_minutes"], "%02d時%02d分");

		$arrTaskSheet = array();
		$arrTaskSheet["off_task"] = $arrOffTaskSheet;
		$arrTaskSheet["on_task"] = $arrOnTaskSheet;
		$arrTaskSheet["total_working_minutes"] = $total_working_minutes;
		$arrTaskSheet["total_working_hours_label"] = $total_working_hours_label;

		// Assign variables for user screen
		$data = $this->data;

		$data["lastDayOfMonth"] = $this->lastDayOfMonth;
		$data["sRequestYearMonth"] = $this->sRequestYearMonth;

		$data["arrTaskSheet"] = $arrTaskSheet;
		$data["total_working_hours_label"] = $total_working_hours_label;
		$data["total_working_minutes"] = $total_working_minutes;

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
						"arrTaskSheet" 						=> $this->data["arrTaskSheet"],
						"total_working_hours_label" 		=> $total_working_hours_label,
						"total_working_minutes" 			=> $total_working_minutes,
						"report_user_id"					=> $this->reportUser->id,
				]);
	}

}
