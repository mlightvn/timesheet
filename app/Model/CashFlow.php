<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CashFlow extends Model
{
	protected $fillable = [
		'id',
		'organization_id',
		'name',
		'amount',
		'in_out_flag',
		'datetime',
	];

	protected $table = 'cashflow';
}
