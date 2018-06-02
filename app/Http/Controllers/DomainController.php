<?php namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Model\Domain;

class DomainController extends Controller {

	protected function init()
	{
		parent::init();

		$this->model = new Domain();

		// 新規追加画面、デフォルトの価値を定義
		$this->model->organization_id 		= $this->organization_id;
		$this->model->url 					= "";
		$this->model->admin_url 			= "";
		$this->model->repository_url 		= "";

		$this->url_pattern 					= "domain";
		$this->data["url_pattern"] 			= "/domain";
		$this->data['development_flag'] 	= $this->request->development_flag;
	}

	public function upload($domain_id)
	{
		$model = new \App\Model\Domain();
		$model = $model->find($domain_id);

		$url = $this->data["url_pattern"] . "/upload_key";
		return view($url, ["data"=>$this->data, "model"=>$model, "logged_in_user"=>$this->logged_in_user]);
	}

}
