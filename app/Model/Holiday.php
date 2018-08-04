<?php

namespace App\Model;

class Holiday extends BaseModel
{
	protected $fillable = [
		'date',
		'is_holiday',
	];
	protected $table = 'holiday';
	protected $primaryKey = 'date';
	protected $keyType = "date";
}
