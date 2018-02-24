<?php namespace App\Http\Controllers\User;

// use Illuminate\Http\Request;
use App\Model\Session;

class SessionController extends Controller {

	protected function init()
	{
		parent::init();

		$this->model = new Session();

		// 新規追加画面、デフォルトの価値を定義
		$this->model->organization_id 		= $this->organization_id;
		$this->url_pattern 					= "user.session";
		$this->data["url_pattern"] 			= "/user/session";

	}

	public function list()
	{
		$url = $this->url_pattern . '.index';

		$keyword = null;
		if(isset($this->form_input["keyword"])){
			$keyword = $this->form_input["keyword"];
		}
		$this->data["keyword"] = $keyword;

		$arrSessions = $this->getSessions(true, NULL, NULL, $keyword);

		return view("/" . str_replace(".", "/", $url), ['data'=>$this->data, "logged_in_user"=>$this->logged_in_user, "arrSessions"=>$arrSessions]);
	}

}
