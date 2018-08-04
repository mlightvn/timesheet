<?php namespace App\Http\Controllers\Api\Master;

use App\Model\User;

class UserController extends Controller {

	protected function init()
	{
		parent::init();

		$this->model = new User();

	}

	protected function querySetup()
	{

		$table_name = $this->model->getTable();

		parent::querySetup();

		$role = "";
		if(isset($this->form_input["permission"])){
			// DBの価値に変換
			$role = $this->form_input["permission"];
			if(in_array($role, array("Master", "Owner"))){
				$this->model = $this->model->where($table_name . ".role", "=", $role);
			}else{
				$this->model = $this->model->whereRaw(\DB::raw($table_name . ".role NOT IN ('Master', 'Owner')"));
			}

		}

		// keyword
		$keyword = null;
		if(isset($this->form_input["keyword"])){
			$keyword = $this->form_input["keyword"];
		}
		$this->data["keyword"] = $keyword;

		// Order By
		$orderBy = array();
		$orderBy["users.is_deleted"] 				= "ASC";
		$orderBy["organization.name"] 				= "ASC";
		$orderBy["users.name"] 						= "ASC";
		$orderBy["users.email"] 					= "ASC";
		$this->data["request_data"]["orderBy"] 		= $orderBy;

// dd($this->model->toSql());
	}

	public function getModelList()
	{
		parent::getModelList();
		$table = &$this->model;

		$table = $table->select([
			  "users.*"
			, \DB::raw("organization.name AS organization_name")

			, \DB::raw("CASE users.is_deleted WHEN 1 THEN 'w3-gray' ELSE '' END AS DELETED_CSS_CLASS")
			, \DB::raw("CASE users.is_deleted WHEN 0 THEN 1 ELSE 0 END AS DELETE_FLAG_ACTION")
			, \DB::raw("
					CASE WHEN (users.id = 1) THEN ''
						ELSE
							CASE WHEN (users.is_deleted = 1)
								THEN 'fa fa-recycle'
								ELSE 'fa fa-trash'
							END
						END AS DELETED_RECOVER_ICON
					")
			, \DB::raw("CASE users.is_deleted WHEN 1 THEN 'w3-green' ELSE 'w3-red' END AS DELETED_RECOVER_COLOR")

			, \DB::raw("users.id 		AS user_id")
			, \DB::raw("
				CASE users.role
					WHEN 'Master' THEN 'fab fa-empire w3-text-red'
					WHEN 'Owner' THEN 'glyphicon glyphicon-king'
					WHEN 'Administrator' THEN 'glyphicon glyphicon-knight'
					WHEN 'Manager' THEN 'glyphicon glyphicon-queen'
					ELSE 'glyphicon glyphicon-pawn'
				END AS ICON_CLASS
				")

		]);

		$table = $table->leftJoin("organization", "users.organization_id", "=", "organization.id");

		// $table = $table->orderBy("users.is_deleted");
		// $table = $table->orderBy("organization.name");
		// $table = $table->orderBy("users.name");
		// $table = $table->orderBy("users.email");

		return $table;
	}

}
