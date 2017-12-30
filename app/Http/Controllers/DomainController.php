<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Domain;

class DomainController extends Controller {

	protected function init()
	{
		parent::init();

		$this->model = new Domain();

		// 新規追加画面、デフォルトの価値を定義
		$this->model->organization_id 		= $this->logged_in_user->organization_id;
		$this->model->url 					= "";
		$this->model->admin_url 			= "";
		$this->model->repository_url 		= "";

		$this->url_pattern 					= "domain";
		$this->data["url_pattern"] 			= "/domain";
		$this->logical_delete 				= true;
	}

	public function index()
	{
		$this->blade_url = $this->url_pattern . '.index';
		return view($this->blade_url, ['data'=>$this->data, "logged_in_user"=>$this->logged_in_user]);
	}

}
