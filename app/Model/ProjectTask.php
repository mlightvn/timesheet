<?php

namespace App\Model;

class ProjectTask extends BaseModel
{
	const EXCEL_FLAG = 1;

	protected $fillable = [
		'id',
		'project_id',
		'name',
		'description',
	];

	protected $table = 'project_task';

	protected function init()
	{
		parent::init();

		$this->is_deleted = "is_deleted";
		$this->search_columns = ["id", "name", "description"];

	}

	public function getAllList($whereCondition = array())
	{
		$table = \DB::table('project');

		$table = $table->select([
				\DB::raw("project.id 						AS 'project_id'"),
				\DB::raw("project.name 						AS 'project_name'"),
				\DB::raw("project.description 				AS 'project_description'"),

				\DB::raw("project_task.id 					AS 'project_task_id'"),
				\DB::raw("project_task.name 				AS 'project_task_name'"),
				\DB::raw("project_task.description 			AS 'project_task_description'"),
				"project_task.excel_flag",

				\DB::raw("organization.name AS organization_name"),
				\DB::raw("CASE project_task.is_deleted WHEN 1 THEN 'w3-gray' ELSE '' END AS DELETED_CSS_CLASS"),
				\DB::raw("CASE project_task.is_deleted WHEN 0 THEN 1 ELSE 0 END AS DELETE_FLAG_ACTION"),
				\DB::raw("CASE project_task.is_deleted WHEN 1 THEN 'fa fa-recycle' ELSE 'fa fa-trash' END AS DELETED_RECOVER_ICON"),
				\DB::raw("CASE project_task.is_deleted WHEN 1 THEN 'w3-green' ELSE 'w3-red' END AS DELETED_RECOVER_COLOR"),
				\DB::raw("user_project_task.project_task_id AS SELF_PROJECT"),
			]);

		$table = $table->join('project_task'					, 'project.id'						, '=', 'project_task.project_id');
		$table = $table->join("organization"					, "project.organization_id"			, "=", "organization.id");

		if(!empty($whereCondition["user_id"])){
			$subQuery = "( SELECT * FROM user_project_task WHERE user_id = '" . $whereCondition["user_id"] . "') AS user_project_task ";
		}else{
			$subQuery = "user_project_task";
		}
		$table = $table->leftJoin(\DB::raw($subQuery)			, "project_task.id"						, "=", "user_project_task.project_task_id");

		if(!empty($whereCondition["keyword"])){
			$where = " (
							   (project_task.id = '{KEYWORD}')
							OR (project_task.name LIKE '%{KEYWORD}%')
						)";
			$where = str_replace("{KEYWORD}", $whereCondition["keyword"], $where);

			$table = $table->whereRaw($where);
		}

		if(isset($whereCondition["is_deleted"])){
			$table = $table->where("project_task.is_deleted", $whereCondition["is_deleted"]);
		}

		if(isset($whereCondition["own_project_task"])){
			$table = $table->whereRaw("user_project_task.user_id IS NOT NULL");
		}

		$table = $table->where("organization.id", "=", \Auth::user()->organization_id);

		$table = $table->orderBy("project.is_deleted", "ASC");
		$table = $table->orderBy("project.id", "ASC");
		$table = $table->orderBy("project_task.is_deleted", "ASC");
		$table = $table->orderBy("project_task.id", "ASC");

		if(!isset($whereCondition["isPagination"])){
			$arrResult = $table->paginate(env('NUMBER_OF_RECORD_PER_PAGE'));
		}else{
			$arrResult = $table->get();
		}

