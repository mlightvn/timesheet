<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BookmarkFolder extends Model
{
	protected $fillable = [
		'id',
		'organization_id',
		'name',
		'parent_id',
		'deleted_flag',
	];

	protected $table = 'bookmark_folder';
}
