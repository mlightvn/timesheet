<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;

// use Illuminate\Foundation\Validation\ValidatesRequests;
// use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
// use Illuminate\Foundation\Auth\AuthenticatesUsers;
// use Illuminate\Foundation\Auth\ThrottlesLogins;

use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
	// use AuthorizesRequests;
	// use DispatchesJobs;
	// use ValidatesRequests;
	// use AuthenticatesUsers;

	protected $request;
	protected $data;
	protected $url_pattern = "", $blade_url = "";
	protected $form_input;
	protected $guard;
	protected $user_id;
	protected $logged_in_user;
	protected $organization_id = NULL;
	protected $logical_delete = true;

	public function __construct(Request $request)
	{
		// $this->middleware('', ['except' => ['login', 'authenticate', 'logout', 'register', 'index']]);

		$this->guard = Auth::guard('admin');

		$this->request = $request;
		$this->form_input = $this->request->all();

		$this->getLoggedInUser();

		$this->init();
	}

	protected function init(){
	}

	public function index()
	{
		$this->blade_url = $this->url_pattern . '.index';

		return view($this->blade_url, array('data'=>$this->data, "logged_in_user"=>$this->logged_in_user));
	}

	public function list()
	{
		$url = "";
		if($this->url_pattern){
			$url = $this->url_pattern . '.index';
		}else{
			$url = 'manage.index';
		}

		$keyword = "";
		if(isset($this->form_input["keyword"])){
			$keyword = $this->form_input["keyword"];
		}

		$model_list = $this->model->paginate(env('NUMBER_OF_RECORD_PER_PAGE'));

		$this->data["keyword"] = $keyword;
		$this->data["model_list"] = $model_list;

		return view($url, array('data'=>$this->data, "logged_in_user"=>$this->logged_in_user, 'model_list'=>$model_list));
	}

	public function getLoggedInUser(){
		$this->logged_in_user = $this->guard->user();

		if($this->logged_in_user){
			$this->data["logged_in_user"] = $this->logged_in_user;
			$this->user_id = $this->logged_in_user->id;
			$this->organization_id = $this->logged_in_user->organization_id;
		}

		return $this->logged_in_user;
	}

	public function login()
	{
		$url = 'login';

		$logged_in_user = new \App\Model\User();

		return view($url, ['data'=>$this->data, "model" => $logged_in_user]);
	}

	public function authenticate() {
		$form_input = $this->form_input;

		$email 			= $form_input['email'];
		$password 		= $form_input['password'];

		$remember 		= isset($form_input['remember']);

		$credentials = [
				'email' 		=> $form_input['email'], 
				'password' 		=> $form_input['password'], //auto-encrypt
				'is_deleted' 	=> "0",
			];

		if ($this->guard->attempt($credentials, $remember)) {
			return redirect()->intended('/');
		} else {
			return redirect('/login');
		}

	}

	public function logout(){
		if($this->guard->check()){
			$this->guard->logout();
		}

		$_SERVER['PHP_AUTH_USER'] = NULL;
		$_SERVER['PHP_AUTH_PW'] = NULL;

		unset($_SERVER['PHP_AUTH_USER']);
		unset($_SERVER['PHP_AUTH_PW']);

		return redirect('/login');
	}

	public function getWorkingTimeLabelList($value='')
	{
		$arrTimes = array(
						"0700"		=> "07:00",
						"0730"		=> "07:30",
						"0800"		=> "08:00",
						"0830"		=> "08:30",
						"0900"		=> "09:00",
						"0930"		=> "09:30",
						"1000"		=> "10:00",
						"1030"		=> "10:30",
						"1100"		=> "11:00",
						"1130"		=> "11:30",
						"1200"		=> "12:00",
						"1230"		=> "12:30",
						"1300"		=> "13:00",
						"1330"		=> "13:30",
						"1400"		=> "14:00",
						"1430"		=> "14:30",
						"1500"		=> "15:00",
						"1530"		=> "15:30",
						"1600"		=> "16:00",
						"1630"		=> "16:30",
						"1700"		=> "17:00",
						"1730"		=> "17:30",
						"1800"		=> "18:00",
						"1830"		=> "18:30",
						"1900"		=> "19:00",
						"1930"		=> "19:30",
						"2000"		=> "20:00",
						"2030"		=> "20:30",
						"2100"		=> "21:00",
						"2130"		=> "21:30",
						"2200"		=> "22:00",
						"2230"		=> "22:30",
						"2300"		=> "23:00",
						"2330"		=> "23:30",
			);
		return $arrTimes;
	}

	public function getTaskListWithUser($isPagination, $user_id, $keyword = NULL)
	{
		$table = DB::table('task');

		$table = $table->select(["task.*", \DB::raw("organization.name AS organization_name")]);

		$table = $table->leftJoin("organization", "task.organization_id", "=", "organization.id");

		if($user_id != NULL && $user_id != ""){
			$subQuery = "( SELECT * FROM user_task WHERE user_id = '" . $user_id . "') AS user_task ";

			$table = $table->leftJoin(DB::raw($subQuery), "task.id", "=", "user_task.task_id");
		}else{
			$table = $table->leftJoin("user_task", "task.id", "=", "user_task.task_id");
		}

		if($keyword){
			$where = " (
							   (task.id = '{KEYWORD}')
							OR (task.name LIKE '%{KEYWORD}%')
						)";
			$where = str_replace("{KEYWORD}", $keyword, $where);

			$table = $table->whereRaw($where);
		}

		$table = $table->where("organization.id", "=", \Auth::user()->organization_id);

		$table = $table->orderBy("task.is_deleted", "ASC");
		$table = $table->orderBy("task.is_off_task", "ASC")->orderBy("task.id");

		if($isPagination){
			$arrResult = $table->paginate(env('NUMBER_OF_RECORD_PER_PAGE'));
		}else{
			$arrResult = $table->get();
		}

		return $arrResult;
	}

	public function getUsers($isPagination, $id = NULL, $email = NULL, $name = NULL, $keyword = NULL)
	{
		$table = DB::table('users');
		$table = $table->select([
			  "users.*"
			, DB::raw("organization.name AS organization_name")
			, DB::raw("session.name AS session_name")
		]);

		$table = $table->leftJoin("session", "users.session_id", "=", "session.id");
		$table = $table->leftJoin("organization", "users.organization_id", "=", "organization.id");

		if($id){
			$table = $table->where("id", "=", $id);
		}
		if($email){
			$table = $table->where("email", "=", $email);
		}
		if($name){
			$table = $table->where("name", "LIKE", "%" . $name . "%");
		}

		if($keyword){
			$where = " (
							   (users.id = '{KEYWORD}')
							OR (users.email LIKE '%{KEYWORD}%')
							OR (users.name LIKE '%{KEYWORD}%')
							OR (session.name LIKE '%{KEYWORD}%')
						)";
			$where = str_replace("{KEYWORD}", $keyword, $where);

			$table = $table->whereRaw($where);
		}

		if(\Auth::user()->permission_flag != "Administrator"){
			$table = $table->where("organization.id", "=", \Auth::user()->organization_id);
		}

		$table = $table->orderBy("users.is_deleted", "ASC");

		if($isPagination){
			$arrResult = $table->paginate(env('NUMBER_OF_RECORD_PER_PAGE'));
		}else{
			$arrResult = $table->get();
		}

		return $arrResult;
	}

	public function getTasks($isPagination, $id = NULL, $name = NULL, $keyword = NULL)
	{
		$table = DB::table('task');

		$table = $table->select(["task.*", DB::raw("organization.name AS organization_name")]);

		$table = $table->leftJoin("organization", "task.organization_id", "=", "organization.id");

		if($id){
			$table = $table->where("id", "=", $id);
		}
		if($name){
			$table = $table->where("name", "LIKE", "%" . $name . "%");
		}

		if($keyword){
			$where = " (
							   (id = '{KEYWORD}')
							OR (name LIKE '%{KEYWORD}%')
						)";
			$where = str_replace("{KEYWORD}", $keyword, $where);

			$table = $table->whereRaw($where);
		}

		$table = $table->where("organization.id", "=", \Auth::user()->organization_id);

		$table = $table->orderBy("is_deleted", "ASC");
		$table = $table->orderBy("is_off_task", "DESC");

		if($isPagination){
			$arrResult = $table->paginate(env('NUMBER_OF_RECORD_PER_PAGE'));
		}else{
			$arrResult = $table->get();
		}

		return $arrResult;
	}

	public function getSessions($isPagination, $id = NULL, $name = NULL, $keyword = NULL)
	{
		$table = DB::table('session');

		$table = $table->select(["session.*", DB::raw("organization.name AS organization_name")]);

		$table = $table->leftJoin("organization", "session.organization_id", "=", "organization.id");

		if($id){
			$table = $table->where("id", "=", $id);
		}
		if($name){
			$table = $table->where("name", "LIKE", "%" . $name . "%");
		}

		if($keyword){
			$where = " (
							   (id = '{KEYWORD}')
							OR (name LIKE '%{KEYWORD}%')
						)";
			$where = str_replace("{KEYWORD}", $keyword, $where);

			$table = $table->whereRaw($where);
		}

		$table = $table->where("organization.id", "=", \Auth::user()->organization_id);

		$table = $table->orderBy("is_deleted", "ASC");

		if($isPagination){
			$arrResult = $table->paginate(env('NUMBER_OF_RECORD_PER_PAGE'));
		}else{
			$arrResult = $table->get();
		}
		return $arrResult;
	}

	public function getUserTaskList($user_id = NULL, $task_id = NULL, $is_off_task = NULL)
	{
		$table = DB::table('user_task');

		$table = $table->select(["user_task.*", "task.*", DB::raw("organization.name AS organization_name")]);

		$table = $table->join("task", "user_task.task_id", "=", "task.id");
		$table = $table->leftJoin("organization", "task.organization_id", "=", "organization.id");

		if($user_id){
			$table = $table->where("user_task.user_id", "=", $user_id);
		}
		if($task_id){
			$table = $table->where("user_task.task_id", "=", $task_id);
		}

		if(!is_null($is_off_task)){
			$is_off_task = ($is_off_task) ? 1 : 0;
			$table = $table->where("task.is_off_task", "=", $is_off_task);
		}

		$table = $table->where("organization.id", "=", \Auth::user()->organization_id);
		$table = $table->where("task.is_deleted", "=", "0");

		$table = $table->orderBy("task.is_deleted", "ASC");
		$table = $table->orderBy("task.is_off_task", "DESC")->orderBy("user_task.task_priority", "DESC")->orderBy("task.id");

		$arrResult = $table->get();
		return $arrResult;
	}

	public function getWorkingDateList($user_id = NULL, $date = NULL)
	{
		$table = DB::table('working_date');

		$table = $table->select(["working_date.*", DB::raw("organization.name AS organization_name")]);

		$table = $table->leftJoin("organization", "working_date.organization_id", "=", "organization.id");

		$table = $table->join("users", "working_date.user_id", "=", "users.id");
		$table = $table->join("task", "working_date.task_id", "=", "task.id");

		if($user_id != NULL && $user_id != ""){
			$table = $table->where("working_date.user_id", "=", $user_id);
		}
		if($date != NULL && $date != ""){
			$table = $table->where("working_date.date", "=", $date);
		}

		$table = $table->where("organizationid", "=", \Auth::user()->organization_id);

		$table = $table->where("users.is_deleted", "=", "0");
		$table = $table->where("task.is_deleted", "=", "0");

		$table = $table->orderBy("date");

		$arrResult = $table->get();
		return $arrResult;
	}

	public function getWorkingTimeList($user_id = NULL, $task_id = NULL, $date = NULL)
	{
		$table = DB::table('working_time');

		$table = $table->select(["working_time.*", DB::raw("organization.name AS organization_name")]);

		$table = $table->leftJoin("organization", "working_time.organization_id", "=", "organization.id");
		$table = $table->join("users", "working_time.user_id", "=", "users.id");
		$table = $table->join("task", "working_time.task_id", "=", "task.id");

		if($user_id != NULL && $user_id != ""){
			$table = $table->where("working_time.user_id", "=", $user_id);
		}
		if($task_id != NULL && $task_id != ""){
			$table = $table->where("working_time.task_id", "=", $task_id);
		}
		if($date != NULL && $date != ""){
			$table = $table->where("working_time.date", "=", $date);
		}

		$table = $table->where("organization.id", "=", \Auth::user()->organization_id);

		$table = $table->where("users.is_deleted", "=", "0");
		$table = $table->where("task.is_deleted", "=", "0");

		$table = $table->orderBy("working_time.date");
		$table = $table->orderBy("working_time.time");

		$arrResult = $table->get();
		return $arrResult;
	}

	public function getHolidays($yearMonth = NULL)
	{
		$table = DB::table('holiday');
		$yearMonth = ($yearMonth) ? $yearMonth : date("Y-m");
		$table = $table->whereRaw("DATE_FORMAT(date, '%Y-%m') = '" . $yearMonth . "'");

		$arrResult = $table->get();
		return $arrResult;
	}

	public function sqlEscape($value)
	{
		return preg_replace("/\'/", "''", $value);
	}

	public function timeKey2TimeLabel($timeKey)
	{
		$timeLabel = substr($timeKey, 0, 2) . ":" . substr($timeKey, 2);
		return $timeLabel;
	}

	public function timeKey2DbTime($timeKey)
	{
		$sDbTime = $this->timeKey2TimeLabel($timeKey) . ":00";
		return $sDbTime;
	}

	public function timeLabel2DbTime($timeLabel)
	{
		$sDbTime = $timeLabel . ":00";
		return $sDbTime;
	}

	public function minutes2HourLabel($minutes, $format = '%02d:%02d')
	{
		if ($minutes < 1) {
			$hours = 0;
			$minutes = 0;
		}else{
			$hours = floor($minutes / 60);
			$minutes = ($minutes % 60);
		}

		return sprintf($format, $hours, $minutes);
	}

	public function getDbDateFormatByDistance($date, $distance)
	{
		$date = \DateTime::createFromFormat('Y-m-d', $date); // ->format('Y-m-d');
		$sDbDateFormat = $date->modify($distance)->format("Y-m-d");

		return $sDbDateFormat;
	}

	public function isWeekend($date) {
		return (date('N', strtotime($date)) >= 6);
	}

	public function trimZenkakuSpace($value)
	{
		$value = str_replace("　", " ", $value);
		$value = trim($value);
		$value = str_replace(" ", "　", $value);

		return $value;
	}

	public function convertJPKingDateToWestern($jpKingDate){
		$gengo = mb_substr($jpKingDate , 0, 2);
		$y_pos = strpos($jpKingDate,"年");
		if($y_pos == 5){
			$y = substr($jpKingDate,4,1);
		}elseif($y_pos == 6){
			$y = substr($jpKingDate,4,2);
		}

		if($gengo == "明治"){
			$y = $y += 1868;
		}elseif($gengo == "大正"){
			$y = $y += 1911;
		}elseif($gengo == "昭和"){
			$y = $y += 1925;
		}elseif($gengo == "平成"){
			$y = $y += 1988;
		}

		//文字列を年月日で分解する
		$pos_y = preg_split("/年/",$jpKingDate);
		$pos_m = preg_split("/月/",$pos_y['1']);
		$pos_d = preg_split("/日/",$pos_m['1']);

		$return = $y."-".$pos_m['0']."-".$pos_d['0'];

		return $return;
	}

	public function jsonExport($data)
	{
		$json = json_encode($data);
		echo $json;
		exit;
	}

	public function toJson($data)
	{
		// return $this->jsonExport($data);
		return \Response::json($data);
	}

	public function add()
	{
		$url = $this->url_pattern . '.edit';
		$message = NULL;
		$alert_type = NULL;

		if($this->form_input && (count($this->form_input) > 0)){ // Submit
			$form_input = $this->form_input;

			$this->model->fill($this->form_input);
			$this->model->save(); //insert
			$alert_type = "success";
			$message = "追加完了。";

			return redirect("/" . str_replace(".", "/", $this->url_pattern))->with(["message"=>$message, "alert_type" => $alert_type]);
		}

		return view("/" . str_replace(".", "/", $url), ['data'=>$this->data, "logged_in_user"=>$this->logged_in_user, "model"=>$this->model]);
	}

	public function edit($id)
	{
		$this->blade_url = $this->url_pattern . '.edit';
		$message = NULL;
		$alert_type = NULL;

		// $this->model = $this->model->find($id);
		$this->model = $this->model->where("id", $id);
		$this->model = $this->model->where("organization_id", \Auth::user()->organization_id);
		$this->model = $this->model->first();


		if(!$this->model){
			return redirect("/" . str_replace(".", "/", $this->url_pattern) . '/add')->with(["message"=>"データが存在していませんから、追加画面に遷移しました。", "alert_type" => $alert_type]);
		}

		if($this->form_input){ // Submit
			$form_input = $this->form_input;

			$this->model->fill($this->form_input);
			$this->model->update();
			$alert_type = "success";
			$message = "データ（ID: " . $id . "）が修正完了。";
		}

		return view("/" . str_replace(".", "/", $this->blade_url), ['data'=>$this->data, "logged_in_user"=>$this->logged_in_user, "model"=>$this->model])->with(["message"=>$message, "alert_type" => $alert_type]);
	}

	public function delete($id)
	{
		$message = NULL;
		$alert_type = NULL;

		$this->model = $this->model->find($id);

		if(!$this->model){
			$message = "データ（ID: " . $id . "）が存在していません。";
			return redirect("/" . str_replace(".", "/", $this->url_pattern))->with(['data' => $this->data, 'message'=>$message]);
		}

		if(!in_array($this->logged_in_user->permission_flag, array("Administrator", "Manager"))){
			$message = "データの追加修正削除に関しては、システム管理者までお問い合わせください。";
		}else{
			if($this->logical_delete){
				$this->model->is_deleted = 1;
				$this->model->update();
			}else{
				$this->model->delete();
			}
			$alert_type = "success";
			$message = "データ（ID: " . $id . "）が削除完了。";
		}

		return redirect("/" . str_replace(".", "/", $this->url_pattern))->with(['data' => $this->data, 'message'=>$message, "alert_type" => $alert_type]);

	}

	public function recover($id)
	{
		$message = NULL;
		$alert_type = NULL;

		$this->model = $this->model->find($id);

		if(!$this->model){
			$message = "データ（ID: " . $id . "）が存在していません。";
			return redirect("/" . str_replace(".", "/", $this->url_pattern))->with(['data' => $this->data, 'message'=>$message]);
		}

		if(!in_array($this->logged_in_user->permission_flag, array("Administrator", "Manager"))){
			$message = "データの追加修正削除に関しては、システム管理者までお問い合わせください。";
		}else{
			$this->model->is_deleted = 0;
			$this->model->update();

			$alert_type = "success";
			$message = "データ（ID: " . $id . "）が復元完了。";
		}

		return redirect("/" . str_replace(".", "/", $this->url_pattern))->with(['data' => $this->data, 'message'=>$message, "alert_type" => $alert_type]);

	}

}
