<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Foundation\Auth\ThrottlesLogins;

class AdminController extends Controller {

	use AuthenticatesUsers;

	protected $administrator;
	protected $redirectTo = '/admin';
	protected $model;
	protected $logical_delete = false;

	public function __construct(Request $request)
	{
		$this->middleware('admin', ['except' => ['login', 'logout', 'register']]);

		parent::__construct($request);
	}

	protected function init()
	{
		parent::init();

		$this->url_pattern = "admin";
	}

	public function index()
	{
		$url = "";
		if($this->url_pattern){
			$url = $this->url_pattern . '.index';
		}else{
			$url = 'admin.index';
		}

		return view($url, ['data'=>$this->data, "logged_in_user"=>$this->logged_in_user]);
	}

	public function login()
	{
		$url = $this->url_pattern . '.login';

		$logged_in_user = new \App\Model\User();

		return view($url, ['data'=>$this->data, "model" => $logged_in_user]);
	}

	public function authenticate() {
		$form_input = $this->form_input;

		$email 			= $form_input['email'];
		$password 		= $form_input['password'];

		$remember 		= isset($form_input['remember']);

		$credentials = [
				'email' 		=> $form_input['email'], 
				'password' 		=> $form_input['password'], //auto-encrypt
				'is_deleted' 	=> "0",
			];

		if ($this->guard->attempt($credentials, $remember)) {
			return redirect()->intended('/admin');
		} else {
			return redirect('/admin/login');
		}

	}

	public function logout(){
		if($this->guard->check()){
			$this->guard->logout();
		}

		$_SERVER['PHP_AUTH_USER'] = NULL;
		$_SERVER['PHP_AUTH_PW'] = NULL;

		unset($_SERVER['PHP_AUTH_USER']);
		unset($_SERVER['PHP_AUTH_PW']);

		return redirect('/admin/login');
		// return redirect()->route("admin.login");
	}

	public function add()
	{
		$url = $this->url_pattern . '.edit';
		$message = NULL;
		$alert_type = NULL;

		if($this->form_input && (count($this->form_input) > 0)){ // Submit
			$form_input = $this->form_input;

			$this->model->fill($this->form_input);
			$this->model->save(); //insert
			$alert_type = "success";
			$message = "追加完了。";

			return redirect("/" . str_replace(".", "/", $this->url_pattern))->with(["message"=>$message, "alert_type" => $alert_type]);
		}

		return view("/" . str_replace(".", "/", $url), ['data'=>$this->data, "logged_in_user"=>$this->logged_in_user, "model"=>$this->model]);
	}

	public function edit($id)
	{
		$url = $this->url_pattern . '.edit';
		$message = NULL;
		$alert_type = NULL;

		$this->model = $this->model->find($id);

		if(!$this->model){
			return redirect("/" . str_replace(".", "/", $this->url_pattern) . '/add')->with(["message"=>"データが存在していませんから、追加画面に遷移しました。", "alert_type" => $alert_type]);
		}

		if($this->form_input){ // Submit
			$form_input = $this->form_input;

			$this->model->fill($this->form_input);
			$this->model->update();
			$alert_type = "success";
			$message = "データ（ID: " . $id . "）が修正完了。";
		}

		return view("/" . str_replace(".", "/", $this->url), ['data'=>$this->data, "logged_in_user"=>$this->logged_in_user, "model"=>$this->model])->with(["message"=>$message, "alert_type" => $alert_type]);
	}

	public function delete($id)
	{
		$message = NULL;
		$alert_type = NULL;

		$this->model = $this->model->find($id);

		if(!$this->model){
			$message = "データ（ID: " . $id . "）が存在していません。";
			return redirect("/" . str_replace(".", "/", $this->url_pattern))->with(['data' => $this->data, 'message'=>$message]);
		}

		if($this->logged_in_user->session_is_manager != "Manager"){
			$message = "データの追加修正削除に関しては、システム管理者までお問い合わせください。";
		}else{
			if($this->logical_delete){
				$this->model->is_deleted = 1;
				$this->model->update();
			}else{
				$this->model->delete();
			}
			$alert_type = "success";
			$message = "データ（ID: " . $id . "）が削除完了。";
		}

		return redirect("/" . str_replace(".", "/", $this->url_pattern))->with(['data' => $this->data, 'message'=>$message, "alert_type" => $alert_type]);

	}

	public function recover($id)
	{
		$message = NULL;
		$alert_type = NULL;

		$this->model = $this->model->find($id);

		if(!$this->model){
			$message = "データ（ID: " . $id . "）が存在していません。";
			return redirect("/" . str_replace(".", "/", $this->url_pattern))->with(['data' => $this->data, 'message'=>$message]);
		}

		if($this->logged_in_user->session_is_manager != "Manager"){
			$message = "データの追加修正削除に関しては、システム管理者までお問い合わせください。";
		}else{
			$this->model->is_deleted = 0;
			$this->model->update();

			$alert_type = "success";
			$message = "データ（ID: " . $id . "）が回復完了。";
		}

		return redirect("/" . str_replace(".", "/", $this->url_pattern))->with(['data' => $this->data, 'message'=>$message, "alert_type" => $alert_type]);

	}

}
