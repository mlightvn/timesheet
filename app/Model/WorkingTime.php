<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class WorkingTime extends Model
{
	protected $fillable = [
		'organization_id',
		'user_id',
		'project_id',
		'date',
		'time',
	];

	protected $table = 'working_time';
}
