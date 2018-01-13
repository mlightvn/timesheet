<?php namespace App\Http\Controllers\Manage;

use Illuminate\Http\Request;
use App\Model\Project;
use App\Model\UserProject;

class ProjectController extends Controller {

	protected function init()
	{
		parent::init();

		$this->model = new Project();

		// 新規追加画面、デフォルトの価値を定義
		$this->model->organization_id 		= $this->organization_id;
		$this->url_pattern = "manage.project";
		$this->data["url_pattern"] = "/manage/project";
		$this->logical_delete = true;
	}

	public function edit($project_id, $message = NULL)
	{
		$this->blade_url = $this->url_pattern . '.edit';

		$this->model = $this->model->where("id", $project_id);
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
			$task = neProject;
			$task = $task->find($form_input["id"]);
			$task->fill($form_input);
			$task->update();

			// update "user_task" table
			$user_id = $this->logged_in_user->id;

			$user_task = new \App\Model\UserProject();
			$user_task = $user_task->where("user_id", $user_id);
			$user_task = $user_task->where("project_id", $project_id);
			$user_task->delete();

			if(isset($form_input["user_id"])){ // "on"
				$user_task = new \App\Model\UserProject();
				$user_task->user_id = $user_id;
				$user_task->project_id = $project_id;
				$user_task->save();

				$alert_type = "success";
				$message = "修正完了。";
			}
		}

		$subQuery = "( SELECT * FROM user_task WHERE user_id = '" . $this->logged_in_user->id . "') AS user_task ";
		$this->model = $this->model->leftJoin(\DB::raw($subQuery), "task.id", "=", "user_task.project_id");
		$this->model = $this->model->first();

		return view("/". str_replace(".", "/", $this->blade_url), ['data'=>$this->data, "logged_in_user"=>$this->logged_in_user, "model"=>$this->model])->with(["message"=>$message, "alert_type" => $alert_type]);
	}

	public function update()
	{
		$arrList = $this->form_input["task"];
		$user_id = $this->logged_in_user->id;

		$table = new UserProject();
		$table = $table->where("user_id", "=", $user_id);
		$table = $table->delete(); // delete all tasks of current user
		unset($table);

		$is_manager = in_array($this->logged_in_user->permission_flag, array("Administrator", "Manager"));
		if($is_manager){
			// Remove all off_task flag
			$table = new Project();
			$table = $table->where("is_off_task", "=", "1");
			$table->update(["is_off_task" => 0]);
			unset($table);
		}

		// insert tasks
		foreach ($arrList as $project_id => $task) {
			if(isset($task["user_id"]) && ($task["user_id"] == "on")){
				$table = new UserProject();
				$table->user_id = $user_id;
				$table->project_id = $project_id;
				$table->save();
				unset($table);
			}

			if($this->logged_in_user->permission_flag == "Manager"){
				if(isset($task["is_off_task"]) && ($task["is_off_task"] == "1")){
					$table = new Project();
					$table = $table->find($project_id);
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
