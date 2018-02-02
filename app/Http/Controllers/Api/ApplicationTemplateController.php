<?php namespace App\Http\Controllers\Api;

use App\Model\ApplicationTemplate;

class ApplicationTemplateController extends \App\Http\Controllers\Api\Controller {

	protected function init()
	{
		parent::init();

		$this->model = new ApplicationTemplate();
	}

	public function getList()
	{
		// $model = $this->getModelList();
		$model = $this->model;
		$model = $model->where("organization_id", "=", $this->organization_id);
		$model_list = $model->get();

		$return_arr = array();
		$return_arr[""] = "Please choose value below";
		foreach ($model_list as $row_index => $record) {
			$return_arr[$record["id"]] = $record["name"];
		}

		return $return_arr;
	}

	public function get($id)
	{
		$model = $this->model;
		$model = $model->where("organization_id", "=", $this->organization_id);
		$model = $model->where("id", "=", $id);
		$model = $model->first();

		return $model;
	}

}
