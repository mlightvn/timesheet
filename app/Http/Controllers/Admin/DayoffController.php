<?php namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Model\Dayoff;

class DayoffController extends Controller {

	protected function init()
	{
		parent::init();

		$this->model = new Dayoff();
		$this->model = $this->model->orderBy("is_deleted");
		$this->model = $this->model->orderBy("development_flag");

		$this->url_pattern = "admin.dayoff";
		$this->data["url_pattern"] = "/admin/dayoff";
		$this->logical_delete = true;
	}

	public function index()
	{
		$this->blade_url = $this->url_pattern . '.index';

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

		$arrModel = $this->model->paginate(env('NUMBER_OF_RECORD_PER_PAGE'));

		return view($this->blade_url, ['data'=>$this->data, "logged_in_user"=>$this->logged_in_user, "arrModel"=>$arrModel]);
	}

}
