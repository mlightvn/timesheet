<?php namespace App\Http\Controllers\Api\Dayoff;

use App\Model\ApplicationForm;

class ApplicationFormController extends \App\Http\Controllers\Api\Controller {

	protected function init()
	{
		parent::init();

		$this->model = new ApplicationForm();
	}

	protected function getModelList()
	{
		$model = parent::getModelList();
		$model = $model->leftJoin(\DB::raw("users AS APPLIED_USER"), "application_form.applied_user_id", "=", \DB::raw("APPLIED_USER.id"));
		$model = $model->leftJoin(\DB::raw("users AS APPROVED_USER"), "application_form.approved_user_id", "=", \DB::raw("APPROVED_USER.id"));

		$model = $model->select([
					"application_form.*",
					\DB::raw("APPLIED_USER.name AS 'APPLIED_USER_NAME'"),
					\DB::raw("APPROVED_USER.name AS 'APPROVED_USER_NAME'"),
					\DB::raw("CASE status 
								WHEN 0 THEN 'Applied' 
								WHEN 1 THEN 'Approved'
								WHEN 2 THEN 'Dismissed'
								END AS 'STATUS_LABEL'
						"),
		]);

		return $model;
	}

}
