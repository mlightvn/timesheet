<?php namespace App\Http\Controllers\User;

// use Illuminate\Http\Request;
use App\Model\Customer;

class CustomerController extends Controller {

	protected function init()
	{
		parent::init();

		$this->model = new Customer();

		// 新規追加画面、デフォルトの価値を定義
		$this->model->organization_id 		= $this->organization_id;
		$this->url_pattern = "user.customer";
		$this->data["url_pattern"] = "/user/customer";
	}

}
