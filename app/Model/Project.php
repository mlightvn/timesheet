<?php

namespace App\Model;

class Project extends BaseModel
{

	protected $fillable = [
		'id',
		'organization_id',
		'name',
		'description',
	];

	protected $table = 'project';

	protected function init()
	{
		parent::init();

		$this->organization_id = \Auth::user()->organization_id;
		$this->is_deleted = "is_deleted";
		$this->search_columns = ["id", "name", "description"];

	}

}
