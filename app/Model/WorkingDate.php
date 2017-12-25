<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class WorkingDate extends Model
{
	protected $fillable = [
		'organization_id',
		'user_id',
		'task_id',
		'date',
		'user_approved_id',
		'working_minutes',
	];
    protected $table = 'working_date';
}
