<?php namespace App\Http\Controllers\Api\Report;

use Illuminate\Http\Request;
use App\Model\WorkingDate;
use App\Model\WorkingTime;
use App\Model\ApplicationForm;

class MemberController extends \App\Http\Controllers\Api\Controller {

	protected $sRequestYearMonth = ""; //yyyy-mm
	private $sDbRequestDate;
	private $lastDayOfMonth;

	protected function init()
	{
		parent::init();

		$this->blade_url = $this->url_pattern . '.member';
		$this->data["url_pattern"] = "/" . str_replace(".", "/", $this->blade_url);

		$form_input = $this->form_input;
		if(isset($form_input["user_id"])){
			$this->user_id = $this->form_input["user_id"];
		}

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

		$departmentList = new \App\Model\Department();
		$departmentList = $departmentList->getList(NULL, 0);

		$table = new \App\Model\User();
		$request = array();
		$request["department_id"] = request()->department_id;
		$request["is_deleted"] = 0;
		$userList = $table->getList($request);

		$resultSet = $this->getResultSet($this->requestYear, $this->requestMonth);

		$lastRow = array();

		$arrWorkingMinutes = $this->getWorkingMinutes($this->sRequestYearMonth);
		$arrWorkingDays = array();

		$arrHolidayList = $this->getHolidays($this->sRequestYearMonth);
		$is_holiday_data_exist = (count($arrHolidayList) > 0);

		$today = date('Y-m-d');

		// arrWorkingDays
		for ($day=1; $day <= $this->lastDayOfMonth; $day++) {
			$day_data = array();
			$day_label = str_pad($day, 2, 0, STR_PAD_LEFT);

			$date = $this->sRequestYearMonth . "-" . $day_label;
			$day_data["date"] = $date;
			if($is_holiday_data_exist){
				$holiday = $arrHolidayList[$day - 1];
				$day_data["is_holiday"] = $holiday->is_holiday;
				$day_data["holiday_label"] = $holiday->name;
			}else{
				$day_data["is_holiday"] = $this->isWeekend($date); //週末、休日、祭り、…
				$day_data["holiday_label"] = "";
			}

			$date_label = $this->sRequestYearMonth . '-' . $day_label;

			$day_icon = "";
			if($day_data["is_holiday"]){
				$day_icon = "fas fa-bed";
			}elseif($today === $date_label){
				$day_icon = "fab fa-accessible-icon";
			}elseif($today > $date_label){
				$day_icon = "fa fa-power-off";
			}

			$day_data["day"] = $day_label;
			$day_data["day_icon"] = $day_icon;

			foreach ($userList as $key => $user) {
				if(!isset($lastRow[$user->id]["minutes"])){
					$lastRow[$user->id]["minutes"] = 0;
				}

				if(isset($resultSet[$day . "-" . $user->id])){
					$model = $resultSet[$day . "-" . $user->id];

					$user_data["minutes"] = $model->TOTAL_MINUTES;
					if($model->TOTAL_MINUTES >= 480){
						$user_data["time_status"] = "text-success";
					}else{
						$user_data["time_status"] = "text-danger";
					}
					$user_data["hour_label"] = $model->TOTAL_WORKING_HOURS_LABEL;

					$lastRow[$user->id]["minutes"] += $model->TOTAL_MINUTES;

				}else{
					$user_data["minutes"] = 0;
					$user_data["time_status"] = "text-danger";
					$user_data["hour_label"] = "00:00";

				}

				$user_data["detail_page_url"] = "/report/time?user_id=" . $user->id . "&date=" . $date_label;

				$day_data["timeList"][$user->id] = $user_data;

			}

			if($day_data["is_holiday"]){
				$day_data["status_color"] = "w3-gray";
				$day_data["hour_color"] = "text-success";
			}else{
				$day_data["hour_color"] = "text-danger";
			}

			$arrWorkingDays[$day] = $day_data;

		}

		// Last row: total hours
		foreach ($lastRow as $key => $minutes) {
			$lastRow[$key]["hour_label"] = $this->minutes2HourLabel($minutes["minutes"], "%02d時%02d分");
		}

		// Assign variables for user screen
		$data = array();

		$data["lastDayOfMonth"] 					= $this->lastDayOfMonth;
		$data["sRequestYearMonth"] 					= $this->sRequestYearMonth;

		$data["userList"] 							= $userList;
		$data["departmentList"] 					= $departmentList;
		$data["department_id"] 						= request()->department_id;
		$data["lastRow"] 							= $lastRow;

		$data["arrWorkingDays"] 					= $arrWorkingDays;

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
		$dbWorkingDate = $dbWorkingDate->join("project_task", "working_date.project_task_id", "=", "project_task.id");
		$dbWorkingDate = $dbWorkingDate->join("project", "project_task.project_id", "=", "project.id");

		$dbWorkingDate = $dbWorkingDate->where("working_date.user_id", "LIKE", $this->logged_in_user->id);
		$dbWorkingDate = $dbWorkingDate->where("working_date.date", "LIKE", $year_month . "%");
		$dbWorkingDate = $dbWorkingDate->where("users.is_deleted", "=", "0");
		$dbWorkingDate = $dbWorkingDate->where("project.is_deleted", "=", "0");

		$dbWorkingDate = $dbWorkingDate->groupBy(["working_date.date", "working_date.user_id"]);

		$arrReturn = $dbWorkingDate->get();

		return $arrReturn;
	}

