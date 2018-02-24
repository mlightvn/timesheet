<?php namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Model\Project;
use App\Model\UserProject;

class ProjectController extends Controller {

	protected function init()
	{
		parent::init();

		$this->model = new Project();

		// 新規追加画面、デフォルトの価値を定義
		$this->model->organization_id 		= $this->organization_id;
		$this->url_pattern 					= "user.project";
		$this->data["url_pattern"] 			= "/user/project";

	}

}
