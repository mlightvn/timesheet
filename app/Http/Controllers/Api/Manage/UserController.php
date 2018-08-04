<?php namespace App\Http\Controllers\Api\Manage;

use Illuminate\Http\Request;
use App\Model\User;

class UserController extends \App\Http\Controllers\Api\Controller {

	protected function init()
	{
		parent::init();

		$this->model = new User();

		// 新規追加画面、デフォルトの価値を定義
		$this->model->organization_id 		= $this->organization_id;
	}

	public function list()
	{

		$keyword = null;
		if(isset($this->form_input["keyword"])){
			$keyword = $this->form_input["keyword"];
		}
		$this->data["keyword"] = $keyword;

		$arrUsers = $this->getUsers(true, NULL, NULL, NULL, $keyword);

		return $this->toJson($arrUsers);
	}

	public function uploadPicture($id = NULL)
	{
		$result = ["status"=>99, "message"=>"Unknow error."];

		if(isset($_FILES['picture'])){
			$picture_file = $_FILES['picture'];
			if($picture_file['size'] <= 5000000){ // 5MB以下

				$sourcePath = $picture_file['tmp_name'];
				$file_old_name = $picture_file["name"];

				$arr = explode(".", $file_old_name);
				if(count($arr) > 0){
					$file_ext = end($arr);
				}else{
					$file_ext = "";
				}

				$public_path = "/upload/user/";
				$uploadFolder = public_path($public_path);
				$file_new_name = $id . "." . $file_ext;
				$new_file_full_path = $uploadFolder . $file_new_name;

				if(file_exists($new_file_full_path)){
					unlink($new_file_full_path);
				}

				move_uploaded_file($sourcePath, $new_file_full_path);

				$user = User::find($id);
				if($user){
					$user->profile_picture = $file_new_name;
					$user->update();
				}
				$result = ["status"=>0, "message"=>"成功", 'profile_picture'=>($public_path . $file_new_name)];

			}else{
				$result = ["status"=>1, "message"=>"File size must be less than 5MB."];

			}
		}
		return response()->json($result);
	}

}
