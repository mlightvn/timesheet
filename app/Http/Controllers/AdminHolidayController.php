<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Holiday;

class AdminHolidayController extends AdminController {

	protected $sRequestYearMonth = ""; //yyyy-mm
	private $sDbRequestDate;
	private $lastDayOfMonth;

	protected function init()
	{
		parent::init();

		$this->url_pattern = "admin.holiday";
		$this->data["url_pattern"] = "/admin/holiday";

		$form_input = $this->form_input;
		if(isset($form_input["year_month"])){
			$this->sRequestYearMonth = $form_input["year_month"];
		}else{
			if(isset($form_input["sRequestYearMonth"])){
				$this->sRequestYearMonth = $form_input["sRequestYearMonth"];
			}else{
				$this->sRequestYearMonth = date("Y-m");
			}
		}

		$date = $this->sRequestYearMonth . "-01";
		$date = date("Y-m-t", strtotime($date));
		$arrDate = explode("-", $date);

		$this->requestYear = $arrDate[0];
		$this->requestMonth = $arrDate[1];

		$this->sDbRequestDate = $date;
		$this->lastDayOfMonth = end($arrDate);
	}

	public function index()
	{
		$user_id = $this->user_id;
		$this->blade_url = $this->url_pattern . '.index';

		$total_working_hours = 0;
		$total_working_minutes = 0;

		$arrList = $this->getHolidays($this->sRequestYearMonth);

		$this->data["add_new"] = 0;
		if(count($arrList) <= 0){
			$this->data["add_new"] = 1;
			//renew array
			$arrList = array();
			for ($day=1; $day <= $this->lastDayOfMonth; $day++) {
				$holiday = new Holiday();
				$date = $this->sRequestYearMonth . "-" . str_pad($day, 2, "0", STR_PAD_LEFT);

				$holiday->date = $date;
				$holiday->is_holiday = $this->isWeekend($date); //週末

				$arrList[] = $holiday;
			}
		}

		// Assign variables for user screen
		$data = $this->data;

		$data["lastDayOfMonth"] = $this->lastDayOfMonth;
		$data["sRequestYearMonth"] = $this->sRequestYearMonth;

		$data["arrList"] = $arrList;

		$this->data = $data;

		return view("/" . str_replace(".", "/", $this->blade_url)
				, [
						'data' 								=> $this->data
						, "arrList" 						=> $arrList
						, "logged_in_user" 					=> $this->logged_in_user
						, "requestYear" 					=> $this->requestYear
						, "requestMonth" 					=> $this->requestMonth
						, "sRequestYearMonth" 				=> $this->sRequestYearMonth
						, "sDbRequestDate" 					=> $this->sDbRequestDate
						, "lastDayOfMonth" 					=> $this->lastDayOfMonth
				]);
	}

	public function update()
	{
		$this->data["add_new"] = $this->form_input["add_new"];
		$arrList = $this->form_input["holiday"];
// dd($arrList);
		foreach ($arrList as $date => $holiday) {
			$table = new Holiday();
			$table = $table->find($date);
			if(is_null($table)){
				$table = new Holiday();
				$table->date = $date;
			}
// if(isset($holiday)){
// 	dd($holiday);
// }
			$table->is_holiday = (isset($holiday["is_holiday"]) ? 1 : 0);
			$table->name = (isset($holiday["name"]) ? $holiday["name"] : NULL);
			// if(isset($holiday->name)){
			// 	dd($holiday->name);
			// }
// dd($table);
			if($this->data["add_new"]){
				$table->save();
			}else{
				$table->update();
			}

		}

		$alert_type = "success";
		$message = "登録完了。";

		$this->blade_url = $this->url_pattern . "?year_month=" . $this->sRequestYearMonth;
		return redirect("/" . str_replace(".", "/", $this->blade_url))->with(['message'=>$message, "alert_type" => $alert_type]);
	}

	// public function delete($date)
	// {
	// 	$message = NULL;
	// 	$alert_type = NULL;

	// 	$table = new Holiday();
	// 	$table = $table->find($date);

	// 	if(!$table){
	// 		$message = "データ（" . $date . "）が存在していません。";
	// 		return redirect("/" . str_replace(".", "/", $this->url_pattern))->with(['data' => $this->data, 'message'=>$message]);
	// 	}

	// 	if($this->logged_in_user->session_is_manager != "Manager"){
	// 		$message = "データの追加修正削除に関しては、システム管理者までお問い合わせください。";
	// 	}else{
	// 		$table->where("date", "=", $date)->delete();
	// 		$alert_type = "success";
	// 		$message = "データ（" . $date . "）が削除完了。";
	// 	}

	// 	return redirect("/" . str_replace(".", "/", $this->url_pattern))->with(['data' => $this->data, 'message'=>$message, "alert_type" => $alert_type]);

	// }

}
