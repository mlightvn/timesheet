<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
	protected $fillable = [
		'id',
		'name',
		'is_off_task',		// '0': FALSE, '1': TRUE
	];

	protected $table = 'task';
}
