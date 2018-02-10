<?php namespace App\Http\Controllers\Api\Report;

use Illuminate\Http\Request;
use App\Model\Organization;

class OrganizationController extends \App\Http\Controllers\Api\Controller {

	protected function init()
	{
		parent::init();

		$this->model = new Organization();
		$this->url_pattern = "admin.organization";
		$this->data["url_pattern"] = "/admin/organization";
	}

	// public function list()
	// {
	// 	if(isset($this->form_input["keyword"])){
	// 		$keyword = $this->form_input["keyword"];

	// 		$column_list = array();
	// 		$column_list["name"] = $keyword;
	// 		$column_list["website"] = $keyword;

	// 		$this->data["request_data"]["where"]["keyword"]["column_list"] = $column_list;
	// 	}

	// 	return parent::list();
	// }

	public function list()
	{
		$url = $this->url_pattern . '.index';

		$keyword = null;
		if(isset($this->form_input["keyword"])){
			$keyword = $this->form_input["keyword"];
		}
		$this->data["keyword"] = $keyword;

		$arrSessions = $this->getSessions(true, NULL, NULL, $keyword);

		return $this->toJson($arrSessions);
	}

}
