<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
	protected $fillable = [
		'id',
		'organization_id',
		'name',
		'url',
		'bookmark_folder_id',
		'description',
		'deleted_flag',
	];

	protected $table = 'bookmark';
}
