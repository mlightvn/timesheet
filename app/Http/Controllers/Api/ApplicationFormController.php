<?php namespace App\Http\Controllers\Api;

use App\Model\ApplicationForm;

class ApplicationFormController extends \App\Http\Controllers\Api\Controller {

	protected function init()
	{
		parent::init();

		$this->model = new ApplicationForm();

		$column_list = array();
		$column_list["application_form.organization_id"] = $this->organization_id;
		if(isset($this->logged_in_user->permission_flag) && ($this->logged_in_user->permission_flag != "Manager")){
			$column_list["application_form.applied_user_id"] = \Auth::id();
		}

		$orderBy = array();
		// $orderBy["application_form.status"] 			= "ASC";
		// $orderBy["application_form.datetime_from"] 		= "DESC";
		$orderBy["application_form.updated_at"] 		= "DESC";

		$this->data["request_data"]["where"]["column_list"] = $column_list;
		$this->data["request_data"]["orderBy"] = $orderBy;
	}

	protected function getModelList()
	{
		$model = parent::getModelList();
		$model = $model->leftJoin(\DB::raw("users AS APPLIED_USER"), "application_form.applied_user_id", "=", "APPLIED_USER.id");
		// $model = $model->leftJoin(\DB::raw("users AS APPROVED_USER"), "application_form.approved_user_id", "=", "APPROVED_USER.id");

		$model = $model->select([
					"application_form.*",
					\DB::raw("APPLIED_USER.name AS 'APPLIED_USER_NAME'"),
					// \DB::raw("APPROVED_USER.name AS 'APPROVED_USER_NAME'"),
					// \DB::raw("CASE status 
					// 			WHEN 0 THEN 'Applied' 
					// 			WHEN 1 THEN 'Approved'
					// 			WHEN 2 THEN 'Rejected'
					// 			END AS 'STATUS_LABEL'
					// 	"),
					// \DB::raw("CASE status 
					// 			WHEN 0 THEN '' 
					// 			WHEN 1 THEN 'w3-green'
					// 			WHEN 2 THEN 'w3-gray'
					// 			END AS 'STATUS_COLOR'
					// 	"),
		]);

		return $model;
	}

}
