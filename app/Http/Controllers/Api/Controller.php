<?php

namespace App\Http\Controllers\Api;

class Controller extends \App\Http\Controllers\Controller
{

	public function list()
	{
		$this->model = $this->getModelList();
		$model_list = $this->model->paginate(env('NUMBER_OF_RECORD_PER_PAGE'));

		return $this->toJson($model_list);
	}

	protected function querySetup()
	{
		$orderBy_a = array();
		$orderBy_a["id"] 							= "DESC";
		$this->data["request_data"]["orderBy"] 		= $orderBy_a;
	}

	public function delete($id)
	{
		$data = array("alert_type"=>"success", "message"=>"Deleted");
		$model = $this->model;
		$model = $model->find($id);
		if($model){
			$model->is_deleted = 1;
			$model->update();
		}else{
			$data = array("alert_type"=>"alert", "message"=>"Data does not exist.");
		}
		$model->update();
		return $this->toJson($data);
	}

	public function recover($id)
	{
		$data = array("alert_type"=>"success", "message"=>"Recovered");
		$model = $this->model;
		$model = $model->find($id);
		if($model){
			$model->is_deleted = 0;
			$model->update();
		}else{
			$data = array("alert_type"=>"alert", "message"=>"Data does not exist.");
		}
		$model->update();
		return $this->toJson($data);
	}

}
