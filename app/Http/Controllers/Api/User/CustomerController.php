<?php namespace App\Http\Controllers\Api\User;

use App\Model\Customer;

class CustomerController extends \App\Http\Controllers\Api\Controller {

	protected function init()
	{
		parent::init();

		$this->model = new Customer();

		// 新規追加画面、デフォルトの価値を定義
		$this->model->organization_id 		= $this->organization_id;
	}

	protected function querySetup()
	{
		$orderBy_a = array();
		$orderBy_a["is_deleted"] 					= "ASC";
		$orderBy_a["id"] 							= "DESC";
		$this->data["request_data"]["orderBy"] 		= $orderBy_a;
	}

	protected function getModelList()
	{
		$model = parent::getModelList();

		$model = $model->select([
					"customer.*",
					\DB::raw("CASE customer.is_deleted WHEN 1 THEN 'w3-gray' ELSE '' END AS DELETED_CSS_CLASS"),
					\DB::raw("CASE customer.is_deleted WHEN 0 THEN 1 ELSE 0 END AS DELETE_FLAG_ACTION"),
					\DB::raw("CASE customer.is_deleted WHEN 1 THEN 'fa fa-recycle w3-text-green' ELSE 'fa fa-trash w3-text-red' END AS DELETED_RECOVER_CLASS"),
		]);
		$model = $model->where("organization_id", "=", $this->organization_id);

		return $model;
	}

}
