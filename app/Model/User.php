<?php

namespace App\Model;

// use Illuminate\Auth\Authenticatable;
// use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;

class User extends Authenticatable
{

	// use Authenticatable, CanResetPassword;
	use Notifiable;

	protected $guard = 'admin';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'id',
		'organization_id',
		'email',
		'sub_email',
		'password',
		'name',
		'role', // Master: admin of website, Owner: representative/owner of organization, Manager: Manager, "member" : workers, staff at organization
		'department_id',

		'dayoff',
		'gender',
		'birthday',
		'tel',
		'phone',
		'internal_number',
		'description',

		'remember_token',

	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];


	public function setPasswordAttribute($password)
	{
		$this->attributes['password'] = \Hash::make($password);
	}


	public function getList($request = NULL) // ($isPagination, $id = NULL, $email = NULL, $name = NULL, $keyword = NULL)
	{
		$table = \DB::table('users');
		$table = $table->select([
			  "users.*"

			, \DB::raw("
					CASE users.gender
						WHEN 0 THEN 'fas fa-male fa-lg'
						ELSE 'fas fa-female fa-lg'
					END				AS GENDER_ICON
				")
			, \DB::raw("
					CASE users.gender
						WHEN 0 THEN 'Male'
						ELSE 'FEMALE'
					END				AS GENDER_LABEL
				")

			, \DB::raw("organization.name 				AS organization_name")
			, \DB::raw("department.name 					AS department_name")

			, \DB::raw("CASE users.is_deleted WHEN 1 THEN 'w3-gray' ELSE '' END AS DELETED_CSS_CLASS")
			, \DB::raw("CASE users.is_deleted WHEN 0 THEN 1 ELSE 0 END AS DELETE_FLAG_ACTION")
			, \DB::raw("CASE users.is_deleted WHEN 1 THEN 'fa fa-recycle' ELSE 'fa fa-trash' END AS DELETED_RECOVER_ICON")
			, \DB::raw("CASE users.is_deleted WHEN 1 THEN 'w3-green' ELSE 'w3-red' END AS DELETED_RECOVER_COLOR")

			, \DB::raw("users.id 		AS user_id")
			, \DB::raw("
				CASE users.role
					WHEN 'Master' THEN 'fab fa-empire fa-lg w3-text-red'
					WHEN 'Owner' THEN 'fas fa-chess-king fa-lg'
					WHEN 'Manager' THEN 'fas fa-user-secret fa-lg'
					ELSE 'fas fa-user-tie fa-lg'
				END AS ROLE_ICON
				")
		]);

		$table = $table->leftJoin("department", function($join)
		{
			$join->on("users.department_id", "=", "department.id")
				 ->on("users.organization_id", "=", "department.organization_id")
			;
		});
		$table = $table->leftJoin("organization", "users.organization_id", "=", "organization.id");

		if(isset($request["id"]) && !empty($request["id"])){
			$table = $table->where("users.id", "=", $request["id"]);
		}
		if(isset($request["department_id"]) && (!empty($request["department_id"]))){
			$table = $table->where("users.department_id", "=", $request["department_id"]);
		}
		if(isset($request["email"]) && (!empty($request["email"]))){
			$table = $table->where("users.email", "=", $request["email"]);
		}
		if(isset($request["name"]) && (!empty($request["name"]))){
			$table = $table->where("users.name", "LIKE", "%" . $request["name"] . "%");
		}
		if(isset($request["is_deleted"]) && ($request["is_deleted"] !== "")){
			$table = $table->where("users.is_deleted", $request["is_deleted"]);
		}

		if(isset($request["keyword"]) && (!empty($request["keyword"]))){
			$where = " (
							   (users.id 			= 		'{KEYWORD}')
							OR (users.email 		LIKE 	'%{KEYWORD}%')
							OR (users.name 			LIKE 	'%{KEYWORD}%')
							OR (department.name 	LIKE 	'%{KEYWORD}%')
						)";
			$where = str_replace("{KEYWORD}", $request["keyword"], $where);

			$table = $table->whereRaw($where);
		}

		if(\Auth::user()->role != "Master"){
			$table = $table->where("organization.id", "=", \Auth::user()->organization_id);
		}

		$table = $table->orderBy("users.is_deleted", "ASC");
		$table = $table->orderBy("department.is_deleted", "ASC");
		$table = $table->orderBy("department.id", "ASC");
		$table = $table->orderBy("users.id", "ASC");

		if(isset($request["isPagination"]) && (!empty($request["isPagination"]))){
			$arrResult = $table->paginate(env('NUMBER_OF_RECORD_PER_PAGE'));
		}else{
			$arrResult = $table->get();
		}

		return $arrResult;
	}

	public function getListing(Request $request)
	{
		$table = \DB::table('users');
		$table = $table->select([
			  "users.*"

			, \DB::raw("
					CASE users.gender
						WHEN 0 THEN 'fas fa-male fa-lg'
						ELSE 'fas fa-female fa-lg'
					END				AS GENDER_ICON
				")
			, \DB::raw("
					CASE users.gender
						WHEN 0 THEN 'Male'
						ELSE 'FEMALE'
					END				AS GENDER_LABEL
				")

			, \DB::raw("organization.name 				AS organization_name")
			, \DB::raw("department.name 					AS department_name")

			, \DB::raw("CASE users.is_deleted WHEN 1 THEN 'w3-gray' ELSE '' END AS DELETED_CSS_CLASS")
			, \DB::raw("CASE users.is_deleted WHEN 0 THEN 1 ELSE 0 END AS DELETE_FLAG_ACTION")
			, \DB::raw("CASE users.is_deleted WHEN 1 THEN 'fa fa-recycle' ELSE 'fa fa-trash' END AS DELETED_RECOVER_ICON")
			, \DB::raw("CASE users.is_deleted WHEN 1 THEN 'w3-green' ELSE 'w3-red' END AS DELETED_RECOVER_COLOR")

			, \DB::raw("users.id 		AS user_id")
			, \DB::raw("
				CASE users.role
					WHEN 'Master' THEN 'fab fa-empire fa-lg w3-text-red'
					WHEN 'Owner' THEN 'fas fa-chess-king fa-lg'
					WHEN 'Manager' THEN 'fas fa-user-secret fa-lg'
					ELSE 'fas fa-user-tie fa-lg'
				END AS ROLE_ICON
				")
		]);

		$table = $table->leftJoin("department", function($join)
		{
			$join->on("users.department_id", "=", "department.id")
				 ->on("users.organization_id", "=", "department.organization_id")
			;
		});
		$table = $table->leftJoin("organization", "users.organization_id", "=", "organization.id");

		if(isset($request->id) && !empty($request->id)){
			$table = $table->where("users.id", "=", $request->id);
		}
		if(isset($request->department_id) && (!empty($request->department_id))){
			$table = $table->where("users.department_id", "=", $request->department_id);
		}
		if(isset($request->email) && (!empty($request->email))){
			$table = $table->where("users.email", "LIKE", "%" . $request->email . "%");
		}
		if(isset($request->name) && (!empty($request->name))){
			$table = $table->where("users.name", "LIKE", "%" . $request->name . "%");
		}
		if(isset($request->is_deleted) && ($request->is_deleted !== "")){
			$table = $table->where("users.is_deleted", $request->is_deleted);
		}
		if(isset($request->gender) && ($request->gender !== "")){
			$table = $table->where("users.gender", $request->gender);
		}

		if(isset($request->keyword) && (!empty($request->keyword))){
			$where = " (
							   (users.id 			= 		'{KEYWORD}')
							OR (users.email 		LIKE 	'%{KEYWORD}%')
							OR (users.name 			LIKE 	'%{KEYWORD}%')
							OR (department.name 	LIKE 	'%{KEYWORD}%')
						)";
			$where = str_replace("{KEYWORD}", $request->keyword, $where);

			$table = $table->whereRaw($where);
		}

		if(\Auth::user()->role != "Master"){
			$table = $table->where("organization.id", "=", \Auth::user()->organization_id);
		}

		$table = $table->orderBy("users.is_deleted", "ASC");
		$table = $table->orderBy("department.is_deleted", "ASC");
		$table = $table->orderBy("department.id", "ASC");
		$table = $table->orderBy("users.id", "ASC");

		$arrResult = $table->paginate(20);

		return $arrResult;
	}

}
