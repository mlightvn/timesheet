<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Domain;

class AdminDomainController extends AdminController {

	protected function init()
	{
		parent::init();

		$this->model = new Domain();
		$this->url_pattern = "admin.domain";
		$this->data["url_pattern"] = "/admin/domain";
		$this->logical_delete = true;
	}

	public function index()
	{
		$this->blade_url = $this->url_pattern . '.index';

		$keyword = null;
		if(isset($this->form_input["keyword"])){
			$keyword = $this->form_input["keyword"];
		}
		$this->data["keyword"] = $keyword;

		$arrModel = $this->model->paginate();

		return view($this->blade_url, ['data'=>$this->data, "logged_in_user"=>$this->logged_in_user, "arrModel"=>$arrModel]);
	}

}
