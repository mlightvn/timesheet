<?php

namespace App\Model;

class ProjectTask extends BaseModel
{
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

	public function getAllList($user_id = NULL, $keyword = NULL, $isPagination = true, $is_deleted_display = true)
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

		if(!empty($user_id)){
			$subQuery = "( SELECT * FROM user_project_task WHERE user_id = '" . $user_id . "') AS user_project_task ";
		}else{
			$subQuery = "user_project_task";
		}
		$table = $table->leftJoin(\DB::raw($subQuery)			, "project_task.id"						, "=", "user_project_task.project_task_id");

		if($keyword){
			$where = " (
							   (project_task.id = '{KEYWORD}')
							OR (project_task.name LIKE '%{KEYWORD}%')
						)";
			$where = str_replace("{KEYWORD}", $keyword, $where);

			$table = $table->whereRaw($where);
		}

		if($is_deleted_display == false){
			$table = $table->where("project_task.is_deleted", "0");
		}

		$table = $table->where("organization.id", "=", \Auth::user()->organization_id);

		$table = $table->orderBy("project_task.is_deleted", "ASC");
		$table = $table->orderBy("project_task.id", "ASC");

		if($isPagination){
			$arrResult = $table->paginate(env('NUMBER_OF_RECORD_PER_PAGE'));
		}else{
			$arrResult = $table->get();
		}

		return $arrResult;
	}

}
