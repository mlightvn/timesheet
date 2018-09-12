<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;

// use Illuminate\Foundation\Validation\ValidatesRequests;
// use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
// use Illuminate\Foundation\Auth\ThrottlesLogins;

use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
	// use AuthorizesRequests;
	// use DispatchesJobs;
	// use ValidatesRequests;
	use AuthenticatesUsers;

	protected $request;
	protected $data;
	protected $url_pattern = "", $blade_url = "";
	protected $form_input;
	protected $guard;
	protected $user_id;
	protected $logged_in_user;
	protected $organization_id = NULL;
	protected $logical_delete = true;
	// protected $redirectTo = '/dashboard';

	public function __construct(Request $request)
	{
		// $this->middleware('', ['except' => ['login', 'authenticate', 'logout', 'register', 'index']]);

		$this->guard = Auth::guard('admin');

		$this->request = $request;
		$this->form_input = $this->request->all();
		$this->data = array();

		$this->getLoggedInUser();

		$this->init();
	}

	protected function init(){
	}

	public function dashboard()
	{
		$url = $this->url_pattern . '.index';
		// $url = "/" . str_replace(".", "/", $url);

		return view($url, ['data'=>$this->data, "logged_in_user"=>$this->logged_in_user]);
	}

	public function index()
	{
		if($this->url_pattern){
			$this->blade_url = $this->url_pattern . '.index';
		}else{
			$this->blade_url = 'index';
		}

		return view($this->blade_url, array('data'=>$this->data, "logged_in_user"=>$this->logged_in_user));
	}

	public function getCurrentWorkDateTime()
	{
		$model = new \App\Model\WorkDateTime();

		$cur_date = date("Y-m-d");

		// $model = $model->where("organization_id", "=", $this->organization_id);
		$model = $model->where("user_id", "=", $this->user_id);
		$model = $model->where("date", "=", $cur_date);
		$model = $model->select([
			"*",

			\DB::raw("TIME_FORMAT(time_in, '%H:%i') AS 'time_in_label'"),
			\DB::raw("TIME_FORMAT(time_out, '%H:%i') AS 'time_out_label'"),
		]);
		$model = $model->first();

		return $model;
	}

	public function workCheckIn()
	{
		$model = new \App\Model\WorkDateTime();

		$cur_date = date("Y-m-d");

		$model = $model->firstOrNew([
			"organization_id" 		=> $this->organization_id,
			"user_id" 				=> $this->user_id,
			"date" 					=> $cur_date,
		]);

		$model->organization_id 	= $this->organization_id;
		$model->user_id 			= $this->user_id;
		$model->date 				= date("Y-m-d");
		$model->time_in 			= date("H:i:s");

		$model->save();

		return true;
	}

	public function workCheckOut()
	{
		$model = new \App\Model\WorkDateTime();

		$cur_date = date("Y-m-d");
		// $cur_time = date("H:i:s");

		$model = $model->where("organization_id" 		, "=", $this->organization_id);
		$model = $model->where("user_id" 				, "=", $this->user_id);
		$model = $model->where("date"					, "=", $cur_date); // CURRENT_DATE

		$model->update(array(
			'time_out' 			=> \DB::raw('CURRENT_TIME'),
			'work_hour' 		=> \DB::raw('TIMEDIFF(CURRENT_TIME, time_in)'),
		));

		return true;

	}

	protected function querySetup()
	{
	}

	protected function getModelList()
	{
		$table_name = $this->model->getTable();

		$this->querySetup();

		if(isset($this->data["request_data"]["where"]["column_list"])){
			$column_list = $this->data["request_data"]["where"]["column_list"];

			$where_a = array();
			foreach ($column_list as $column_name => $column_value) {
				$condition_s = "(" . $column_name;
				if($column_value == NULL){
					$condition_s .= " IS NULL)";
				}else{
					$condition_s .= " = '" . $column_value . "')";
				}
				$where_a[] = $condition_s;
			}
			$whereRaw = implode(" AND ", $where_a);
			$whereRaw = "( " . $whereRaw . ")";

			$this->model = $this->model->whereRaw(\DB::raw($whereRaw));
		}

		$keyword = "";
		if(isset($this->form_input["keyword"])){
			$keyword = $this->form_input["keyword"];

			if(isset($this->data["request_data"]["where"]["keyword"]["column_list"])){

				$column_list = $this->data["request_data"]["where"]["keyword"]["column_list"];
				$where_a = array();
				foreach ($column_list as $column_name => $column_value) {
					$where_a[] = "(" . $column_name . " LIKE '%" . $column_value . "%')";
				}
				$whereRaw = implode(" OR ", $where_a);
				$whereRaw = "( " . $whereRaw . ")";

				$this->model = $this->model->whereRaw(\DB::raw($whereRaw));

			}else{
				$this->model = $this->model->where($table_name . ".name", "LIKE", \DB::raw("'%" . $keyword . "%'"));
			}

		}

		if(isset($this->data["request_data"]["orderBy"])){
			$orderBy = $this->data["request_data"]["orderBy"];

			foreach ($orderBy as $column_name => $column_value) {
				if($column_value == NULL){
					$column_value = "ASC";
				}
				$this->model = $this->model->orderBy($column_name, $column_value);
			}
		}

// dd($this->model->toSql());
		$this->data["keyword"] = $keyword;

		$model_list = $this->model;

		return $model_list;
	}

	public function list()
	{
		$url = "";
		if($this->url_pattern){
			$url = $this->url_pattern . '.index';
		}else{
			$url = 'index';
		}

		$keyword = "";
		if(isset($this->form_input["keyword"])){
			$keyword = $this->form_input["keyword"];
		}

		$model_list = $this->getModelList();
		$model_list = $model_list->paginate(env('NUMBER_OF_RECORD_PER_PAGE'));

		// $this->data["keyword"] = $keyword;
		$this->data["model_list"] = $model_list;

		return view($url, array('data'=>$this->data, "logged_in_user"=>$this->logged_in_user, 'model_list'=>$model_list));
	}

	public function getLoggedInUser(){
		$this->logged_in_user = $this->guard->user();

		if($this->logged_in_user){
			$this->data["logged_in_user"] = $this->logged_in_user;
			$this->user_id = $this->logged_in_user->id;
			$this->organization_id = $this->logged_in_user->organization_id;

			\App::setLocale($this->logged_in_user->language);
			if(isset($this->logged_in_user->timezone) && (!empty($this->logged_in_user->timezone))){
				\Config::set('app.timezone', $this->logged_in_user->timezone);
			}
		}

		return $this->logged_in_user;
	}

	public function login(Request $request)
	{
		$url = 'login';

		$logged_in_user = new \App\Model\User();

		return view($url, ['data'=>$this->data, "model" => $logged_in_user]);
	}

	public function authenticate(Request $request) {
		$form_input = $this->form_input;

		$email 			= $form_input['email'];
		$password 		= $form_input['password'];

		$remember 		= isset($form_input['remember']);

		$credentials = [
				'email' 		=> $form_input['email'],
				'password' 		=> $form_input['password'], //auto-encrypt
				'is_deleted' 	=> "0",
			];

		$login_status = false;

		$user = new \App\Model\User();
		$user = $user->join("organization", "organization.id", "=", "users.organization_id");
		$user = $user->where("users.is_deleted", "0");
		$user = $user->where("organization.is_deleted", "0");

		$user = $user->where("users.email", $form_input['email']);
		$user = $user->first();

		if($user){
			$login_status = $this->guard->attempt($credentials, $remember);
		}

		if ($login_status) {
			return redirect()->intended('/');
		} else {
			$url = 'login';
			$error_message = "ログイン情報が存在していません。";
			// return redirect('/login')->with("csrf_error", $error_message);
			return view($url, ["model" => $form_input])->with("csrf_error", $error_message);
		}

	}

	public function logout(Request $request){
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
						"0000"		=> "00:00",
						"0030"		=> "00:30",
						"0100"		=> "01:00",
						"0130"		=> "01:30",
						"0200"		=> "02:00",
						"0230"		=> "02:30",
						"0300"		=> "03:00",
						"0330"		=> "03:30",
						"0400"		=> "04:00",
						"0430"		=> "04:30",
						"0500"		=> "05:00",
						"0530"		=> "05:30",
						"0600"		=> "06:00",
						"0630"		=> "06:30",
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

	public function getProjectListWithUser($isPagination, $keyword = NULL)
	{
		$table = DB::table('project');

		$table = $table->select([
				"project.*",
				\DB::raw("organization.name AS organization_name"),
				\DB::raw("CASE project.is_deleted WHEN 1 THEN 'w3-gray' ELSE '' END AS DELETED_CSS_CLASS"),
				\DB::raw("CASE project.is_deleted WHEN 0 THEN 1 ELSE 0 END AS DELETE_FLAG_ACTION"),
				\DB::raw("CASE project.is_deleted WHEN 1 THEN 'fa fa-recycle' ELSE 'fa fa-trash' END AS DELETED_RECOVER_ICON"),
				\DB::raw("CASE project.is_deleted WHEN 1 THEN 'w3-green' ELSE 'w3-red' END AS DELETED_RECOVER_COLOR"),
			]);

		$table = $table->leftJoin("organization", "project.organization_id", "=", "organization.id");

		if($keyword){
			$where = " (
							   (project.id = '{KEYWORD}')
							OR (project.name LIKE '%{KEYWORD}%')
						)";
			$where = str_replace("{KEYWORD}", $keyword, $where);

			$table = $table->whereRaw($where);
		}

		$table = $table->where("organization.id", "=", \Auth::user()->organization_id);

		$table = $table->orderBy("project.is_deleted", "ASC");
		$table = $table->orderBy("project.id", "ASC");

		if($isPagination){
			$arrResult = $table->paginate(env('NUMBER_OF_RECORD_PER_PAGE'));
		}else{
			$arrResult = $table->get();
		}

		return $arrResult;
	}

	public function getUsers($isPagination, $id = NULL, $email = NULL, $name = NULL, $keyword = NULL)
	{
		$table = new \App\Model\User();
		$request = [
			"isPagination" 		=> $isPagination,
			"id" 				=> $id,
			"email" 			=> $email,
			"name" 				=> $name,
			"keyword" 			=> $keyword,
		];
		$arrResult = $table->getList($request);

		return $arrResult;
	}

	public function getDepartments($isPagination, $id = NULL, $name = NULL, $keyword = NULL)
	{
		$table = DB::table('department');

		$table = $table->select([
				"department.*",
				DB::raw("organization.name AS organization_name"),
				DB::raw("CASE department.is_deleted WHEN 1 THEN 'w3-gray' ELSE '' END AS DELETED_CSS_CLASS"),
				\DB::raw("CASE department.is_deleted WHEN 0 THEN 1 ELSE 0 END AS DELETE_FLAG_ACTION"),
				\DB::raw("CASE department.is_deleted WHEN 1 THEN 'fa fa-recycle' ELSE 'fa fa-trash' END AS DELETED_RECOVER_ICON"),
				\DB::raw("CASE department.is_deleted WHEN 1 THEN 'w3-green' ELSE 'w3-red' END AS DELETED_RECOVER_COLOR"),
			]);

		$table = $table->leftJoin("organization", "department.organization_id", "=", "organization.id");

		if($id){
			$table = $table->where("department.id", "=", $id);
		}
		if($name){
			$table = $table->where("name", "LIKE", "%" . $name . "%");
		}

		if($keyword){
			$where = " (
							   (department.id = '{KEYWORD}')
							OR (department.name LIKE '%{KEYWORD}%')
						)";
			$where = str_replace("{KEYWORD}", $keyword, $where);

			$table = $table->whereRaw($where);
		}

		$table = $table->where("organization.id", "=", \Auth::user()->organization_id);

		$table = $table->orderBy("is_deleted", "ASC");
		$table = $table->orderBy("id", "ASC");

		if($isPagination){
			$arrResult = $table->paginate(env('NUMBER_OF_RECORD_PER_PAGE'));
		}else{
			$arrResult = $table->get();
		}
		return $arrResult;
	}

	// public function getUserProjectList($user_id = NULL, $project_id = NULL)
	// {
	// 	$table = DB::table('user_task');

	// 	$table = $table->select(["user_task.*", "project.*", DB::raw("organization.name AS organization_name")]);

	// 	$table = $table->join("project", "user_task.task_id", "=", "project.id");
	// 	$table = $table->leftJoin("organization", "project.organization_id", "=", "organization.id");

	// 	if($user_id){
	// 		$table = $table->where("user_task.user_id", "=", $user_id);
	// 	}
	// 	if($project_id){
	// 		$table = $table->where("user_task.task_id", "=", $project_id);
	// 	}

	// 	$table = $table->where("organization.id", "=", \Auth::user()->organization_id);
	// 	$table = $table->where("project.is_deleted", "=", "0");

	// 	$table = $table->orderBy("project.is_deleted", "ASC");
	// 	$table = $table->orderBy("user_task.project_priority", "DESC")->orderBy("project.id");

	// 	$arrResult = $table->get();
	// 	return $arrResult;
	// }

	public function getWorkingDateList($user_id = NULL, $date = NULL)
	{
		$table = DB::table('working_date');

		$table = $table->select(["working_date.*", DB::raw("organization.name AS organization_name")]);

		$table = $table->leftJoin("organization", "working_date.organization_id", "=", "organization.id");

		$table = $table->join("users", "working_date.user_id", "=", "users.id");
		$table = $table->join("project", "working_date.project_id", "=", "project.id");

		if($user_id != NULL && $user_id != ""){
			$table = $table->where("working_date.user_id", "=", $user_id);
		}
		if($date != NULL && $date != ""){
			$table = $table->where("working_date.date", "=", $date);
		}

		$table = $table->where("organizationid", "=", \Auth::user()->organization_id);

		$table = $table->where("users.is_deleted", "=", "0");
		$table = $table->where("project.is_deleted", "=", "0");

		$table = $table->orderBy("date");

		$arrResult = $table->get();
		return $arrResult;
	}

