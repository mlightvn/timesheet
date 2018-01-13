<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
	protected $fillable = [
		'id',
		'name',
	];

	protected $table = 'task';
}
