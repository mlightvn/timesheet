<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
	protected $fillable = [
		'id',
		'user_id',
		'name',
		'url',
		'admin_url',
		'admin_username',
		'admin_password',
		'repository_url',
		'description',
		'ssh_access_command',
		'ssh_description',
		'db_access_command',
		'db_description',
		'development_flag', // 0: production, 1: Staging, 2: development
		'is_deleted',
	];

	protected $table = 'domain';
}
