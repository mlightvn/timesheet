<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
	protected $fillable = [
		'id',
		'organization_id',
		'name',
		'is_off_task',		// '0': FALSE, '1': TRUE
	];

	protected $table = 'project';
}
