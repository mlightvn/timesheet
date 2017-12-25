<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Domain;

class AdminDomainController extends AdminController {

	protected function init()
	{
		parent::init();

		$this->model = new Domain();

		// 新規追加画面、デフォルトの価値を定義
		$this->model->organization_id 		= $this->logged_in_user->organization_id;
		$this->model->url 					= "";
		$this->model->admin_url 			= "";
		$this->model->repository_url 		= "";

		$this->url_pattern 					= "admin.domain";
		$this->data["url_pattern"] 			= "/admin/domain";
		$this->logical_delete 				= true;
	}

	public function index()
	{
		$this->blade_url = $this->url_pattern . '.index';

		$this->model = $this->model->orderBy("is_deleted");
		$this->model = $this->model->orderBy("development_flag");

		$keyword = null;
		$development_flag = null;

		if(isset($this->form_input["keyword"])){
			$keyword = $this->form_input["keyword"];
		}
		if(isset($this->form_input["development_flag"])){
			$development_flag = $this->form_input["development_flag"];
		}

		$this->data["keyword"] = $keyword;
		$this->data["development_flag"] = $development_flag;

		$this->model = $this->model->select(["*"
				, \DB::raw("
						CASE development_flag WHEN 0 THEN '本番'
							WHEN 1 THEN 'ステージング'
							WHEN 2 THEN '開発'
							ELSE '不定義'
						END AS 'development_flag_label'
					")
		]);

		// $this->model = $this->model->leftJoin("users", "domain.user_id", "=", "users.id");
		// $this->model = $this->model->leftJoin("organization", "organization.user_id", "=", "users.id");

		if($keyword){
			$this->model = $this->model->where(function($query) use ($keyword) {
						$query->orWhere("name"					, "LIKE", "%" . $keyword . "%")
							  ->orWhere("url"					, "LIKE", "%" . $keyword . "%")
							  ->orWhere("admin_url"				, "LIKE", "%" . $keyword . "%")
							  ->orWhere("admin_username"		, "LIKE", "%" . $keyword . "%")
							  ->orWhere("repository_url"		, "LIKE", "%" . $keyword . "%")
							  ->orWhere("description"			, "LIKE", "%" . $keyword . "%")
							  ->orWhere("ssh_access_command"	, "LIKE", "%" . $keyword . "%")
							  ->orWhere("ssh_description"		, "LIKE", "%" . $keyword . "%")
							  ->orWhere("db_access_command"		, "LIKE", "%" . $keyword . "%")
							  ->orWhere("db_description"		, "LIKE", "%" . $keyword . "%")
							  ->orWhere(function($query) use ($keyword)
							  {
									switch ($keyword) {
										case '本番':
											$development_flag = 0;
											break;

										case 'ステージング':
											$development_flag = 1;
											break;

										case '開発':
											$development_flag = 2;
											break;

										default: // 不定義
											$development_flag = 3;
											break;
									}

									$query->orWhere("development_flag", $development_flag);
							  })
							;
					}
				);
		}

		if($development_flag){
			$this->model = $this->model->where("development_flag", $development_flag);
		}

		$this->model = $this->model->where("organization_id", $this->logged_in_user->organization_id);

		$arrModel = $this->model->paginate(env('NUMBER_OF_RECORD_PER_PAGE'));

		return view($this->blade_url, ['data'=>$this->data, "logged_in_user"=>$this->logged_in_user, "arrModel"=>$arrModel]);
	}

}
