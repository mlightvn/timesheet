<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
	protected $fillable = [
		'id',
		'name',
		'url',
		'admin_url',
		'admin_username',
		'admin_password',
		'repository_url',
		'description',
		'ssh_description',
		'db_description',
		'development_flag', // 0: production, 1: Staging, 2: development
		'is_deleted',
	];

	protected $table = 'domain';
}
