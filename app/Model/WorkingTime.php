<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class WorkingTime extends Model
{
	protected $fillable = [
		'user_id',
		'task_id',
		'date',
		'time',
	];
    protected $table = 'working_time';
}
