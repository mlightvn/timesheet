<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BinController extends Controller {

	public function __construct(Request $request)
	{
		parent::__construct($request);
	}

	public function sendMessageToChatwork(){
		$message = \Request::input('message');
		$debug_mode = \Request::input('debug');

		if(in_array($debug_mode, array("On", "1", true, "debug", 1))){
			//テスト送信の場合は米本に送信
			$room_id = "81792222";
		}else{
			//IT事業部に送信
			$room_id = "27722580";
		}

		$api_token = "faf3300478f0fbb8c1bddb99e3f79a66";

		$message = urlencode($message);

		$cmd = 'curl -X POST -H "X-ChatWorkToken: {API_TOKEN}" -d "body={BODY}" "https://api.chatwork.com/v2/rooms/{ROOM_ID}/messages"';

		$cmd = str_replace("{API_TOKEN}", $api_token, $cmd);
		$cmd = str_replace("{BODY}", $message, $cmd);
		$cmd = str_replace("{ROOM_ID}", $room_id, $cmd);

		$response = exec($cmd);

		echo ($response);
		// 結果のJSON文字列をデコード
		// $result = json_decode($response);

		return;
	}

	public function pullSourceCode(){
		$username = \Request::input('username');
		$password = \Request::input('password');

		if($username && $password){
			$git_url = "https://{USERNAME}:{PASSWORD}@urbanfunes.backlog.jp/git/RESERVED/COST.git";
			$cmd = base_path() . "git pull {URL}";

			$git_url = str_replace("{USERNAME}", $username, $git_url);
			$git_url = str_replace("{PASSWORD}", $password, $git_url);
			$cmd = str_replace("{URL}", $git_url, $cmd);
// echo $cmd;
// echo getcwd();
			// chdir(base_path());
			$result_s = exec($cmd);
			echo $result_s;
		}else{
			echo "ユーザ名とパスワードを入力してください。";
		}
	}

}
