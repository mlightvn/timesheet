<?php

namespace App\Model;

class ApplicationForm extends BaseModel
{
	protected $fillable = [
		'id',
		'organization_id',
		'name',
		'description',
		'applied_user_id',
		'date_list',
		'approved_user_id',
		'status', // 0: Applied, 1: Approved, 2: Dismissed
		'is_deleted', // 0: normal, 1: deleted
	];

	protected $table = 'application_form';

	protected function init()
	{
		parent::init();

		$this->organization_id = \Auth::user()->organization_id;
		$this->is_deleted = "is_deleted";
		$this->search_columns = ["id", "name", "description", "date_list"];

	}

}
