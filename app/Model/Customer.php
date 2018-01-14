<?php

namespace App\Model;

class Customer extends User
{

	protected $fillable = [
		'id',
		'organization_id',
		'email',
		'name',
		'gender',
		'birthday',
		'phone',

		'remember_token',

	];

	protected $table = 'customer';

}