// 	public function getWorkingTimeList($user_id = NULL, $project_task_id = NULL, $date = NULL)
// 	{
// 		$table = DB::table('working_time');

// 		$table = $table->select(["working_time.*", DB::raw("organization.name AS organization_name")]);

// 		$table = $table->leftJoin("organization", "working_time.organization_id", "=", "organization.id");
// 		$table = $table->join("users", "working_time.user_id", "=", "users.id");
// 		$table = $table->join("project_task", "working_time.project_task_id", "=", "project_task.id");
// 		$table = $table->join("project", "project.id", "=", "project_task.project_id");

// 		if($user_id != NULL && $user_id != ""){
// 			$table = $table->where("working_time.user_id", "=", $user_id);
// 		}
// 		if(isset($project_task_id) && !empty($project_task_id)){
// 			$table = $table->where("working_time.project_task_id", "=", $project_task_id);
// 		}
// 		if($date != NULL && $date != ""){
// 			$table = $table->where("working_time.date", "=", $date);
// 		}

// 		$table = $table->where("organization.id", "=", \Auth::user()->organization_id);

// 		$table = $table->where("users.is_deleted", "=", "0");
// 		$table = $table->where("project_task.is_deleted", "=", "0");
// 		$table = $table->where("project.is_deleted", "=", "0");

