<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class WorkingDate extends Model
{
	protected $fillable = [
		'organization_id',
		'user_id',
		'project_id',
		'date',
		'approved_user_id',
		'working_minutes',
	];

	protected $table = 'working_date';
}
