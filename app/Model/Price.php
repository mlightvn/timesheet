<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
	protected $fillable = [
		'id',
		'name',
		'price',
		'description',
		'start_date',
		'end_date',
		'deleted_flag',
	];

	protected $table = 'price';
}
