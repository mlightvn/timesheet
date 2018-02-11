<?php namespace App\Http\Controllers\Api\Admin;

use App\Model\Organization;

class OrganizationController extends \App\Http\Controllers\Api\Controller {

	protected function init()
	{
		parent::init();

		$this->model = new Organization();
		$this->data['url_pattern'] = "/admin/organization";
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
					// \DB::raw("CONCAT('" . $this->data['url_pattern']  . "/recover/', organization.id ) AS RECOVER_URL"),
					// \DB::raw("CONCAT('" . $this->data['url_pattern']  . "/delete/', organization.id ) AS DELETE_URL"),
					\DB::raw("
							CASE organization.is_deleted WHEN 0 THEN
								CONCAT('" . $this->data['url_pattern']  . "/delete/', organization.id )
							ELSE
								CONCAT('" . $this->data['url_pattern']  . "/recover/', organization.id )
							END AS RECOVER_OR_DELETE_URL
						"),
					\DB::raw("
							CASE organization.is_deleted WHEN 0 THEN
								'fa fa-trash'
							ELSE
								'fa fa-recycle'
							END AS RECOVER_OR_DELETE_ICON
						"),
					\DB::raw("
							CASE organization.is_deleted WHEN 0 THEN
								'w3-text-red'
							ELSE
								'w3-text-green'
							END AS RECOVER_OR_DELETE_COLOR
						"),
		]);

		return $model;
	}

}
