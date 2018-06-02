<?php namespace App\Http\Controllers\Api;

use App\Model\Price;

class PriceController extends Controller {


	protected function init()
	{
		parent::init();

		$this->model = new Price();
	}

	protected function querySetup()
	{

		$this->model = $this->model->select([
					"price.*",

					\DB::raw("CASE price.is_deleted WHEN 1 THEN 'w3-gray' ELSE '' END AS DELETED_CSS_CLASS"),
					\DB::raw("CASE price.is_deleted WHEN 0 THEN 1 ELSE 0 END AS DELETE_FLAG_ACTION"),
					\DB::raw("CASE price.is_deleted WHEN 1 THEN 'fa fa-recycle' ELSE 'fa fa-trash' END AS DELETED_RECOVER_ICON"),
					\DB::raw("CASE price.is_deleted WHEN 1 THEN 'w3-green' ELSE 'w3-red' END AS DELETED_RECOVER_COLOR"),
		]);
	}

}
