<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
	protected $fillable = [
		'id',
		'organization_id',
		'name',
		'url',
		'admin_url',
		'admin_username',
		'admin_password',
		'description',

		'ssh_access_command',
		'ssh_description',
		'ssh_host',
		'ssh_username',
		'ssh_password',

		'repository_url',
		'repository_username',
		'repository_password',
		'repository_description',

		'db_host',
		'db_name',
		'db_username',
		'db_password',
		'db_access_command',
		'db_description',

		'development_flag', // 1: production, 2: Staging, 3: development, 4: Others
		'is_deleted',
	];

	protected $table = 'domain';
}
