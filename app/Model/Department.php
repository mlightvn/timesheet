<?php

namespace App\Model;

class Department extends BaseModel
{
	protected $fillable = [
		'id',
		'name',
		'organization_id',
	];

	protected $table = 'department';

	protected function init()
	{
		parent::init();

		$this->organization_id = \Auth::user()->organization_id;
		$this->is_deleted = "is_deleted";
		$this->search_columns = ["id", "name", "description"];

	}
}