// 		$table = $table->orderBy("working_time.date");
// 		$table = $table->orderBy("working_time.time");
// // dd($table->toSql());
// 		$arrResult = $table->get();
// 		return $arrResult;
// 	}

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
		header('Content-Type: application/json; charset=utf8');
		$json = json_encode($data);
		echo $json;
		exit;
	}

	public function toJson($data)
	{
		return $this->jsonExport($data);
		// return \Response::json($data);
	}

	public function add()
	{
		$url = $this->url_pattern . '.edit';
		$message = NULL;
		$alert_type = NULL;

		if($this->form_input && (count($this->form_input) > 0)){ // Submit
			// $form_input = $this->form_input;

			$this->model->fill($this->form_input);
			$this->model->save(); //insert
			$alert_type = "success";
			$message = __("message.status.done.add");

			return redirect("/" . str_replace(".", "/", $this->url_pattern))->with(["message"=>$message, "alert_type" => $alert_type]);
		}

		// $url = "/" . str_replace(".", "/", $url);
		return view($url, ['data'=>$this->data, "logged_in_user"=>$this->logged_in_user, "model"=>$this->model]);
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

		$exist_flag = ($this->model) ? true : false;
		if(!$exist_flag){
			return redirect("/" . str_replace(".", "/", $this->url_pattern) . '/add')->with(["message"=>"データが存在していませんから、追加画面に遷移しました。", "alert_type" => $alert_type]);
		}

		if($this->form_input){ // Submit
			$form_input = $this->form_input;

			if(($this->model instanceof \App\Model\User) && ($this->logged_in_user->id != 1) && ($id == 1))
			{

				$alert_type = "alert";
				$message = "Permission Denied.";

			}else{
				$this->model->fill($this->form_input);
				$this->model->update();
				$alert_type = "success";
				$message = __("message.status.done.edit");

			}
		}

		// $this->blade_url = "/" . str_replace(".", "/", $this->blade_url);
		return view($this->blade_url, ['data'=>$this->data, "logged_in_user"=>$this->logged_in_user, "model"=>$this->model])->with(["message"=>$message, "alert_type" => $alert_type]);

	}

	public function view($id)
	{
		$this->blade_url = $this->url_pattern . '.view';
		$message = NULL;
		$alert_type = NULL;

		$this->model = $this->model->find($id);

		if(!$this->model){
			$url = "/" . str_replace(".", "/", $this->url_pattern);
			return redirect($url)->with(["message"=>"データが存在していませんので、追加画面に遷移しました。", "alert_type" => $alert_type]);
		}

		return view($this->blade_url, ['data'=>$this->data, "logged_in_user"=>$this->logged_in_user, "model"=>$this->model]);

	}

	public function delete($id)
	{
		$message = NULL;
		$alert_type = NULL;

		$this->model = $this->model->find($id);

		if(!$this->model){
			$message = "データが存在していません。";
			return redirect("/" . str_replace(".", "/", $this->url_pattern))->with(['data' => $this->data, 'message'=>$message]);
		}

		if(!in_array($this->logged_in_user->role, array("Administrator", "Manager"))){
			$message = "データの追加修正削除に関しては、システム管理者までお問い合わせください。";
		}else{
			if($this->model instanceof \App\Model\User){
				$this->model = $this->model->whereRaw(\DB::raw('users.id <> 1'));

				$alert_type = "alert";
				$message = "Permission Denied.";
			}else{
				if($this->logical_delete){
					$this->model->is_deleted = 1;
					$this->model->update();
				}else{
					$this->model->delete();
				}

				$alert_type = "success";
				$message = "データが削除完了。";
			}
		}

		return redirect("/" . str_replace(".", "/", $this->url_pattern))->with(['data' => $this->data, 'message'=>$message, "alert_type" => $alert_type]);

	}

	public function recover($id)
	{
		$message = NULL;
		$alert_type = NULL;

		$this->model = $this->model->find($id);

		if(!$this->model){
			$message = "データが存在していません。";
			return redirect("/" . str_replace(".", "/", $this->url_pattern))->with(['data' => $this->data, 'message'=>$message]);
		}

		if(!in_array($this->logged_in_user->role, array("Administrator", "Manager"))){
			$message = "データの追加修正削除に関しては、システム管理者までお問い合わせください。";
		}else{
			$this->model->is_deleted = 0;
			$this->model->update();

			$alert_type = "success";
			$message = "データが復元完了。";
		}

		return redirect("/" . str_replace(".", "/", $this->url_pattern))->with(['data' => $this->data, 'message'=>$message, "alert_type" => $alert_type]);

	}

}
