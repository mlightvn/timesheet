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

}
