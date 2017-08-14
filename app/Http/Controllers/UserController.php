<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller {

	public function __construct(Request $request)
	{
		parent::__construct($request);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$url = "";
		if($this->url_pattern){
			$url = $this->url_pattern . '.index';
		}else{
			$url = 'index';
		}

		return view($url, ['data'=>$this->data, "logged_in_user"=>$this->logged_in_user]);
	}

}
