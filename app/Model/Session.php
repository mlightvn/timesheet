<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
	protected $fillable = [
		'id',
		'name',
		'organization_id',
	];

	protected $table = 'session';
}
