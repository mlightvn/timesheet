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
}
