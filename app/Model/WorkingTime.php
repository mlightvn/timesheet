<?php

namespace App\Model;

class WorkingTime extends BaseModel
{
	protected $fillable = [
		'user_id',
		'project_task_id',
		'date',
		'time',
	];

	protected $table = 'working_time';

	public function init()
	{
		$this->search_columns = ['user_id', 'date', 'time'];
	}

	public function getTimeSheetList($user_id = NULL, $project_task_id = NULL, $date = NULL)
	{
		$table = $this;

		$table = $table->select(["working_time.*", \DB::raw("organization.name AS organization_name")]);

		$table = $table->join("users", "working_time.user_id", "=", "users.id");
		$table = $table->join("organization", "organization.id", "=", "users.organization_id");
		$table = $table->join("project_task", "working_time.project_task_id", "=", "project_task.id");
		$table = $table->join("project", "project.id", "=", "project_task.project_id");

		if($user_id != NULL && $user_id != ""){
			$table = $table->where("working_time.user_id", "=", $user_id);
		}
		if($project_task_id != NULL && $project_task_id != ""){
			$table = $table->where("working_time.project_task_id", "=", $project_task_id);
		}
		if($date != NULL && $date != ""){
			$table = $table->where("working_time.date", "=", $date);
		}

		$table = $table->where("organization.id", "=", \Auth::user()->organization_id);

		$table = $table->where("users.is_deleted", "=", "0");
		$table = $table->where("project_task.is_deleted", "=", "0");
		$table = $table->where("project.is_deleted", "=", "0");

		$table = $table->orderBy("project.id");
		$table = $table->orderBy("working_time.date");
		$table = $table->orderBy("working_time.time");

		$arrResult = $table->get();

		return $arrResult;
	}

}
