<?php namespace App\Http\Controllers\Dayoff;

use Illuminate\Http\Request;
use App\Model\ApplicationForm;

use App\Http\Controllers\Api\ApplicationTemplateController;

class ApplicationFormController extends Controller {

	protected function init()
	{
		parent::init();

		$this->model = new ApplicationForm();
		$this->model->status = 0; //Applied
		$this->model->applied_user_id = \Auth::id();
		$this->model->applied_user_name = \Auth::user()->name;
		$this->model->datetime_from = date("Y-m-d 00:00");
		$this->model->datetime_to = date("Y-m-d 23:00");

		$this->url_pattern = "dayoff.application-form";
		$this->data["url_pattern"] = "/dayoff/application-form";
	}

	public function add()
	{
		$controller = new ApplicationTemplateController($this->request);
		$template_list = $controller->getList();

		$this->data["template_list"] = $template_list;

		return parent::add();
	}

}
