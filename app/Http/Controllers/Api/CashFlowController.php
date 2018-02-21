<?php namespace App\Http\Controllers\Api;

use App\Model\CashFlow;

class CashFlowController extends Controller {


	protected function init()
	{
		parent::init();

		$this->model = new CashFlow();
	}

	protected function getModelList()
	{
		$model = parent::getModelList();

		$this->model = $this->model->select([
					"cashflow.*",
					\DB::raw("
							CASE WHEN (cashflow.in_out_flag = 0) THEN FORMAT(cashflow.amount, 2)
							ELSE ''
							END AS AMOUNT_IN
						"),
					\DB::raw("
							CASE WHEN (cashflow.in_out_flag = 1) THEN FORMAT(cashflow.amount, 2)
							ELSE ''
							END AS AMOUNT_OUT
						"),
		]);

		return $model;
	}

}
