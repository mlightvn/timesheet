<?php namespace App\Http\Controllers\Dayoff;

use Illuminate\Http\Request;
use App\Model\Dayoff;

class ApplicationController extends \App\Http\Controllers\Controller {

	protected function init()
	{
		parent::init();

		$this->model = new Dayoff();
		$this->model = $this->model->orderBy("is_deleted");
		$this->model = $this->model->orderBy("development_flag");

		$this->url_pattern = "dayoff.application";
		$this->data["url_pattern"] = "/dayoff/application";
		$this->logical_delete = true;
	}

}
