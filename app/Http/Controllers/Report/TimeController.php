<?php namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
// use App\Model\Project;
use App\Model\ProjectTask;
use App\Model\WorkingDate;
use App\Model\WorkingTime;

class TimeController extends Controller {

	private $sDbRequestDate;

	protected function init()
	{
		parent::init();

		$this->blade_url = $this->url_pattern . '.time';
		$this->data["url_pattern"] = "/" . str_replace(".", "/", $this->blade_url);

		$sDbRequestDate = $this->request["date"];
		if(empty($sDbRequestDate)){
			$sDbRequestDate = $this->request["sDbRequestDate"];
			if(empty($sDbRequestDate)){
				$sDbRequestDate = date("Y-m-d");
			}
		}
		$this->sDbRequestDate = $sDbRequestDate;
	}

	public function index()
	{

		$logged_in_user = $this->logged_in_user;
		$user_id = $logged_in_user->id;

		$arrTimes = $this->getWorkingTimeLabelList();
		$timeLength = count($arrTimes);

		$arrAllTasks = $this->getTimeSheetData($user_id);
// dd($arrAllTasks);
		// Assign variables for user screen
		$data = $this->data;
		$times["list"] = $arrTimes;
		$times["length"] = $timeLength;
		$data["times"] = $times;
		$data["sDbRequestDate"] = $this->sDbRequestDate;
		$data["arrAllTasks"] = $arrAllTasks;
		$data["logged_in_user"] = $this->logged_in_user;
		$data["title"] 					= __("screen.menu.report.input_time_screen");

		$this->data = $data;

		return view("/" . str_replace(".", "/", $this->blade_url), ['data'=>$this->data, "arrTimes"=>$arrTimes, "iTimesLength"=>$timeLength, "logged_in_user" => $this->logged_in_user, "sDbRequestDate"=> $this->sDbRequestDate, ]);
	}

	private function getTimeSheetData($user_id)
	{
		$arrTimes = $this->getWorkingTimeLabelList();

		$projectTask = new ProjectTask();
		$whereCondition = array();
		$whereCondition["user_id"] = $user_id;
		$whereCondition["own_project_task"] = 1;
		$arrTasks = $projectTask->getAllList($whereCondition);

		// Get Working Times from DB, and put into array to show on user screen
		$arrData = array();
		// $iTotalMinutes = 0;
		$workingTime = new WorkingTime();
		foreach ($arrTasks as $taskKey => $task) {
			$oWorkingTimeList = $workingTime->getTimeSheetList($user_id, $task->project_task_id, $this->sDbRequestDate);

			$timeLine = array();
			foreach ($arrTimes as $timeKey => $time) {
				$timeLine[$timeKey] = 0;
				foreach ($oWorkingTimeList as $key => $oWorkingTime) {
					$sWorkingTime = $oWorkingTime->time;
					$sWorkingTime = str_replace(":", "", $sWorkingTime);
					$sWorkingTime = substr($sWorkingTime, 0, 4);

					if($sWorkingTime == $timeKey){
						$timeLine[$timeKey] = 1;
						// $iTotalMinutes++;
					}
				}
			}
			// $iTotalMinutes *= 30;

			$arrData[$task->project_task_id] = $timeLine;
			$arrTasks[$taskKey]->timeline = $timeLine;
		}
		// $arrTasks["totalMinutes"] = $iTotalMinutes;

		return $arrTasks;
	}

	public function register()
	{
		$alert_type = "success";
		$message = "工数入力完了。";

		$url = $this->blade_url . "?date=" . $this->sDbRequestDate;
		$this->blade_url = $url;

		if(!isset($this->form_input)){
			$alert_type = "error";
			$message = "稼働プロジェクトを登録してください。";

			$data = ["alert_type" => $alert_type, "alert_message" => $message];
			$this->jsonExport($data);
		}

		// 追加するために、最初、working_timeのデータを削除
		$dbWorkingTime = new WorkingTime();
		$dbWorkingTime = $dbWorkingTime->where("user_id"			, "=", $this->logged_in_user->id);
		$dbWorkingTime = $dbWorkingTime->where("date"				, "=", $this->sDbRequestDate);
		$dbWorkingTime->delete(); // 削除
		unset($dbWorkingTime);

		// 追加するために、最初、working_dateのデータを削除
		$dbWorkingDate = new WorkingDate();
		$dbWorkingDate = $dbWorkingDate->where("user_id" 				, "=", $this->logged_in_user->id);
		$dbWorkingDate = $dbWorkingDate->where("date" 					, "=", $this->sDbRequestDate);
		$dbWorkingDate->delete();
		unset($dbWorkingDate);

		$organization_id = $this->logged_in_user->organization_id;
		if(isset($this->form_input["input_task"])){
			$arrInputWorkingTime = $this->form_input["input_task"];
		}else{
			$arrInputWorkingTime = array();
		}


		foreach ($arrInputWorkingTime as $project_task_id => $arrWorkingTimes) {
			$working_minutes = 0;
			foreach ($arrWorkingTimes as $timeKey => $timeValue) {
				if($timeValue == 1){ // 追加
					$working_minutes++;
					$sDbTime = $this->timeKey2DbTime($timeKey);

					$dbWorkingTime 						= new WorkingTime();
					$dbWorkingTime->project_task_id 	= $project_task_id;
					$dbWorkingTime->user_id 			= $this->logged_in_user->id;
					$dbWorkingTime->date 				= $this->sDbRequestDate;
					$dbWorkingTime->time 				= $sDbTime;

					$dbWorkingTime->save(); // 追加
					unset($dbWorkingTime);
				}
			}

			$dbWorkingDate = new WorkingDate();
			$dbWorkingDate->project_task_id 			= $project_task_id;
			$dbWorkingDate->user_id 					= $this->logged_in_user->id;
			$dbWorkingDate->date 						= $this->sDbRequestDate;
			$dbWorkingDate->working_minutes 			= ($working_minutes * 30);
			$dbWorkingDate->save();
			unset($dbWorkingDate);
		}

		$data = ["alert_type" => $alert_type, "alert_message" => $message];
		$this->jsonExport($data);
	}

}
