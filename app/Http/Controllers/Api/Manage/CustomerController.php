<?php namespace App\Http\Controllers\Api\Manage;

use Illuminate\Http\Request;
use App\Model\Customer;

class CustomerController extends \App\Http\Controllers\Api\Controller {

	protected function init()
	{
		parent::init();

		$this->model = new Customer();

		// 新規追加画面、デフォルトの価値を定義
		$this->model->organization_id 		= $this->organization_id;
	}

	protected function getModelList()
	{
		$model = parent::getModelList();

		$model = $model->select([
					"customer.*",
					\DB::raw("CASE customer.is_deleted WHEN 1 THEN 'w3-gray' ELSE '' END AS DELETED_CSS_CLASS"),
		]);
		$model = $model->where("organization_id", "=", $this->organization_id);

		return $model;
	}

}
