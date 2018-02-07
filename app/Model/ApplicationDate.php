<?php

namespace App\Model;

class ApplicationDate
{
	protected $fillable = [
		'application_form_id',
		'applied_date',
		'approved_user_id'
		'status', // 0: Applied, 1: Approved, 2: Dismissed
	];

	protected $table = 'application_date';
}
