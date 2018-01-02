<?php namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Model\Organization;

class OrganizationController extends Controller {

	protected function init()
	{
		parent::init();

		$this->model = new Organization();
		$this->url_pattern = "admin.organization";
		$this->data["url_pattern"] = "/admin/organization";
	}

	public function list($request_data = array())
	{
		if(isset($this->form_input["keyword"])){
			$keyword = $this->form_input["keyword"];

			$column_list = array();
			$column_list["name"] = $keyword;
			$column_list["website"] = $keyword;

			$request_data["where"]["keyword"]["column_list"] = $column_list;
		}

		return parent::list($request_data);
	}

}
