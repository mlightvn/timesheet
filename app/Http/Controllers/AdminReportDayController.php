<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Task;
use App\Model\WorkingDate;
use App\Model\WorkingTime;

class AdminReportDayController extends AdminReportController {

	protected $sRequestYearMonth = ""; //yyyy-mm
	private $sDbRequestDate;
	private $lastDayOfMonth;

	protected function init()
	{
		parent::init();

		$this->blade_url = $this->url_pattern . '.day';
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
		$user_id = $this->user_id;

		$total_working_hours = 0;
		$total_working_minutes = 0;

		$arrWorkingMinutes = $this->getWorkingMinutes($this->sRequestYearMonth);
		$arrWorkingDays = array();

		$arrHolidayList = $this->getHolidays($this->sRequestYearMonth);
		$is_holiday_data_exist = (count($arrHolidayList) > 0);

		for ($day=1; $day <= $this->lastDayOfMonth; $day++) {
			$arrWorkingDays[$day] = array();
			$date = $this->sRequestYearMonth . "-" . $day;
			$arrWorkingDays[$day]["date"] = $date;
			if($is_holiday_data_exist){
				$holiday = $arrHolidayList[$day - 1];
				$arrWorkingDays[$day]["is_holiday"] = $holiday->is_holiday;
				$arrWorkingDays[$day]["name"] = $holiday->name;
			}else{
				$arrWorkingDays[$day]["is_holiday"] = $this->isWeekend($date); //週末、休日、祭り、…
				$arrWorkingDays[$day]["name"] = "";
			}
			$arrWorkingDays[$day]["day"] = $day;
			$arrWorkingDays[$day]["minutes"] = 0;
			$arrWorkingDays[$day]["hour_label"] = "00:00";
		}
		foreach ($arrWorkingMinutes as $key => $oWorkingMinutes) {
			if($oWorkingMinutes->total_working_minutes > 0){
				$total_working_minutes += intval($oWorkingMinutes->total_working_minutes);
				$total_working_hours += intval($oWorkingMinutes->total_working_minutes);
				$arrWorkingDays[$oWorkingMinutes->day]["minutes"] = intval($oWorkingMinutes->total_working_minutes);
				$arrWorkingDays[$oWorkingMinutes->day]["hour_label"] = $oWorkingMinutes->total_working_hours_label;
			}
		}

		// $total_working_hours *= 60;
		$total_working_hours_label = $this->minutes2HourLabel($total_working_hours, "%02d時%02d分");

		// Assign variables for user screen
		$data = $this->data;

		$data["lastDayOfMonth"] = $this->lastDayOfMonth;
		$data["sRequestYearMonth"] = $this->sRequestYearMonth;

		$data["arrWorkingDays"] = $arrWorkingDays;
		$data["total_working_hours_label"] = $total_working_hours_label;
		$data["total_working_minutes"] = $total_working_minutes;

		$this->data = $data;

		return view("/" . str_replace(".", "/", $this->blade_url)
				, [
						'data' 								=> $this->data
						, "logged_in_user" 					=> $this->logged_in_user
						, "requestYear" 					=> $this->requestYear
						, "requestMonth" 					=> $this->requestMonth
						, "sRequestYearMonth" 				=> $this->sRequestYearMonth
						, "sDbRequestDate" 					=> $this->sDbRequestDate
						, "lastDayOfMonth" 					=> $this->lastDayOfMonth
						, "arrWorkingDays" 					=> $this->data["arrWorkingDays"]
						, "total_working_hours_label" 		=> $total_working_hours_label
						, "total_working_minutes" 			=> $total_working_minutes
				]);
	}

	public function getWorkingMinutes($year_month)
	{
		$dbWorkingDate = new WorkingDate();

		$dbWorkingDate = $dbWorkingDate->select(\DB::raw("
				YEAR(working_date.date) AS 'year'
				, MONTH(working_date.date) AS 'month'
				, DAY(working_date.date) AS 'day'
				, working_date.date, working_date.user_id, SUM(working_date.working_minutes) AS total_working_minutes
				, CONCAT(LPAD(FLOOR(SUM(working_date.working_minutes) / 60), 2, '0'), ':', LPAD(MOD(SUM(working_date.working_minutes), 60), 2, '0')) AS 'total_working_hours_label'
				"
			));
		$dbWorkingDate = $dbWorkingDate->join("users", "working_date.user_id", "=", "users.id");
		$dbWorkingDate = $dbWorkingDate->join("task", "working_date.task_id", "=", "task.id");

		$dbWorkingDate = $dbWorkingDate->where("working_date.user_id", "LIKE", $this->logged_in_user->id);
		$dbWorkingDate = $dbWorkingDate->where("working_date.date", "LIKE", $year_month . "%");
		$dbWorkingDate = $dbWorkingDate->where("users.is_deleted", "=", "0");
		$dbWorkingDate = $dbWorkingDate->where("task.is_deleted", "=", "0");

		$dbWorkingDate = $dbWorkingDate->groupBy(["working_date.date", "working_date.user_id"]);

		$arrReturn = $dbWorkingDate->get();

		return $arrReturn;
	}

}
