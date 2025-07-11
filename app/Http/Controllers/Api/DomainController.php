<?php namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Model\Domain;

class DomainController extends Controller {


	protected function init()
	{
		parent::init();

		$this->model = new Domain();
	}

	public function list()
	{
		$this->model = $this->model->orderBy("is_deleted");
		$this->model = $this->model->orderBy("development_flag");

		$keyword = null;
		$development_flag = null;

		// if(isset($this->form_input["keyword"])){
		if(isset($_GET["keyword"])){
			// $keyword = $this->form_input["keyword"];
			$keyword = $_GET["keyword"];
		}
		if(isset($this->form_input["development_flag"])){
			$development_flag = $this->form_input["development_flag"];
		}

		$this->data["keyword"] = $keyword;
		$this->data["development_flag"] = $development_flag;

		$this->model = $this->model->select(["*"
				, \DB::raw("
						CASE development_flag WHEN 1 THEN '本番'
							WHEN 2 THEN 'ステージング'
							WHEN 3 THEN '開発'
							ELSE '不定義'
						END AS 'development_flag_label'
					"),
				\DB::raw("CASE domain.is_deleted WHEN 1 THEN 'w3-gray' ELSE '' END AS DELETED_CSS_CLASS"),
				\DB::raw("CASE domain.is_deleted WHEN 0 THEN 1 ELSE 0 END AS DELETE_FLAG_ACTION"),
				\DB::raw("CASE domain.is_deleted WHEN 1 THEN 'fa fa-recycle' ELSE 'fa fa-trash' END AS DELETED_RECOVER_ICON"),
				\DB::raw("CASE domain.is_deleted WHEN 1 THEN 'w3-green' ELSE 'w3-red' END AS DELETED_RECOVER_COLOR"),
				// \DB::raw("CASE domain.is_deleted WHEN 1 THEN CONCAT('/api/domain/', domain.id, '/recover') ELSE CONCAT('/api/domain/', domain.id, '/delete') END AS DELETED_RECOVER_URL"),
				// \DB::raw("CASE domain.is_deleted WHEN 1 THEN CONCAT('recover(', domain.id, ')') ELSE CONCAT('delete(', domain.id, ')') END AS DELETED_RECOVER_FUNCTION"),
				// \DB::raw("CASE domain.is_deleted WHEN 1 THEN 'recover' ELSE 'delete' END AS ACTION"),
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
											$development_flag = 1;
											break;

										case 'ステージング':
											$development_flag = 2;
											break;

										case '開発':
											$development_flag = 3;
											break;

										default: // 不定義
											$development_flag = 4;
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

		return $this->toJson($arrModel);
	}

	public function listing(Request $request)
	{
		$this->model = $this->model->orderBy("is_deleted");
		$this->model = $this->model->orderBy("development_flag");

		$keyword = null;
		$development_flag = null;

		if($request->keyword){
			$keyword = $request->keyword;
		}
		if($request->development_flag){
			$development_flag = $request->development_flag;
		}

		$this->data["keyword"] = $keyword;
		$this->data["development_flag"] = $development_flag;

		$this->model = $this->model->select(["*"
				, \DB::raw("
						CASE development_flag WHEN 1 THEN '" . __("screen.domain.environment.production") . "'
							WHEN 2 THEN '" . __("screen.domain.environment.staging") . "'
							WHEN 3 THEN '" . __("screen.domain.environment.development") . "'
							ELSE '" . __("screen.domain.environment.others") . "'
						END AS 'development_flag_label'
					"),
				\DB::raw("CASE domain.is_deleted WHEN 1 THEN 'w3-gray' ELSE '' END AS DELETED_CSS_CLASS"),
				\DB::raw("CASE domain.is_deleted WHEN 0 THEN 1 ELSE 0 END AS DELETE_FLAG_ACTION"),
				\DB::raw("CASE domain.is_deleted WHEN 1 THEN 'fa fa-recycle' ELSE 'fa fa-trash' END AS DELETED_RECOVER_ICON"),
				\DB::raw("CASE domain.is_deleted WHEN 1 THEN 'w3-green' ELSE 'w3-red' END AS DELETED_RECOVER_COLOR"),
		]);

		if($request->id){
			$this->model = $this->model->where("id", $request->id);
		}

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
											$development_flag = 1;
											break;

										case 'ステージング':
											$development_flag = 2;
											break;

										case '開発':
											$development_flag = 3;
											break;

										default: // 不定義
											$development_flag = 4;
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
		if($request->name){
			$name = $request->name;
			$this->model = $this->model->where(function($where) use ($name)
			{
				$where->where("domain.name", "LIKE", "%" . $name . "%")
					  ->orWhere("domain.url", "LIKE", "%" . $name . "%")
					  ->orWhere("domain.admin_url", "LIKE", "%" . $name . "%")
				;
			});
		}

		if($request->detail){
			$detail = $request->detail;
			$this->model = $this->model->where(function($where) use ($detail)
			{
				$where->where("domain.ssh_access_command", "LIKE", "%" . $detail . "%")
					  ->orWhere("domain.db_access_command", "LIKE", "%" . $detail . "%")
					  ->orWhere("domain.repository_url", "LIKE", "%" . $detail . "%")
				;
			});
		}

		$this->model = $this->model->where("organization_id", $this->logged_in_user->organization_id);

		$arrModel = $this->model->paginate(env('NUMBER_OF_RECORD_PER_PAGE'));

		return $this->toJson($arrModel);
	}

}
