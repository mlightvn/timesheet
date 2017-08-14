<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Task;
use App\Model\UserTask;

class AdminTaskController extends AdminController {

	protected function init()
	{
		parent::init();

		$this->model = new Task();
		$this->url_pattern = "admin.task";
		$this->logical_delete = true;
	}

	public function index()
	{
		$this->blade_url = $this->url_pattern . '.index';

		$keyword = null;
		if(isset($this->form_input["keyword"])){
			$keyword = $this->form_input["keyword"];
		}
		$this->data["keyword"] = $keyword;

		$arrTasks = $this->getTaskListWithUser(true, $this->user_id, $keyword);

		return view($this->blade_url, ['data'=>$this->data, "logged_in_user"=>$this->logged_in_user, "arrTasks"=>$arrTasks]);
	}

	public function edit($task_id, $message = NULL)
	{
		$this->blade_url = $this->url_pattern . '.edit';

		$this->model = $this->model->where("id", $task_id);
		$data_record = $this->model->first();

		$message = NULL;
		$alert_type = NULL;

		if(!$data_record){
			return redirect("/" . str_replace(".", "/", $this->url_pattern) . '/add')->with(["message"=>"タスクが存在していませんから、タスク追加画面に遷移しました。", "alert_type" => $alert_type]);
		}

		if($this->form_input){ // Submit
			if(isset($this->form_input["is_off_task"])){
				$this->form_input["is_off_task"] = "1";
			}else{
				$this->form_input["is_off_task"] = "0";
			}

			$form_input = $this->form_input;

			// update "task" table
			$task = new Task();
			$task = $task->find($form_input["id"]);
			$task->fill($form_input);
			$task->update();

			// update "user_task" table
			$user_id = $this->logged_in_user->id;

			$user_task = new \App\Model\UserTask();
			$user_task = $user_task->where("user_id", $user_id);
			$user_task = $user_task->where("task_id", $task_id);
			$user_task->delete();

			if(isset($form_input["user_id"])){ // "on"
				$user_task = new \App\Model\UserTask();
				$user_task->user_id = $user_id;
				$user_task->task_id = $task_id;
				$user_task->save();

				$alert_type = "success";
				$message = "修正完了。";
			}
		}

		$subQuery = "( SELECT * FROM user_task WHERE user_id = '" . $this->logged_in_user->id . "') AS user_task ";
		$this->model = $this->model->leftJoin(\DB::raw($subQuery), "task.id", "=", "user_task.task_id");
		$this->model = $this->model->first();

		return view("/". str_replace(".", "/", $this->blade_url), ['data'=>$this->data, "logged_in_user"=>$this->logged_in_user, "model"=>$this->model])->with(["message"=>$message, "alert_type" => $alert_type]);
	}

	public function update()
	{
		$arrList = $this->form_input["task"];
		$user_id = $this->logged_in_user->id;

		$table = new UserTask();
		$table = $table->where("user_id", "=", $user_id);
		$table = $table->delete(); // delete all tasks of current user
		unset($table);

		if($this->logged_in_user->session_is_manager == "Manager"){
			// Remove all off_task flag
			$table = new Task();
			$table = $table->where("is_off_task", "=", "1");
			$table->update(["is_off_task" => 0]);
			unset($table);
		}

		// insert tasks
		foreach ($arrList as $task_id => $task) {
			if(isset($task["user_id"]) && ($task["user_id"] == "on")){
				$table = new UserTask();
				$table->user_id = $user_id;
				$table->task_id = $task_id;
				$table->save();
				unset($table);
			}

			if($this->logged_in_user->session_is_manager == "Manager"){
				if(isset($task["is_off_task"]) && ($task["is_off_task"] == "1")){
					$table = new Task();
					$table = $table->find($task_id);
					if(isset($table)){
						$table->is_off_task = 1;
						$table->update();
					}
					unset($table);
				}
			}
		}

		$alert_type = "success";
		$message = "登録完了。";

		$this->blade_url = $this->url_pattern;
		return redirect("/" . str_replace(".", "/", $this->blade_url))->with(['message'=>$message, "alert_type" => $alert_type]);
	}
}