	public function getResultSet($year, $month)
	{
		$model = new \App\Model\User();

		$model = $model->select([
				\DB::raw("YEAR(VIEW_TOTAL_MINUTES.date) 							AS 'year'"),
				\DB::raw("MONTH(VIEW_TOTAL_MINUTES.date) 							AS 'month'"),
				\DB::raw("DAY(VIEW_TOTAL_MINUTES.date) 								AS 'day'"),
				\DB::raw("VIEW_TOTAL_MINUTES.date"),

				\DB::raw("department.id 											AS 'department_id'"),
				\DB::raw("department.name 											AS 'department_name'"),

				\DB::raw("users.id 													AS 'user_id'"),
				\DB::raw("users.name 												AS 'user_name'"),

				\DB::raw("VIEW_TOTAL_MINUTES.TOTAL_MINUTES"),
				\DB::raw("VIEW_TOTAL_MINUTES.TOTAL_WORKING_HOURS_LABEL"),
		]);

		$view_total_minutes = "
			   (
					SELECT working_date.date
						 , users.id 												AS 'user_id'
						 , SUM(working_date.working_minutes) 						AS 'TOTAL_MINUTES'
						 , CONCAT(LPAD(FLOOR(SUM(working_date.working_minutes) / 60), 2, '0'), ':', LPAD(MOD(SUM(working_date.working_minutes), 60), 2, '0')) 			AS 'TOTAL_WORKING_HOURS_LABEL'

					  FROM working_date
						   INNER JOIN users ON(working_date.user_id = users.id)

					 WHERE 1 = 1
					   AND YEAR(working_date.date) = {REQUEST_YEAR}
					   AND MONTH(working_date.date) = {REQUEST_MONTH}

					   AND users.is_deleted = 0

					 GROUP BY
						   working_date.date
						 , users.id

			   ) AS VIEW_TOTAL_MINUTES
		";

		$view_total_minutes = str_replace(["{REQUEST_YEAR}", "{REQUEST_MONTH}"], [$year, $month], $view_total_minutes);

		$model = $model->join(\DB::raw($view_total_minutes), "VIEW_TOTAL_MINUTES.user_id", "=", "users.id");
		$model = $model->join("department", "department.id", "=", "users.department_id");

		$model = $model->where("department.is_deleted", "0");
		$model = $model->orderBy("VIEW_TOTAL_MINUTES.date");
		$model = $model->orderBy("department.id");
		$model = $model->orderBy("users.id");

		$collection = $model->get();
		$arrReturn = $collection->mapWithKeys(function($model)
		{
			$key = $model["day"] . "-" . $model["user_id"];
			return [$key => $model];
		})->all();

		return $arrReturn;
	}

}
