<?php namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
// use App\Model\Project;
// use App\Model\ProjectTask;
use App\Model\BaseModel;

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
		$this->data["url_pattern"] = "/" . str_replace(".", "/", $this->blade_url);

		$form_input = $this->form_input;
		if(isset($form_input["year_month"])){
			$this->sRequestYearMonth = $this->form_input["year_month"];
		}

		// if(isset($form_input["user_id"])){
		// 	$this->user_id = $this->form_input["user_id"];
		// }

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

	// public function index()
	// {
	// 	$report_user_id = $this->reportUser->id;

	// 	$total_working_minutes = 0;

	// 	$workingDate = new WorkingDate();
	// 	$arrTasks = $workingDate->getTimeSheetList($report_user_id, $this->requestYear, $this->requestMonth);

	// 	$timeSheet = $this->getOwnSubTaskList($report_user_id);
	// 	$arrOnTaskSheet["total_minutes"] = 0;
	// 	$arrOffTaskSheet["total_hours_label"] = "";
	// 	$arrOnTaskSheet["total_hours_label"] = "";

	// 	foreach ($arrTasks as $key => $oTask) {
	// 		$iWorkingMinutes = intval($oTask->total_working_minutes);
	// 		$arrOnTaskSheet["task"][$oTask->id] = $oTask;
	// 		$arrOnTaskSheet["total_minutes"] += $iWorkingMinutes;
	// 		$total_working_minutes += $iWorkingMinutes;
	// 	}
	// 	$total_hours_label = $this->minutes2HourLabel($total_working_minutes, "%02d時%02d分");
	// 	$arrOffTaskSheet["total_hours_label"] = $this->minutes2HourLabel($arrOffTaskSheet["total_minutes"], "%02d時%02d分");
	// 	$arrOnTaskSheet["total_hours_label"] = $this->minutes2HourLabel($arrOnTaskSheet["total_minutes"], "%02d時%02d分");

	// 	$arrTaskSheet = array();
	// 	$arrTaskSheet["off_task"] = $arrOffTaskSheet;
	// 	$arrTaskSheet["on_task"] = $arrOnTaskSheet;
	// 	$arrTaskSheet["total_working_minutes"] = $total_working_minutes;
	// 	$arrTaskSheet["total_hours_label"] = $total_hours_label;

	// 	// Assign variables for user screen
	// 	$data = $this->data;

	// 	$data["lastDayOfMonth"] = $this->lastDayOfMonth;
	// 	$data["sRequestYearMonth"] = $this->sRequestYearMonth;

	// 	$data["arrTaskSheet"] = $arrTaskSheet;
	// 	$data["total_hours_label"] = $total_hours_label;
	// 	$data["total_working_minutes"] = $total_working_minutes;

	// 	$this->data = $data;

	// 	return view("/" . str_replace(".", "/", $this->blade_url)
	// 			, [
	// 					"data" 								=> $this->data,
	// 					"logged_in_user" 					=> $this->logged_in_user,
	// 					"requestYear" 						=> $this->requestYear,
	// 					"requestMonth" 						=> $this->requestMonth,
	// 					"sRequestYearMonth" 				=> $this->sRequestYearMonth,
	// 					"sDbRequestDate" 					=> $this->sDbRequestDate,
	// 					"lastDayOfMonth" 					=> $this->lastDayOfMonth,
	// 					"arrTaskSheet" 						=> $this->data["arrTaskSheet"],
	// 					"total_hours_label" 		=> $total_hours_label,
	// 					"total_working_minutes" 			=> $total_working_minutes,
	// 					"report_user_id"					=> $this->reportUser->id,
	// 			]);
	// }

	public function index()
	{
		$report_user_id = $this->reportUser->id;

		$total_working_minutes = 0;
		$user = \App\Model\User::find($report_user_id);

		// $timeSheet = new ProjectTask();
		$timeSheetList = $this->getTimeSheetList($user, $this->requestYear, $this->requestMonth);

		// // $arrTaskTypeList = $this->getTaskTypeList();
		// // $arrUserList = $this->getUsers(false);
		// // $arrWorkingDateTotal = $this->getWorkingDateTotal($report_user_id, $this->requestYear, $this->requestMonth);

		// $arrOnTaskSheet = array();
		// $arrOnTaskSheet["task"] = array();
		// $arrOnTaskSheet["total_hours_label"] = "";

		// foreach ($arrTasks as $key => $oTask) {
		// 	$total_minutes = 0;

		// 	$oTask->working_hour_list = array();
		// 	foreach ($arrTaskTypeList as $key => $oTaskType) {
		// 		$foreign_key = $report_user_id . $oTask->sub_task_id . $oTaskType->id;

		// 		if(count($arrWorkingDateTotal) > 0 && isset($arrWorkingDateTotal[$foreign_key])){
		// 			$iWorkingMinutes = intval($arrWorkingDateTotal[$foreign_key]->total_working_minutes);

		// 			$total_minutes += $iWorkingMinutes;

		// 			$oTask->working_hour_list[$foreign_key] = $arrWorkingDateTotal[$foreign_key];
		// 		}else{
		// 			$arr = new \App\Model\NObject();
		// 			$arr->total_hours_label = "00:00";

		// 			$oTask->working_hour_list[$foreign_key] = $arr;
		// 		}
		// 	}
		// 	$oTask->total_minutes = $total_minutes;
		// 	$oTask->total_minutes_label = $this->minutes2HourLabel($total_minutes, "%02d:%02d");

		// 	$total_working_minutes += $total_minutes;

		// 	$arrOnTaskSheet["task"][$oTask->sub_task_id] = $oTask;

		// }
		// $total_hours_label = $this->minutes2HourLabel($total_working_minutes, "%02d時%02d分");
		// $arrOnTaskSheet["total_working_minutes"] 		= $total_working_minutes;
		// $arrOnTaskSheet["total_hours_label"] 	= $total_hours_label;

		// $arrTaskSheet = array();
		// $arrTaskSheet["on_task"] = $arrOnTaskSheet;
		// $arrTaskSheet["total_working_minutes"] = $total_working_minutes;
		// $arrTaskSheet["total_hours_label"] = $total_hours_label;

		// Assign variables for user screen
		$data = $this->data;

		$data["lastDayOfMonth"] 						= $this->lastDayOfMonth;
		$data["sRequestYearMonth"] 						= $this->sRequestYearMonth;
		$data["timeSheetList"] 							= $timeSheetList;


		// $data["total_hours_label"] 						= $total_hours_label;
		// $data["total_working_minutes"] 					= $total_working_minutes;

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
						// "total_hours_label" 				=> $total_hours_label,
						// "total_working_minutes" 			=> $total_working_minutes,
						"report_user_id"					=> $this->reportUser->id,
				]);
	}

	public function getTimeSheetList($user = null, $year, $month, $excel_flag = null){
		if($user === null){
			$user = \Auth::user();
		}
		$user_id = $user->id;
		$year_month = $year . "-" . $month;

		$model = \DB::table('project');
		$model = $model->join('project_task', 'project.id', '=', 'project_task.project_id');
		$model = $model->join('user_project_task', 'project_task.id', '=', 'user_project_task.project_task_id');

		$sub_query_working_hours = "
			(
			SELECT
				   `project_task`.id 													AS 'project_task_id'
				 , SUM(working_date.working_minutes) 									AS 'TOTAL_MINUTES'
				 , LPAD(FLOOR(SUM(working_date.working_minutes) / 60), 2, 0) 			AS 'HOUR_VALUE'
				 , LPAD(MOD(SUM(working_date.working_minutes), 60), 2, 0) 				AS 'MINUTE_VALUE'
			  FROM `working_date`
				   INNER JOIN `project_task` 				ON (`working_date`.project_task_id = `project_task`.id)
				   INNER JOIN `project` 					ON (`project_task`.project_id = `project`.id)
			 WHERE `working_date`.`user_id` 				= {USER_ID}
			   AND `working_date`.`date` 					LIKE '{YEAR_MONTH}%'
			   AND `working_date`.`working_minutes` 		> 0

			 GROUP BY `project_task`.id
			) AS sub_query_working_hours

		";
		$sub_query_working_hours = str_replace("{USER_ID}", $user_id, $sub_query_working_hours);
		$sub_query_working_hours = str_replace("{YEAR_MONTH}", $year_month, $sub_query_working_hours);
		$model = $model->join(\DB::raw($sub_query_working_hours), 'sub_query_working_hours.project_task_id', '=', 'project_task.id');

		if($excel_flag !== null){
			$model = $model->where('project_task.excel_flag', '=', $excel_flag);
		}

		$model = $model->where('project.is_deleted', BaseModel::IS_NOT_DELETED);
		$model = $model->where('project_task.is_deleted', BaseModel::IS_NOT_DELETED);

		$model = $model->orderBy('project.id')->orderBy('project_task.id');

		$model = $model->select([
				\DB::raw("project.id 													AS 'project_id'"),
				\DB::raw("project.name 													AS 'project_name'"),
				\DB::raw("project_task.id 												AS 'project_task_id'"),
				\DB::raw("project_task.name 											AS 'project_task_name'"),
				"project_task.excel_flag",
				\DB::raw("sub_query_working_hours.TOTAL_MINUTES"),
				\DB::raw("sub_query_working_hours.HOUR_VALUE"),
				\DB::raw("sub_query_working_hours.MINUTE_VALUE"),
				\DB::raw("CONCAT(sub_query_working_hours.HOUR_VALUE, ':',sub_query_working_hours.MINUTE_VALUE) 		AS 'HOURS_DISPLAY'"),

		]);

		$models = $model->get();
		return $models;
	}

}
