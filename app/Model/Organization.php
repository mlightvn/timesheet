<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
	protected $fillable = [
		'id',
		'name',
		'established_date',
		'ceo',
		'website',
		'capital',
		'size',
		'description',
		'is_deleted',
	];

	protected $table = 'organization';
}
