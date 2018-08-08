<?php

namespace App\Model;

class WorkingDate extends BaseModel
{
	protected $fillable = [
		'user_id',
		'project_task_id',
		'date',
		'approved_user_id',
		'working_minutes',
	];

	protected $table = 'working_date';

	public function getTimeSheetList($user_id, $year, $month = NULL, $day = NULL)
	{
		$data = array();
		$data["year"] 				= $year;
		$data["month"] 				= $month;
		$data["day"] 				= $day;
		$data["date"] 				= $year . "-" . $month . "-" . $day;
		$data["year_month"] 		= $year . "-" . $month;

		$workingDate = $this;

		$workingDate = $workingDate->select(\DB::raw("
				  project.id
				, project_task.id
				, working_date.user_id
				, SUM(working_date.working_minutes) AS 'total_working_minutes'
				, CONCAT(LPAD(FLOOR(SUM(working_date.working_minutes) / 60), 2, '0'), ':', LPAD(MOD(SUM(working_date.working_minutes), 60), 2, '0')) AS 'total_working_hours_label'
				, project.name AS 'project_name'
				, project_task.name AS 'project_task_name'
				"
			));

		$workingDate = $workingDate->join("project_task", "working_date.project_task_id", "=", "project_task.id");
		$workingDate = $workingDate->join("project", "project.id", "=", "project_task.project_id");

		$workingDate = $workingDate->where("working_date.user_id", "=", $user_id);
		$workingDate = $workingDate->where("working_date.date", "LIKE", $data["date"] . "%");
		$workingDate = $workingDate->where("working_date.working_minutes", ">", "0");

		$workingDate = $workingDate->groupBy(["project.id", "project_task.id", "working_date.user_id", "project.name", "project_task.name"]);
		$workingDate = $workingDate->orderBy("project.id");
		$workingDate = $workingDate->orderBy("project_task.id");
// dd($workingDate->toSql());

		$list = $workingDate->get();
// dd($list);
		return $list;
	}

}
