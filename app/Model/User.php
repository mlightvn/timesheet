<?php

namespace App\Model;

// use Illuminate\Auth\Authenticatable;
// use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

	// use Authenticatable, CanResetPassword;
	use Notifiable;

	protected $guard = 'admin';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'id',
		'organization_id',
		'email',
		'sub_email',
		'password',
		'name',
		'role', // Master: admin of website, Owner: representative/owner of organization, Manager: Manager, "member" : workers, staff at organization
		'session_id',

		'dayoff',
		'gender',
		'birthday',
		'tel',
		'phone',
		'description',

		'remember_token',

	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];


	public function setPasswordAttribute($password)
	{
		$this->attributes['password'] = \Hash::make($password);
	}
}
