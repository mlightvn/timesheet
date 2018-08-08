<?php

namespace App\Model;

class UserProjectTask extends BaseModel
{
	protected $fillable = [
		'user_id',
		'project_task_id',
		'task_priority',	// 'Normal', 'Priority'
	];
	protected $table = 'user_project_task';
}
