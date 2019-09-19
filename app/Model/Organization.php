<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
	protected $fillable = [
		'id',
		'slug',
		'name',
		'member_limitation',
		'established_date',
		'ceo',
		'website',
		'capital',
		'size',
		'description',
		'is_activated',
		'is_deleted',
	];

	protected $table = 'organization';

	public function Users()
	{
		return $this->hasMany("App\Model\User", "organization_id");
	}

}
