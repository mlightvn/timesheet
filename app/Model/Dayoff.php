<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Dayoff extends Model
{
	protected $fillable = [
		'id',
		'organization_id',
		'name',
		'description',
		'applied_user_id',
		'date_list',
		// 'approved_user_id',
		// 'datetime_from',
		// 'datetime_to',
		// 'status', // 0: Applied, 1: Approved, 2: Dismissed
		'is_deleted', // 0: normal, 1: deleted
	];

	protected $table = 'application_form';
}
