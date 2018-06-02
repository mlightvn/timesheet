<?php namespace App\Http\Controllers\Master;

use App\Model\Price;

class PriceController extends Controller {

	protected function init()
	{
		parent::init();

		$this->model = new Price();
		$this->url_pattern = "master.price";
		$this->data["url_pattern"] = "/master/price";
	}

	public function list()
	{
		if(isset($this->form_input["keyword"])){
			$keyword = $this->form_input["keyword"];

			$column_list = array();
			$column_list["name"] = $keyword;
			$column_list["website"] = $keyword;

			$this->data["request_data"]["where"]["keyword"]["column_list"] = $column_list;
		}

		return parent::list();
	}

}
