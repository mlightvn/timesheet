<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BinController extends Controller {

	public function __construct(Request $request)
	{
		parent::__construct($request);
	}

	protected function init()
	{
		parent::init();

		$this->url_pattern = '/bin';
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

		return;
	}

	public function pullSourceCode(){
		$this->blade_url = $this->url_pattern . '/pullSourceCode';
		$this->data["url_pattern"] = $this->blade_url;

		$username = \Request::input('username');
		$password = \Request::input('password');

		if($username && $password){
			$git_url = "https://{USERNAME}:{PASSWORD}@bitbucket.org/mincorp/timesheet.git";
			// $git_url = "origin";
			$cmd = "git pull {URL} master";

			$git_url = str_replace("{USERNAME}", $username, $git_url);
			$git_url = str_replace("{PASSWORD}", $password, $git_url);
			$cmd = str_replace("{URL}", $git_url, $cmd);

			chdir(base_path());
			$result_s = exec($cmd);
			echo $result_s;
		}else{
			return view($this->blade_url, ['data'=>$this->data]);
		}
	}

}
