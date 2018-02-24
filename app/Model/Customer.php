<?php

namespace App\Model;

class Customer extends User
{

	protected $fillable = [
		'id',
		'organization_id',
		'email',
		'sub_email',
		'name',
		'gender',
		'birthday',
		'tel',
		'phone',
		'description',

		'remember_token',

	];

	protected $table = 'customer';

}
