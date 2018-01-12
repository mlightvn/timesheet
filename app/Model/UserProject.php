<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserProject extends Model
{
	protected $fillable = [
		'organization_id',
		'user_id',
		'project_id',
		'project_priority',	// 'Normal', 'Priority'
	];
	protected $table = 'user_project';
}
