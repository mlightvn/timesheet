<?php namespace App\Http\Controllers\Api\Report;

use Illuminate\Http\Request;
use App\Model\WorkingDate;
use App\Model\WorkingTime;
use App\Model\ApplicationForm;

class DayController extends \App\Http\Controllers\Api\Controller {

	protected $sRequestYearMonth = ""; //yyyy-mm
	private $sDbRequestDate;
	private $lastDayOfMonth;

	protected function init()
	{
		parent::init();

		$this->blade_url = $this->url_pattern . '.day';
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

		$this->requestYear 					= $arrDate[0];
		$this->requestMonth 				= $arrDate[1];

		$this->sDbRequestDate 				= $date;
		$this->sRequestYearMonth 			= $arrDate[0] . "-" . $arrDate[1];
		$this->lastDayOfMonth 				= end($arrDate);
	}

	public function list()
	{
		$user_id = $this->user_id;

		$total_working_hours = 0;
		$total_working_minutes = 0;

		$arrWorkingMinutes = $this->getWorkingMinutes($this->sRequestYearMonth);
		$arrWorkingDays = array();

		$arrHolidayList = $this->getHolidays($this->sRequestYearMonth);
		$is_holiday_data_exist = (count($arrHolidayList) > 0);

		$application_form_list = $this->getApplicationFormList($user_id, $this->sRequestYearMonth);

		// arrWorkingDays
		for ($day=1; $day <= $this->lastDayOfMonth; $day++) {
			$day_data = array();
			$date = $this->sRequestYearMonth . "-" . $day;
			$day_data["date"] = $date;
			if($is_holiday_data_exist){
				$holiday = $arrHolidayList[$day - 1];
				$day_data["is_holiday"] = $holiday->is_holiday;
				$day_data["name"] = $holiday->name;
			}else{
				$day_data["is_holiday"] = $this->isWeekend($date); //週末、休日、祭り、…
				$day_data["name"] = "";
			}
			$day_data["day"] = $day;
			$day_data["minutes"] = 0;
			$day_data["hour_label"] = "00:00";
			$day_data["TIME_PAGE_URL"] = "/report/time?date=" . $this->sRequestYearMonth . "-" . $day;

			if(isset($application_form_list[$day])){
				$day_data["application_title"] = $application_form_list[$day]->name;
			}else{
				$day_data["application_title"] = "";
			}

			if($day_data["is_holiday"]){
				$day_data["status_color"] = "w3-gray";
				$day_data["hour_color"] = "w3-text-green";
			}else{
				// $day_data["status_color"] = "";
				$day_data["hour_color"] = "w3-text-red";
			}

			$arrWorkingDays[$day] = $day_data;

		}

		foreach ($arrWorkingMinutes as $key => $oWorkingMinutes) {
			if($oWorkingMinutes->total_working_minutes > 0){
				$total_working_minutes += intval($oWorkingMinutes->total_working_minutes);
				$total_working_hours += intval($oWorkingMinutes->total_working_minutes);
				$arrWorkingDays[$oWorkingMinutes->day]["minutes"] = intval($oWorkingMinutes->total_working_minutes);
				$arrWorkingDays[$oWorkingMinutes->day]["hour_label"] = $oWorkingMinutes->total_working_hours_label;

				if($total_working_minutes >= 480){ // >= 8 hours or holiday
					// $arrWorkingDays[$oWorkingMinutes->day]["status_color"] = "";
					$arrWorkingDays[$oWorkingMinutes->day]["hour_color"] = "w3-text-green";
				}
			}
		}

		// $total_working_hours *= 60;
		$total_working_hours_label = $this->minutes2HourLabel($total_working_hours, "%02d時%02d分");

		// Assign variables for user screen
		$data = array();

		$data["lastDayOfMonth"] 					= $this->lastDayOfMonth;
		$data["sRequestYearMonth"] 					= $this->sRequestYearMonth;

		$data["arrWorkingDays"] 					= $arrWorkingDays;
		$data["total_working_hours_label"] 			= $total_working_hours_label;
		$data["total_working_minutes"] 				= $total_working_minutes;

		$return_data["data"] 						= $data;

		return $this->toJson($return_data);
	}

	private function getApplicationFormList($applied_user_id, $applied_year_month)
	{
		$model = new ApplicationForm();

		$model = $model->join("application_date", function($join){
			$join->on("application_date.application_form_id", 		"=", "application_form.id")
				 ->on("application_date.organization_id", 			"=", "application_form.organization_id")
			;
		});

		$model = $model->where("application_form.applied_user_id", "=", $applied_user_id);
		$model = $model->where("application_form.date_list", "LIKE", "%" . $applied_year_month . "%");
		$model = $model->where("application_form.status", "=", "1"); //Approve

		$model = $model->select([
			"application_form.*",
			"application_date.applied_date",
			\DB::raw("DAY(application_date.applied_date) AS 'APPLIED_DAY'"),
		]);

		$model_list = $model->get();

		$return_list = array();
		foreach ($model_list as $key => $model) {
			$return_list[$model["APPLIED_DAY"]] = $model;
		}

		return $return_list;
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
		$dbWorkingDate = $dbWorkingDate->join("project", "working_date.project_id", "=", "project.id");

		$dbWorkingDate = $dbWorkingDate->where("working_date.user_id", "LIKE", $this->logged_in_user->id);
		$dbWorkingDate = $dbWorkingDate->where("working_date.date", "LIKE", $year_month . "%");
		$dbWorkingDate = $dbWorkingDate->where("users.is_deleted", "=", "0");
		$dbWorkingDate = $dbWorkingDate->where("project.is_deleted", "=", "0");

		$dbWorkingDate = $dbWorkingDate->groupBy(["working_date.date", "working_date.user_id"]);

		$arrReturn = $dbWorkingDate->get();

		return $arrReturn;
	}

}
