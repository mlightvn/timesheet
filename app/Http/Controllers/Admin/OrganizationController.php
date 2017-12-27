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

}
