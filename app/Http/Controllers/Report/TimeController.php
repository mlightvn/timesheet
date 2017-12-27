<?php namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Model\Task;
use App\Model\WorkingDate;
use App\Model\WorkingTime;

class TimeController extends Controller {

	private $sDbRequestDate;

	protected function init()
	{
		parent::init();

		$this->blade_url = $this->url_pattern . '.time';

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

		$arrOffTasks = $this->getTimeSheetDataByWorkingTaskFlag($user_id, FALSE);
		$arrOnTasks = $this->getTimeSheetDataByWorkingTaskFlag($user_id, TRUE);

		// Assign variables for user screen
		$data = $this->data;
		$times["list"] = $arrTimes;
		$times["length"] = $timeLength;
		$data["times"] = $times;
		$data["sDbRequestDate"] = $this->sDbRequestDate;
		$data["arrOffTasks"] = $arrOffTasks;
		$data["arrOnTasks"] = $arrOnTasks;
		$data["logged_in_user"] = $this->logged_in_user;

		$this->data = $data;

		return view("/" . str_replace(".", "/", $this->blade_url), ['data'=>$this->data, "arrTimes"=>$arrTimes, "iTimesLength"=>$timeLength, "arrOffTasks"=>$arrOffTasks, "arrOnTasks"=>$arrOnTasks, "logged_in_user" => $this->logged_in_user, "sDbRequestDate"=> $this->sDbRequestDate, ]);
	}

	private function getTimeSheetDataByWorkingTaskFlag($user_id, $is_on_task = TRUE)
	{
		$is_off_task = !$is_on_task;

		$arrTimes = $this->getWorkingTimeLabelList();
		$arrTasks = $this->getUserTaskList($user_id, NULL, $is_off_task);

		// Get Working Times from DB, and put into array to show on user screen
		$arrData = array();
		// $iTotalMinutes = 0;
		foreach ($arrTasks as $taskKey => $task) {
			$oWorkingTimeList = $this->getWorkingTimeList($user_id, $task->id, $this->sDbRequestDate);
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

			$arrData[$task->id] = $timeLine;
			$arrTasks[$taskKey]->timeline = $timeLine;
		}
		// $arrTasks["totalMinutes"] = $iTotalMinutes;

		return $arrTasks;
	}

	public function regist()
	{
		$alert_type = "success";
		$message = "工数入力完了。";

		$url = $this->blade_url . "?date=" . $this->sDbRequestDate;
		$this->blade_url = $url;

		if(!isset($this->form_input["input_task"])){
			$alert_type = "error";
			$message = "稼働プロジェクトを登録してください。";

			$data = ["alert_type" => $alert_type, "alert_message" => $message];
			$this->jsonExport($data);
		}

		$arrInputWorkingTime = $this->form_input["input_task"];

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

		foreach ($arrInputWorkingTime as $task_id => $arrWorkingTimes) {
			$working_minutes = 0;
			foreach ($arrWorkingTimes as $timeKey => $timeValue) {
				if($timeKey != "is_off_task"){
					if($timeValue == 1){ // 追加
						$working_minutes++;
						$sDbTime = $this->timeKey2DbTime($timeKey);

						$dbWorkingTime = new WorkingTime();
						$dbWorkingTime->task_id = $task_id;
						$dbWorkingTime->user_id = $this->logged_in_user->id;
						$dbWorkingTime->date = $this->sDbRequestDate;
						$dbWorkingTime->time = $sDbTime;

						$dbWorkingTime->save(); // 追加
						unset($dbWorkingTime);
					}
				}
			}

			$dbWorkingDate = new WorkingDate();
			$dbWorkingDate->task_id = $task_id;
			$dbWorkingDate->user_id = $this->logged_in_user->id;
			$dbWorkingDate->date = $this->sDbRequestDate;
			$dbWorkingDate->working_minutes = ($working_minutes * 30);
			$dbWorkingDate->save();
			unset($dbWorkingDate);
		}

		$data = ["alert_type" => $alert_type, "alert_message" => $message];
		$this->jsonExport($data);
	}

}
