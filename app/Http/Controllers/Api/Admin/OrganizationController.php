<?php namespace App\Http\Controllers\Api\Admin;

use App\Model\Organization;

class OrganizationController extends \App\Http\Controllers\Api\Controller {

	protected function init()
	{
		parent::init();

		$this->model = new Organization();
	}

	protected function querySetup()
	{
		$orderBy_a = array();
		$orderBy_a["is_deleted"] 					= "ASC";
		$orderBy_a["id"] 							= "ASC";
		$this->data["request_data"]["orderBy"] 		= $orderBy_a;
	}

	protected function getModelList()
	{
		$model = parent::getModelList();

		$model = $model->select([
					"organization.*",
					\DB::raw("CASE organization.is_deleted WHEN 1 THEN 'w3-gray' ELSE '' END AS DELETED_CSS_CLASS"),
		]);

		return $model;
	}

}
