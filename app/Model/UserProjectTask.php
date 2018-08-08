<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserProjectTask extends Model
{
	protected $fillable = [
		'user_id',
		'project_task_id',
		'task_priority',	// 'Normal', 'Priority'
	];
	protected $table = 'user_project_task';
}
