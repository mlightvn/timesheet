<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ApplicationDate extends Model
{
	protected $fillable = [
		'application_form_id',
		'applied_date',
		'approved_user_id',
		'status', // 0: Applied, 1: Approved, 2: Dismissed
	];

	protected $table = 'application_date';
	// protected $primaryKey = ['application_form_id', 'applied_date',];
	public $incrementing = false;
}
