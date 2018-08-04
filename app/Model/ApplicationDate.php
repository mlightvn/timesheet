<?php

namespace App\Model;

class ApplicationDate extends BaseModel
{
	protected $fillable = [
		'application_form_id',
		'applied_date',
		'approved_user_id',
		'status', // 0: Applied, 1: Approved, 2: Dismissed
	];

	protected $table = 'application_date';
	// protected $primaryKey = ['application_form_id', 'applied_date',];
	public $incrementing = false;

	protected function init()
	{
		parent::init();

		$this->search_columns = ["application_form_id", "applied_date"];

	}

}
