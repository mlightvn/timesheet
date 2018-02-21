<?php namespace App\Http\Controllers;

use App\Model\CashFlow;

class CashFlowController extends Controller {

	protected function init()
	{
		parent::init();

		$this->model = new CashFlow();

		// 新規追加画面、デフォルトの価値を定義
		$this->model->organization_id 		= $this->organization_id;

		$this->url_pattern 					= "cashflow";
		$this->data["url_pattern"] 			= "/cashflow";
	}

	public function add()
	{
		if(isset($this->form_input) && (count($this->form_input) > 0)){
			$in_out_flag = isset($this->form_input["in_out_flag"]) ? $this->form_input["in_out_flag"] : 0;

			if($in_out_flag === "on"){
				$in_out_flag = 1;
			}else{
				$in_out_flag = 0;
			}
			$this->model->in_out_flag = $in_out_flag;
		}else{
			$this->model->in_out_flag = 1; // default: cash out
		}

		return parent::add();
	}

	public function edit($id)
	{
		if(isset($this->form_input) && (count($this->form_input) > 0)){
			$in_out_flag = isset($this->form_input["in_out_flag"]) ? $this->form_input["in_out_flag"] : 0;

			if($in_out_flag === "on"){
				$in_out_flag = 1;
			}else{
				$in_out_flag = 0;
			}
			$this->form_input["in_out_flag"] = $in_out_flag;
		}

		return parent::edit($id);
	}

}
