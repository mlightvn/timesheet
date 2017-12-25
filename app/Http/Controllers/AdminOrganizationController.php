<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Organization;

class AdminOrganizationController extends AdminController {

	protected function init()
	{
		parent::init();

		$this->model = new Organization();
		$this->url_pattern = "admin.organization";
		$this->data["url_pattern"] = "/admin/organization";
	}

}
