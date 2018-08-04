<?php namespace App\Http\Controllers\Manage;

// use Illuminate\Http\Request;
use App\Model\Project;
use App\Model\ProjectTask;
use App\Model\UserTask;

class ProjectTaskController extends Controller {

	protected function init()
	{
		parent::init();

		$this->model = new ProjectTask();

		// 新規追加画面、デフォルトの価値を定義
		$this->model->organization_id 		= $this->organization_id;
		$this->url_pattern = "manage.project_task";
		$this->data["url_pattern"] = "/manage/project_task";
		$this->logical_delete = true;
	}

	public function list()
	{
		$this->blade_url = $this->url_pattern . '.index';

		$keyword = null;
		if(isset($this->form_input["keyword"])){
			$keyword = $this->form_input["keyword"];
		}
		$this->data["keyword"] = $keyword;

		return view($this->blade_url, ['data'=>$this->data, "logged_in_user"=>$this->logged_in_user]);
	}

	public function edit($task_id, $message = NULL)
	{
		$this->blade_url = $this->url_pattern . '.edit';

		$this->model = $this->model->where("id", $task_id);
		$data_record = $this->model->first();

		$project = new Project();
		$projectList = $project->getList();

		$message = NULL;
		$alert_type = NULL;

		if(!$data_record){
			return redirect("/" . str_replace(".", "/", $this->url_pattern) . '/add')->with(["message"=>"タスクが存在していませんから、タスク追加画面に遷移しました。", "alert_type" => $alert_type]);
		}

		if($this->form_input){ // Submit

			$form_input = $this->form_input;

			// update "task" table
			$task = new ProjectTask();
			$task = $task->find($form_input["id"]);
			$task->fill($form_input);
			$task->update();

			$alert_type = "success";
			$message = "修正完了。";
		}

		$subQuery = "( SELECT * FROM user_project WHERE user_id = '" . $this->logged_in_user->id . "') AS user_project ";
		$this->model = $this->model->leftJoin(\DB::raw($subQuery), "project_task.project_id", "=", "user_project.project_id");
		$this->model = $this->model->first();

		$this->data["projectList"] = $projectList;

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

		$is_manager = in_array($this->logged_in_user->role, array("Manager"));

		// insert tasks
		foreach ($arrList as $task_id => $task) {
			if(isset($task["user_id"]) && ($task["user_id"] == "on")){
				$table = new UserTask();
				$table->user_id = $user_id;
				$table->task_id = $task_id;
				$table->save();
				unset($table);
			}

		}

		$alert_type = "success";
		$message = "登録完了。";

		$this->blade_url = $this->url_pattern;
		return redirect("/" . str_replace(".", "/", $this->blade_url))->with(['message'=>$message, "alert_type" => $alert_type]);
	}


}
