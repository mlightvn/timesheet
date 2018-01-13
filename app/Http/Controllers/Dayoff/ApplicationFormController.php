<?php namespace App\Http\Controllers\Dayoff;

use Illuminate\Http\Request;
use App\Model\ApplicationForm;

class ApplicationFormController extends \App\Http\Controllers\Controller {

	protected function init()
	{
		parent::init();

		$this->model = new ApplicationForm();

		$this->url_pattern = "dayoff.application-form";
		$this->data["url_pattern"] = "/dayoff/application-form";
		$this->logical_delete = true;
	}

}
