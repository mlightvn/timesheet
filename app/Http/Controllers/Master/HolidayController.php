<?php namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Model\Holiday;

class HolidayController extends Controller {

	protected $sRequestYearMonth = ""; //yyyy-mm
	private $sDbRequestDate;
	private $lastDayOfMonth;

	protected function init()
	{
		parent::init();

		$this->url_pattern = "master.holiday";
		$this->data["url_pattern"] = "/master/holiday";

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

	public function list()
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

}
