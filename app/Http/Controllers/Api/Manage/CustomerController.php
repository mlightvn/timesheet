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

	public function getModelList()
	{
		$model_list = parent::getModelList();
		$model_list = $model_list->where("organization_id", "=", $this->organization_id);

		return $model_list;
	}

}
