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
			if(isset($this->form_input["is_off"])){
				$this->form_input["is_off"] = "1";
			}else{
				$this->form_input["is_off"] = "0";
			}

			$form_input = $this->form_input;

			// update "project" table
			$project = new Project();
			$project = $project->find($form_input["id"]);
			$project->fill($form_input);
			$project->update();

			$alert_type = "success";
			$message = __("message.status.done.edit");

		}

		$this->model = $this->model->first();

		return view("/". str_replace(".", "/", $this->blade_url), ['data'=>$this->data, "logged_in_user"=>$this->logged_in_user, "model"=>$this->model])->with(["message"=>$message, "alert_type" => $alert_type]);
	}

	public function update()
	{
		$arrList = $this->form_input["project"];
		$user_id = $this->logged_in_user->id;

		$table = new UserProject();
		$table = $table->where("user_id", "=", $user_id);
		$table = $table->delete(); // delete all projects of current user
		unset($table);

		$is_manager = in_array($this->logged_in_user->role, array("Manager"));
		if($is_manager){
			// Reset all is_off flag
			$table = new Project();
			$table = $table->where("is_off", "=", "1");
			$table->update(["is_off" => 0]);
			unset($table);
		}

		// insert projects
		foreach ($arrList as $project_id => $project) {
			if(isset($project["user_id"]) && ($project["user_id"] == "on")){
				$table = new UserProject();
				$table->user_id = $user_id;
				$table->project_id = $project_id;
				$table->save();
				unset($table);
			}

			if($is_manager){
				if(isset($project["is_off"]) && ($project["is_off"] == "1")){
					$table = new Project();
					$table = $table->find($project_id);
					if(isset($table)){
						$table->is_off = 1;
						$table->update();
					}
					unset($table);
				}
			}
		}

		$alert_type = "success";
		$message = __("message.status.done.add");

		$this->blade_url = $this->url_pattern;
		return redirect("/" . str_replace(".", "/", $this->blade_url))->with(['message'=>$message, "alert_type" => $alert_type]);
	}
}
