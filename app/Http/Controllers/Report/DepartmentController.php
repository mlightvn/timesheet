<?php namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Model\Department;

class DepartmentController extends Controller {

	protected function init()
	{
		parent::init();

		$this->model = new Department();

		$this->blade_url = $this->url_pattern . '.department';
		$this->data["url_pattern"] = "/" . str_replace(".", "/", $this->blade_url);

	}

	public function index()
	{
		$this->blade_url = $this->url_pattern . '.department';
		$url = $this->url_pattern . '.department';

		$prev_yearmonth = date('Y-m', strtotime('first day of previous month'));
		$curr_yearmonth = date('Y-m');

		$prev_year 						= date('Y', strtotime('first day of previous month'));
		$prev_month 					= date('m', strtotime('first day of previous month'));
		$curr_year 						= date('Y');
		$curr_month 					= date('m');

		$data["logged_in_user"] 		= $this->logged_in_user;

		$keyword = null;
		if(isset($this->form_input["keyword"])){
			$keyword = $this->form_input["keyword"];
		}
		$this->data["keyword"] = $keyword;

		$arrSessions = $this->getDepartments(true, NULL, NULL, $keyword);

		$this->data["title"] 					= __("screen.menu.report.summary_by_department");
		$this->data["prev_yearmonth"] 			= $prev_yearmonth;
		$this->data["curr_yearmonth"] 			= $curr_yearmonth;

		$this->data["prev_year"] 			= $prev_year;
		$this->data["prev_month"] 			= $prev_month;
		$this->data["curr_year"] 			= $curr_year;
		$this->data["curr_month"] 			= $curr_month;

		return view("/" . str_replace(".", "/", $url), ['data'=>$this->data, "logged_in_user"=>$this->logged_in_user, "arrSessions"=>$arrSessions]);
	}

	// public function download($year, $month = NULL, $day = NULL){
	// 	$params = array();

	// 	$params["user_list"] 		= array();
	// 	$params["user_list"][$this->reportUser->id] = $this->reportUser;

	// 	$params["year"] 			= $year;
	// 	$params["month"] 			= $month;
	// 	$params["day"] 				= $day;

	// 	$this->downloadBy($params);
	// }

	public function reportDownload($department_id, $year, $month = NULL)
	{
		if(!$year){
			$year = date('Y');
		}

		if(!$month){
			$month = date('m');
		}

		$day = date('d');

		$model = new Session();
		$model = $model->select([
				"users.id",
				"users.name",

				\DB::raw("users.id 					AS 'user_id'"),
				\DB::raw("users.name 				AS 'user_name'"),
		]);
		$model = $model->join("users", "users.department_id", "=", "session.id");
		$model = $model->where("session.id", "=", $department_id);
		$model = $model->where("session.is_deleted", "=", "0");
		$model = $model->where("users.is_deleted", "=", "0");
		$user_list = $model->get();

		$params = array();

		$params["user_list"] 		= $user_list;

		$params["year"] 			= $year;
		$params["month"] 			= $month;

		$this->downloadBy($params);

	}
}
