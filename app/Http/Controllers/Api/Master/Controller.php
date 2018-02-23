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
			$permission_flag = $this->logged_in_user->permission_flag;
			if($permission_flag != "Master"){
				abort(404);
				exit;
			}
		}

		return $this->logged_in_user;
	}

	protected function querySetup()
	{
		parent::querySetup();

		$table_name = $this->model->getTable();

		$permission_flag = "";
		if(isset($this->form_input["permission"])){
			// DBの価値に変換
			$permission_flag = $this->form_input["permission"];
			if($permission_flag == "master"){
				$this->model = $this->model->where($table_name . ".permission_flag", "=", "Master");
			}else{
				$this->model = $this->model->where($table_name . ".permission_flag", "<>", "Master");
			}


		}
	}

}
