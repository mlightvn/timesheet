<?php namespace App\Http\Controllers\Master;

use App\Model\Organization;

class OrganizationController extends Controller {

	protected function init()
	{
		parent::init();

		$this->model = new Organization();
		$this->url_pattern = "master.organization";
		$this->data["url_pattern"] = "/master/organization";
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
