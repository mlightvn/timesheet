<?php namespace App\Http\Controllers\Api\WorkTime;

use Illuminate\Http\Request;
use App\Model\WorkDateTime;
use App\Model\ApplicationForm;

class MonthController extends \App\Http\Controllers\Api\WorkTime\Controller {

	protected $sRequestYearMonth = ""; //yyyy-mm
	private $sDbRequestDate;
	private $lastDayOfMonth;

	protected function init()
	{
		parent::init();

		$form_input = $this->form_input;
		$year = "";
		$month = "";
		$last_day = "";

		if(isset($this->form_input["user_id"])){
			$this->user_id = $this->form_input["user_id"];
		}

		if(isset($form_input["year"])){
			$year = $this->form_input["year"];
		}else{
			$year = date("Y");
		}

		if(isset($form_input["month"])){
			$month = $this->form_input["month"];
		}else{
			$month = date("m");
		}

		$this->sRequestYearMonth = $year . "-" . $month;

		$date = $this->sRequestYearMonth . "-01";
		$date = date("Y-m-t", strtotime($date));
		$last_day = date("t", strtotime($date));

		$this->requestYear 					= $year;
		$this->requestMonth 				= $month;

		$this->sDbRequestDate 				= $date;
		$this->lastDayOfMonth 				= $last_day;
	}

	public function list()
	{

		$user_id = $this->user_id;

		$total_working_hours = 0;
		$total_working_minutes = 0;

		$arrWorkDateTime = $this->getData($user_id, $this->requestYear, $this->requestMonth);
		$arrWorkingDays = array();

		$arrHolidayList = $this->getHolidays($this->sRequestYearMonth);
		$is_holiday_data_exist = (count($arrHolidayList) > 0);

		$application_form_list = $this->getApplicationFormList($user_id, $this->sRequestYearMonth);

		// arrWorkingDays
		for ($day=1; $day <= $this->lastDayOfMonth; $day++) {
			$day_s = str_pad($day, 2, 0, STR_PAD_LEFT);
			$day_data = array();
			$date = $this->sRequestYearMonth . "-" . $day_s;
			$day_data["date"] = $date;
			if($is_holiday_data_exist){
				$holiday = $arrHolidayList[$day - 1];
				$day_data["is_holiday"] = $holiday->is_holiday;
				$day_data["name"] = $holiday->name;
			}else{
				$day_data["is_holiday"] = $this->isWeekend($date); //週末、休日、祭り、…
				$day_data["name"] = "";
			}
			$day_data["day"] = $day_s;
			$day_data["work_hour"] = "00:00:00";
			$day_data["work_hour_label"] = "00:00";
			$day_data["TIME_PAGE_URL"] = "/work-time/month/" . $this->requestYear . "/" . $this->requestMonth;

			if(isset($application_form_list[$day])){
				$day_data["application_title"] = $application_form_list[$day]->name;
			}else{
				$day_data["application_title"] = "";
			}

			// description
			$description = "";
			if($day_data['name']){
				$description = $day_data['name'];
			}
			if($description){
				if($day_data['application_title']){
					$description .= "、" . $day_data['application_title'];
				}
			}else{
				$description = $day_data['application_title'];
			}

			$day_data["description"] = $description;

			// is_holiday
			if($day_data["is_holiday"]){
				$day_data["status_color"] = "w3-gray";
				$day_data["hour_color"] = "w3-text-green";
			}else{
				$day_data["hour_color"] = "w3-text-red";
			}

			$arrWorkingDays[$day] = $day_data;

		}

		foreach ($arrWorkDateTime as $key => $oWorkingMinutes) {
			$arr = $arrWorkingDays[$oWorkingMinutes->day];

			$arr["work_hour"] 				= $oWorkingMinutes->work_hour;
			$arr["work_hour_label"] 		= $oWorkingMinutes->WORK_HOUR_LABEL;
			$arr["time_in"] 				= $oWorkingMinutes->time_in;
			$arr["time_out"] 				= $oWorkingMinutes->time_out;
			$arr["time_in_label"] 			= $oWorkingMinutes->time_in_label;
			$arr["time_out_label"] 			= $oWorkingMinutes->time_out_label;

			if(!empty($oWorkingMinutes->hour_color)){
				$arr["hour_color"] 			= $oWorkingMinutes->hour_color;
			}

			$arrWorkingDays[$oWorkingMinutes->day] = $arr;
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
		$data["download_url"] 						= "/report/day_download_" . $this->sRequestYearMonth;

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

	private function getData($user_id, $year, $month)
	{
		$model = new WorkDateTime();

		$model = $model->join("holiday", "holiday.date", "=", "work_datetime.date");

		$model = $model->where("organization_id", "=", $this->organization_id);
		$model = $model->where("user_id", "=", $user_id);
		$model = $model->where(\DB::raw("YEAR(work_datetime.`date`)"), "=", $year);
		$model = $model->where(\DB::raw("MONTH(work_datetime.`date`)"), "=", $month);

		$model = $model->orderBy("work_datetime.date", "ASC");
		$model = $model->select([
			"work_datetime.*",

			\DB::raw("DAY(work_datetime.date) AS 'day'"),
			\DB::raw("CONCAT(HOUR(work_datetime.time_in), ':', MINUTE(work_datetime.time_in)) AS 'time_in_label'"),
			\DB::raw("CONCAT(HOUR(work_datetime.time_out), ':', MINUTE(work_datetime.time_out)) AS 'time_out_label'"),

			\DB::raw("
					(
							(DAYOFWEEK(work_datetime.`date`) = 7)
						 OR (DAYOFWEEK(work_datetime.`date`) = 1)
						 OR (holiday.is_holiday = 1)
					) AS IS_HOLIDAY
			"),

			\DB::raw("
					CASE WHEN 
						(
							(DAYOFWEEK(work_datetime.`date`) = 7)
						 OR (DAYOFWEEK(work_datetime.`date`) = 1)
						 OR (holiday.is_holiday = 1)
						)
					THEN 'w3-gray'
					ELSE ''
					END 'status_color'
			"),

			\DB::raw("
					CASE WHEN 
						(
							(DAYOFWEEK(work_datetime.`date`) = 7)
						 OR (DAYOFWEEK(work_datetime.`date`) = 1)
						 OR (holiday.is_holiday = 1)
						)
					THEN 'w3-text-green'
					ELSE 
						CASE WHEN work_datetime.`work_hour` < '08:00:00'
							THEN 'w3-text-red'
							ELSE 'w3-text-green'
						END
					END 'hour_color'
			"),

			\DB::raw("
				CONCAT('/work-time/month/', YEAR(work_datetime.`date`), '/', MONTH(work_datetime.`date`)) AS 'TIME_PAGE_URL'
				"),

			\DB::raw("
				CONCAT(HOUR(work_datetime.`work_hour`), ':', MINUTE(work_datetime.`work_hour`)) AS 'WORK_HOUR_LABEL'
				"),

		]);

		$model = $model->get();

		return $model;
	}

}
