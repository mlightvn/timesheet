<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
	protected $fillable = [
		'id',
		'name',
		'website',
		'description',
		'is_deleted',
	];

	protected $table = 'organization';
}
