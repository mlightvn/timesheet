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
				 , `working_date`.`user_id`
				 , SUM(working_date.working_minutes) 									AS 'TOTAL_MINUTES'
				 , LPAD(FLOOR(SUM(working_date.working_minutes) / 60), 2, 0) 			AS 'HOUR_VALUE'
				 , LPAD(MOD(SUM(working_date.working_minutes), 60), 2, 0) 				AS 'MINUTE_VALUE'
			  FROM `working_date`
				   INNER JOIN `project_task` 				ON (`working_date`.project_task_id = `project_task`.id)
				   INNER JOIN `project` 					ON (`project_task`.project_id = `project`.id)
			 WHERE `working_date`.`user_id` 				= {USER_ID}
			   AND `working_date`.`date` 					LIKE '{YEAR_MONTH}%'
			   AND `working_date`.`working_minutes` 		> 0

			 GROUP BY
				   `project_task`.id
				 , `working_date`.`user_id`
			) AS sub_query_working_hours

		";
		$sub_query_working_hours = str_replace("{USER_ID}", $user_id, $sub_query_working_hours);
		$sub_query_working_hours = str_replace("{YEAR_MONTH}", $year_month, $sub_query_working_hours);
		$model = $model->join(\DB::raw($sub_query_working_hours), function($join)
		{
			$join->on('sub_query_working_hours.project_task_id', '=', 'project_task.id')
				->on('sub_query_working_hours.user_id', '=', 'user_project_task.user_id')
			;
		});

		$model = $model->where("project.organization_id", "=", \Auth::user()->organization_id);

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
