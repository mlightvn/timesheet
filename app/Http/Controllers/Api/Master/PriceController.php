<?php namespace App\Http\Controllers\Api\Master;

use App\Model\Price;

class PriceController extends \App\Http\Controllers\Api\Controller {

	protected function init()
	{
		parent::init();

		$this->model = new Price();
		$this->data['url_pattern'] = "/master/price";
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
					"price.*"
					, \DB::raw("CASE price.is_deleted WHEN 1 THEN 'w3-gray' ELSE '' END AS DELETED_CSS_CLASS")
					, \DB::raw("CASE price.is_deleted WHEN 0 THEN 1 ELSE 0 END AS DELETE_FLAG_ACTION")
					, \DB::raw("CASE price.is_deleted WHEN 1 THEN 'fa fa-recycle' ELSE 'fa fa-trash' END AS DELETED_RECOVER_ICON")
					, \DB::raw("CASE price.is_deleted WHEN 1 THEN 'w3-green' ELSE 'w3-red' END AS DELETED_RECOVER_COLOR")
		]);

		return $model;
	}

}
