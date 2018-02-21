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
return $this->toJson($this->form_input);

// 		if(isset($this->form_input["domain_id"])){
// 			$domain_id = $this->form_input["domain_id"];
// 			$this->model->domain_id = $domain_id;
// 		}
// $response = array("status"=>99, "message"=>"domain_id: " . $this->model->domain_id);
// return $this->toJson($response);
	}

// 	public function upload()
// 	{
// // $response = array("status"=>99, "message"=>"domain_id: " . $model->domain_id);
// // return $this->toJson($response);
// 		$response = array("status"=>0, "message"=>"Success");

// 		if (isset($_FILES['file']['error']) && is_int($_FILES['file']['error'])) {
// // $response = array("status"=>99, "message"=>"99. Unknown");
// // return $this->toJson($response);

// 			// $files = $_FILES['file'];
// 			$length = count($_FILES['file']["name"]);
// 			for ($i=0; $i < $length; $i++)
// 			{
// 				$file = $_FILES['file'];
// 				if($file["size"][$i] < 100000){ // 100KB files can be uploaded.
// 					$response = array("status"=>2, "message"=>"File size is too big.");

// 					return $this->toJson($response);
// 				}

// 				switch ($file['error'][$i]) {
// 					case UPLOAD_ERR_OK:
// 						break;
// 					case UPLOAD_ERR_NO_FILE:
// 						$response = array("status"=>1, "message"=>"No file to upload.");
// 						// throw new RuntimeException('ファイルが選択されていません。');
// 					case UPLOAD_ERR_INI_SIZE:
// 					case UPLOAD_ERR_FORM_SIZE:
// 						$response = array("status"=>2, "message"=>"File size is too big.");
// 						// throw new RuntimeException('ファイルサイズが大きすぎます。');
// 					default:
// 						$response = array("status"=>99, "message"=>"Unknown");
// 						// throw new RuntimeException('その他のエラーが発生しました。');
// 				}

// 				if($response["status"] != 0){
// 					return $this->toJson($response);
// 				}

// 				// //アップロードされたファイルの種類をチェックする
// 				// $finfo = finfo_open(FILEINFO_MIME_TYPE);
// 				// $file_type = $file["type"];
// 				// $upload_mime_type = finfo_file($finfo, $_FILES["file"]["tmp_name"]);
// 				// finfo_close($finfo);
// 				// if (
// 				// 	!in_array($file_type, ["application/vnd.ms-excel", "application/vnd.msexcel", "text/plain", "text/csv", "text/tsv", "text/comma-separated-values", "application/csv"]) //csv
// 				// ){
// 				// 	throw new RuntimeException('アップロードできないファイルの種類です。');
// 				// }

// 				//ファイルをアップロードディレクトリに格納
// 				if (is_uploaded_file($file["tmp_name"][$i])) {
// 					$directory_path = storage_path() . env("UPLOAD_FOLDER_DOMAIN");
// 					$directory_path = $directory_path . $this->model->domain_id;
// 					if(!file_exists($directory_path)){
// 						mkdir($directory_path, 0775, TRUE);
// 					}
// 					//アップロードファイル名
// 					$file_name = $file["name"][$i];
// 					$file_path = $directory_path . "/" . $file_name;
// 					// $file_fullpath = $file_path;

// 					if (move_uploaded_file($file["tmp_name"], $file_path)) {
// 						chmod($file_path, 0666);
// 					} else {
// 						throw new RuntimeException('ファイルをアップロードできません。');
// 					}
// 				} else {
// 					throw new RuntimeException('ファイルが選択されていません。');
// 				}
// 				//保存されたか確認
// 				if(!file_exists($file_path)){
// 					throw new RuntimeException('ファイルの保存に失敗しました。');
// 				}
// 			}
// 		}else{
// 			$response = array("status"=>1, "message"=>"No file to upload.");
// 		}

// 		return $this->toJson($response);
// 	}

}
