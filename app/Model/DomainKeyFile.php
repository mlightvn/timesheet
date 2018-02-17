<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DomainKeyFile extends Model
{
	protected $fillable = [
		'id',
		'domain_id',
		'organization_id',
		'name',
	];

	protected $table = 'domain_key_file';
}
