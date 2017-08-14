<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
	protected $fillable = [
		'date',
		'is_holiday',
	];
	protected $table = 'holiday';
	protected $primaryKey = 'date';
	protected $keyType = "date";
}
