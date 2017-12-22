<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Dayoff extends Model
{
	protected $fillable = [
		'id',
		'name',
		'description',
		'is_deleted',
	];

	protected $table = 'domain';
}
