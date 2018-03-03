<?php namespace App\Http\Controllers\Api;

// use Illuminate\Http\Request;
use App\Model\DomainKeyFile;

class DomainKeyFileController extends Controller {

	protected function init()
	{
		parent::init();

		$this->model = new DomainKeyFile();

		if(isset($this->form_input["domain_id"])){
			$domain_id = $this->form_input["domain_id"];
			$this->model->domain_id = $domain_id;
		}
	}

	protected function getModelList()
	{
		$model = parent::getModelList();

		if(isset($this->form_input["domain_id"])){
			$domain_id = $this->form_input["domain_id"];
			$this->model = $this->model->where("domain_id", "=", $domain_id);
		}
		$this->model = $this->model->where("organization_id", "=", $this->organization_id);

		return $model;
	}

	public function upload()
	{
		$response = array("status"=>0, "message"=>"Success", "color_class"=>"w3-green");

		if(isset($this->form_input["domain_id"])){
			$domain_id 							= $this->form_input["domain_id"];
			$this->model->domain_id 			= $domain_id;
		}

		if(isset($this->form_input["organization_id"])){
			$organization_id 					= $this->form_input["organization_id"];
			$this->model->organization_id 		= $organization_id;
		}

		if (isset($_FILES['file'])) {

			$length = count($_FILES['file']["name"]);
			for ($i=0; $i < $length; $i++)
			{
				$file = $_FILES['file'];
				$max_file_size = 100000;
				if($file["size"][$i] > $max_file_size){ // 100KB files can be uploaded.
					$response["status"] 				= 2;
					$response["message"] 				= "File size is too big (larger than " . $max_file_size . ").";

					return $this->toJson($response);
				}

				switch ($file['error'][$i]) {
					case UPLOAD_ERR_OK:
						break;
					case UPLOAD_ERR_NO_FILE:
						$response["status"] 			= 1;
						$response["message"] 			= "No file to upload.";
					case UPLOAD_ERR_INI_SIZE:
					case UPLOAD_ERR_FORM_SIZE:
						$response["status"] 			= 2;
						$response["message"] 			= "File size is too big.";
					default:
						$response["status"] 			= 99;
						$response["message"] 			= "Unknown.";
				}

				if($response["status"] != 0){
					return $this->toJson($response);
				}

				//ファイルをアップロードディレクトリに格納
				if (is_uploaded_file($file["tmp_name"][$i])) {
					$directory_path = public_path() . env("UPLOAD_FOLDER_DOMAIN");
					$directory_path = $directory_path . $this->model->organization_id;
					if(!file_exists($directory_path)){
						mkdir($directory_path, 0775, TRUE);
					}

					$directory_path = public_path() . env("UPLOAD_FOLDER_DOMAIN");
					$directory_path = $directory_path . $this->model->organization_id . "/" . $this->model->domain_id;
					if(!file_exists($directory_path)){
						mkdir($directory_path, 0775, TRUE);
					}

					//アップロードファイル名
					$file_name = $file["name"][$i];
					$file_path = $directory_path . "/" . $file_name;

					if(file_exists($file_path)){
						$response["status"] 			= 3;
						$response["message"] 			= "File is existing. Delete remote file before re-upload.";
					}else{
						if (move_uploaded_file($file["tmp_name"][$i], $file_path)) {
							// chmod($file_path, 0666);

							$model = new DomainKeyFile();
							$model->organization_id 			= $this->organization_id;
							$model->domain_id 					= $this->model->domain_id;
							$model->name 						= $file_name;
							$model->save();
						} else {
							$response["status"] 			= 99;
							$response["message"] 			= "Unknown. Check your server.";
							// throw new RuntimeException('ファイルをアップロードできません。');
						}
					}

				} else {
					$response["status"] 			= 1;
					$response["message"] 			= "No file to upload.";
					// throw new RuntimeException('ファイルが選択されていません。');
				}
				// //保存されたか確認
				// if(!file_exists($file_path)){
				// 	$response["status"] 			= 3;
				// 	$response["message"] 			= "File is existing. Delete remote file before re-upload.";
				// 	// throw new RuntimeException('ファイルの保存に失敗しました。');
				// }
			}
		}else{
			$response["status"] 			= 1;
			$response["message"] 			= "No file to upload.";
		}

		if($response["status"] != 0){
			$response["color_class"] = "";
		}

		return $this->toJson($response);
	}

	public function delete($id)
	{

		$model = new DomainKeyFile();
		$model = $model->find($id);
		$file_name = $model->name;
		$model->delete();

		$directory_path = public_path() . env("UPLOAD_FOLDER_DOMAIN");
		$directory_path = $directory_path . $model->organization_id . "/" . $model->domain_id;
		$file_path = $directory_path . "/" . $file_name;
		unlink($file_path);
	}

}
