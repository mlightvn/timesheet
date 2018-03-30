<?php namespace App\Http\Controllers;

use App\Model\Bookmark;

class BookmarkController extends Controller {

	protected function init()
	{
		parent::init();

		$this->model = new Bookmark();

		// 新規追加画面、デフォルトの価値を定義
		$this->model->organization_id 		= $this->organization_id;

		$this->url_pattern 					= "bookmark";
		$this->data["url_pattern"] 			= "/bookmark";
	}

}
