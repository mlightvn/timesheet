<?php

namespace App\Http\Controllers\Api\Master;

class Controller extends \App\Http\Controllers\Api\Controller
{

	public function getLoggedInUser(){
		$this->logged_in_user = parent::getLoggedInUser();

		if(!isset($this->logged_in_user)){
			abort(404);
			exit;
		}else{
			$role = $this->logged_in_user->role;
			if($role != "Master"){
				abort(404);
				exit;
			}
		}

		return $this->logged_in_user;
	}

	// protected function querySetup()
	// {
	// 	$table_name = $this->model->getTable();

	// 	parent::querySetup();

	// 	$role = "";
	// 	if(isset($this->form_input["permission"])){
	// 		// DBの価値に変換
	// 		$role = $this->form_input["permission"];
	// 		if(in_array($role, array("Master", "Owner"))){
	// 			$this->model = $this->model->where($table_name . ".role", "=", $role);
	// 		}else{
	// 			$this->model = $this->model->where($table_name . ".role", "<>", "Master");
	// 		}


	// 	}
	// }

}