		return $arrResult;
	}

	public function getTimeSheetList($user = null, $year, $month, $excel_flag = null)
	{
		$timeSheetList = array();
		if(!isset($user)){
			$user = \Auth::user();
		}

		$timeSheetList["ProjectList"] = $this->getProjectList($user->id);
		$timeSheetList["ProjectTaskTimesTotal"] = $this->getProjectTaskTimesTotal($user->id, $year, $month);

		$timeSheetList["total_hours_label"] = "00:00";

		$timeSheetList["TimeSheet"] = array();
		foreach ($timeSheetList["ProjectList"] as $key => $project) {
			$project_times = array();
			$total_hours = 0;

			foreach ($timeSheetList["ProjectTaskTimesTotal"] as $key => $times) {
				if($project->id == $times->project_id){
					$project_times["project"] 						= $project->name;
					$project_times["times"] 						= $times;
					$total_hours += $times->total_working_minutes;
				}
			}
			// $project
			$timeSheetList["TimeSheet"][$project->id] = $project_times;
		}
dd($timeSheetList);
		return $timeSheetList;
	}

	public function getProjectTaskTimesTotal($user_id, $year, $month)
	{
		$year_month = $year . "-" . $month;

		$sql = "
SELECT
	  sub_working_hour.project_id

	, sub_working_hour.project_task_name
	, sub_working_hour.total_working_minutes
	, CONCAT(
			IF(sub_working_hour.HOUR_VALUE < 10, CONCAT('0', sub_working_hour.HOUR_VALUE), sub_working_hour.HOUR_VALUE)
			, ':'
			, sub_working_hour.MINUTE_VALUE
	) AS 'total_hours_label'

  FROM (
		SELECT
			   `project`.id												AS 'project_id'
			 , `project_task`.name 										AS 'project_task_name'
			 , SUM(working_date.working_minutes) 						AS 'total_working_minutes'
			 , FLOOR(SUM(working_date.working_minutes) / 60) 			AS 'HOUR_VALUE'
			 , LPAD(
					MOD(SUM(working_date.working_minutes), 60), 2, '0'
				) 														AS 'MINUTE_VALUE'
		  FROM `working_date`
			   INNER JOIN `project_task` 				ON (`working_date`.project_task_id = `project_task`.id)
			   INNER JOIN `project` 					ON (`project_task`.project_id = `project`.id)
		 WHERE `working_date`.`user_id` 				= {USER_ID}
		   AND `working_date`.`date` 					LIKE '{REQUESTED_DATE}'
		   AND `working_date`.`working_minutes` 		> 0

		 GROUP BY `project`.id
			 , `project_task`.name
	  ) AS `sub_working_hour`

		";

		$sql = str_replace("{USER_ID}", $user_id, $sql);
		$sql = str_replace("{REQUESTED_DATE}", $year_month . "-%", $sql);

		$workingDate = \DB::select($sql);
		$workingDate = collect($workingDate);

		return $workingDate;
	}

	public function getProjectList($user_id, $excel_flag = NULL)
	{
		$organization_id = \Auth::user()->organization_id;

		$sql = "
SELECT
	   project.id
	 , project.name
	 , project.description

  FROM project
	   LEFT JOIN (
			SELECT project_task.project_id
				 , user_project_task.user_id
			  FROM project_task
				   INNER JOIN user_project_task ON (project_task.id = user_project_task.project_task_id)
			 WHERE 1 = 1
			   AND project_task.is_deleted = 0
			   {EXCEL_FLAG_CONDITION}
			 GROUP BY project_task.project_id
				 , user_project_task.user_id
	   ) sub_task ON (project.id = sub_task.project_id)

 WHERE 1 = 1
   AND project.organization_id = {ORGANIZATION_ID}
   AND sub_task.user_id = {USER_ID}

AND project.is_deleted = 0

		";

		if($excel_flag){
			$excel_flag_condition = "AND project_task.excel_flag = " . $excel_flag;
		}else{
			$excel_flag_condition = "";
		}

		$sql = str_replace("{ORGANIZATION_ID}", $organization_id, $sql);
		$sql = str_replace("{USER_ID}", $user_id, $sql);
		$sql = str_replace("{EXCEL_FLAG_CONDITION}", $excel_flag_condition, $sql);

		$workingDate = \DB::select($sql);
		$workingDate = collect($workingDate);

		return $workingDate;
	}

}
