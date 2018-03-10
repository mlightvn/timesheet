<?php namespace App\Http\Controllers\WorkTime;

use Illuminate\Http\Request;

class Controller extends \App\Http\Controllers\Admin\Controller {

	protected $requestYear, $requestMonth, $requestDay;
	protected $rowHeight = 25;
	protected $reportUser;

	protected function init()
	{
		parent::init();

		$user_id = NULL;
		if(isset($this->form_input["user_id"])){
			$user_id = $this->form_input["user_id"];
		}
		$this->setReportUser($user_id);
		$this->url_pattern = "work-time";

		$date = date("Y/m/d");
		$arrDate = explode("/", $date);
		$this->requestYear 			= $arrDate[0];
		$this->requestMonth 		= $arrDate[1];
		$this->requestDay 			= $arrDate[2];
	}

	protected function setReportUser($user_id = NULL){
		if($user_id){
			$this->user_id = $user_id;

			$user = new \App\Model\User();
			$user = $user->find($user_id);

			if(empty($user)){
				$this->reportUser = $this->logged_in_user;
				$message = "このユーザー(ID:" . $user_id . ")が存在していませんから、ログインユーザーのデータをセットしました。";
				return redirect($this->request->fullUrl())->with(['message'=>$message]);
			}else{
				$this->reportUser = $user;
			}
		}else{
			if(isset($this->logged_in_user)){
				$this->user_id = $this->logged_in_user->id;
				$this->reportUser = $this->logged_in_user;
			}
		}

	}

}
