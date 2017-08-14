<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserTask extends Model
{
	protected $fillable = [
		'user_id',
		'task_id',
		'task_priority',	// 'Normal', 'Priority'
	];
	protected $table = 'user_task';
}
