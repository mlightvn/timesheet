<?php

namespace App\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
	// https://laravel.com/docs/5.6/eloquent
	use SoftDeletes;

	protected $fillable = [
		'id',
		'organization_id',
		'name',
		'description',
		'is_off',			// '0': FALSE, '1': TRUE
	];

	protected $dates = ['deleted_at'];

	protected $table = 'project';
}
