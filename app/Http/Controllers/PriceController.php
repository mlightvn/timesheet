<?php namespace App\Http\Controllers;

use App\Model\Price;

class PriceController extends Controller {

	protected function init()
	{
		parent::init();

		$this->model = new Price();

		// 新規追加画面、デフォルトの価値を定義
		$this->model->organization_id 		= $this->organization_id;

		$this->url_pattern 					= "price";
		$this->data["url_pattern"] 			= "/price";
	}

}
