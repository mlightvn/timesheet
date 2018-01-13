<?php

namespace App\Model;

class ApplicationForm extends Dayoff
{
	// protected $fillable = [
	// 	'id',
	// 	'name',
	// 	'description',
	// 	'applied_user_id',
	// 	'approved_user_id',
	// 	'status', // 0: Applied, 1: Approved, 2: Dismissed
	// 	'is_deleted',
	// ];

	protected $table = 'application_form';
}
