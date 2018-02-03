<?php namespace App\Http\Controllers\Api;

use App\Model\ApplicationTemplate;

class ApplicationTemplateController extends \App\Http\Controllers\Api\Controller {

	protected function init()
	{
		parent::init();

		$this->model = new ApplicationTemplate();

		$column_list = array();
		$column_list["organization_id"] = $this->organization_id;
		$this->data["request_data"]["where"]["column_list"] = $column_list;
	}

	protected function getModelList()
	{
		$model = parent::getModelList();

		$model = $model->select([
					"application_template.*",
					\DB::raw("CASE application_template.is_deleted WHEN 1 THEN 'w3-gray' ELSE '' END AS DELETED_CSS_CLASS"),
		]);

		return $model;
	}

	public function getList()
	{
		$model = $this->model;
		$model = $model->where("organization_id", "=", $this->organization_id);
		$model = $model->where("is_deleted", "=", 0);
		$model = $model->select([
					"application_template.*",
					\DB::raw("CASE application_template.is_deleted WHEN 1 THEN 'w3-gray' ELSE '' END AS DELETED_CSS_CLASS"),
		]);

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
