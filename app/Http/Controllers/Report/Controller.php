<?php namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;

class Controller extends \App\Http\Controllers\Admin\Controller {

	protected $requestYear, $requestMonth, $requestDay;
	protected $rowHeight = 25;
	protected $reportUser;

	protected function init()
	{
		parent::init();

		$user_id = NULL;
		if(isset($this->form_input["user_id"])){
			$user_id = $this->form_input["user_id"];
		}
		$this->setReportUser($user_id);
		$this->url_pattern = "report";

		$date = date("Y/m/d");
		$arrDate = explode("/", $date);
		$this->requestYear 			= $arrDate[0];
		$this->requestMonth 		= $arrDate[1];
		$this->requestDay 			= $arrDate[2];
	}

	protected function setReportUser($user_id = NULL){
		if($user_id){
			$this->user_id = $user_id;

			$user = new \App\Model\User();
			$user = $user->find($user_id);

			if(empty($user)){
				$this->reportUser = $this->logged_in_user;
				$message = "このユーザー(ID:" . $user_id . ")が存在していませんから、ログインユーザーのデータをセットしました。";
				return redirect($this->request->fullUrl())->with(['message'=>$message]);
			}else{
				$this->reportUser = $user;
			}
		}else{
			if(isset($this->logged_in_user)){
				$this->user_id = $this->logged_in_user->id;
				$this->reportUser = $this->logged_in_user;
			}
		}

	}

	// http://www.maatwebsite.nl/laravel-excel/docs/export#sheets
	public function download($year, $month = NULL, $day = NULL)
	{
		$day = ($day) ? $day : "";
		if(is_null($month) || empty($month)){
			$month = NULL;
		}else{
			$month = (strlen($month) < 2) ? ("0" . $month) : $month;
		}

		$data = $this->data;

		$user_name = $this->reportUser->name;
		$user_name = str_replace("　", "-", $user_name);
		$user_name = str_replace("　", "-", $user_name);
		$user_name = str_replace("\\", "-", $user_name);
		$user_name = str_replace("/", "-", $user_name);
		$user_name = str_replace("\.", "_", $user_name);

		$filename = "タスク別工数集計表_" . $year . $month . $day . "_" . $user_name;

		$data["year"] 				= $year;
		$data["month"] 				= $month;
		$data["day"] 				= $day;
		$data["user_name"] 			= $user_name;
		$data["filename"] 			= $filename;

		// $arrOffTaskList = $this->getProjectSheet($this->reportUser->id, $year, $month, NULL, 1);
		$arrOnTaskList = $this->getProjectSheet($this->reportUser->id, $year, $month, NULL, 0);

		$taskSheet 						= array();
		// $arrOffTasks 					= array();
		$arrOnTasks 					= array();

		// $arrOffTasks["task"] 							= $arrOffTaskList;
		// $arrOffTasks["task_label"] 						= "休憩時間";
		// $arrOffTasks["total_minutes"] 					= 0;
		// $arrOffTasks["total_working_hours_label"] 		= "";

		$arrOnTasks["task"] 							= $arrOnTaskList;
		$arrOnTasks["task_label"] 						= "稼働プロジェクト";
		$arrOnTasks["total_minutes"] 					= 0;
		$arrOnTasks["total_working_hours_label"] 		= "";

		// $taskSheet["off_task"] 			= $arrOffTasks;
		$taskSheet["on_task"] 			= $arrOnTasks;

		$data["taskSheet"] 	= $taskSheet;

		\Excel::create($filename, function($excel) use($data) {
			$excel->sheet('Sheetname', function($sheet) use($data) {
				$taskSheet 			= $data["taskSheet"];

				// $arrOffTasks 		= $taskSheet["off_task"];
				$arrOnTasks 		= $taskSheet["on_task"];

				$arrTotalData		= array(
						"label"				=> "合計",
						"minutes"			=> 0,
					);

				// タイトル
				$sheet->setTitle($data["filename"]);
				$sheet->setFontFamily('ＭＳ Ｐゴシック');

				$sheet->mergeCells("D3:E3");
				$sheet->mergeCells("D4:E4");

				$sheet->cell('D3:E3', function($cell) {
						$cell->setAlignment('right');
					});
				$sheet->cell('D4:E4', function($cell) {
						$cell->setAlignment('right');
					});

				$sheet->cell('B2', function($cell) {
						$cell->setFontSize(18);
						$cell->setFontWeight('bold');
					});

				$sheet->row(2, array(NULL, 'タスク別工数集計表'));
				$sheet->row(3, array(NULL, NULL, NULL, $data["year"] . '/' . $data["month"] . '/01　～　' . date("Y/m/t", strtotime($data["year"] . '/' . $data["month"] . '/01'))));
				$sheet->row(4, array(NULL, NULL, NULL, $this->reportUser->name));

				$start_row = 6;
				$minutes = 0;
				$this->writeSheetTable($sheet, $arrOnTasks, 6, $minutes);
				$arrTotalData["minutes"] = $minutes;

				$start_row += count($arrOnTasks["task"]) + 4;
				// $this->writeSheetTable($sheet, $arrOffTasks, $start_row, $minutes);
				// $arrTotalData["minutes"] += $minutes;

				// $start_row += count($arrOffTasks["task"]) + 4;
				// $this->writeSheetTotalTable($sheet, $arrTotalData, $start_row);

				$sheet->setWidth('A', 3);
				$sheet->setWidth('B', 20);
				$sheet->setWidth('C', 20);
				$sheet->setWidth('D', 20);
				$sheet->setWidth('E', 20);

				// $start_row += 2;
				$sheet->cell('D' . $start_row, function($cell) {
						$cell->setBorder('thick', 'thick', 'thick', 'thick');
					});
				$sheet->cell('E' . $start_row, function($cell) {
						$cell->setBorder('thick', 'thick', 'thick', 'thick');
					});
				$sheet->setSize('D' . $start_row, 20, 110);
			});

			// Chain the setters
			$excel->setCreator('Nguyen Nam')->setCompany(env("APP_COMP_NAME"));

			$excel->setDescription($data["filename"]);

		})->export('xlsx');
	}

	public function writeSheetTable($sheet, $data, $start_row, &$minutes)
	{
		$sheet->row($start_row, array(NULL, $data["task_label"], NULL, NULL, "合計作業時間"));

		$taskSheet = $data["task"];

		$total_working_minutes = 0;
		$lastRow = $start_row + 1;
		$iRow = $start_row + 1;
		foreach ($taskSheet as $key => $task) {
			$sheet->setHeight($iRow, $this->rowHeight);
			$cells = $sheet->mergeCells("B" . $iRow . ":D" . $iRow);

			$sheet->setBorder("B" . $iRow . ":E" . $iRow, 'thin');

			$total_working_minutes += $task->total_working_minutes;
			$sheet->row($iRow, array(NULL, $task->project_name, NULL, NULL, $task->total_working_hours_label));
			$iRow++;
		}
		$minutes = $total_working_minutes;

		$sheet->setHeight($iRow, $this->rowHeight);
		$sheet->mergeCells("B" . $iRow . ":D" . $iRow);
		$sheet->row($iRow, array(NULL, "合計", NULL, NULL, $this->minutes2HourLabel($total_working_minutes)));
		$lastRow = $iRow;
		$iRow++;

		// フォーマット
		$sheet->setHeight($start_row, $this->rowHeight);

		$sheet->cell("B" . $start_row . ":E" . $lastRow, function($cell) {
				$cell->setValignment('center');
			});

		$sheet->mergeCells("B" . $start_row . ":D" . $start_row);

		$sheet->cell('B' . $start_row . ':D' . $start_row, function($cell) {
				$cell->setFontWeight('bold');
				$cell->setBorder('thick', 'thick', 'thick', 'thick');
			});
		$sheet->cell('E' . $start_row, function($cell) {
				$cell->setFontWeight('bold');
				$cell->setBorder('thick', 'thick', 'thick', 'thick');
			});
		$sheet->cell('B' . ($start_row + 1) . ':D' . ($lastRow - 1), function($cell) {
				$cell->setBorder('thick', 'thick', 'thick', 'thick');
			});
		$sheet->cell('E' . ($start_row + 1) . ':E' . ($lastRow - 1), function($cell) {
				$cell->setBorder('thick', 'thick', 'thick', 'thick');
				$cell->setAlignment('right');
			});
		$sheet->cell('B' . $lastRow . ':E' . $lastRow, function($cell) {
				$cell->setAlignment('right');
			});
		$sheet->cell('B' . $lastRow, function($cell) {
				$cell->setFontWeight('bold');
				$cell->setBorder('solid', 'thick', 'thick', 'thick');
			});
		$sheet->cell('E' . $lastRow, function($cell) {
				$cell->setFontWeight('bold');
				$cell->setBorder('solid', 'thick', 'thick', 'thick');
			});
	}

	public function writeSheetTotalTable($sheet, $data, $start_row)
	{
		$sheet->setHeight($start_row, $this->rowHeight + 10);
		$sheet->mergeCells("B" . $start_row . ":D" . $start_row);
		$sheet->row($start_row, array(NULL, "合計", NULL, NULL, $this->minutes2HourLabel($data["minutes"])));

		$sheet->cell('B' . $start_row . ':E' . $start_row, function($cell) {
				$cell->setFontSize(24);
				$cell->setValignment('center');
				$cell->setFontWeight('bold');
				$cell->setAlignment('right');
				$cell->setBorder('thick', 'thick', 'thick', 'thick');
			});
		$sheet->cell('E' . $start_row, function($cell) {
				$cell->setBorder('thick', 'thick', 'thick', 'thick');
			});
	}

	public function getProjectSheet($user_id, $year, $month = NULL, $day = NULL, $is_off = NULL)
	{
		$data = array();
		$data["year"] 				= $year;
		$data["month"] 				= $month;
		$data["day"] 				= $day;
		$data["date"] 				= $year . "-" . $month . "-" . $day;
		$data["year_month"] 		= $year . "-" . $month;

		$workingDate = new \App\Model\WorkingDate();

		$workingDate = $workingDate->select(\DB::raw("
				  project.id
				, project.is_off
				, working_date.user_id, SUM(working_date.working_minutes) AS 'total_working_minutes'
				, CONCAT(LPAD(FLOOR(SUM(working_date.working_minutes) / 60), 2, '0'), ':', LPAD(MOD(SUM(working_date.working_minutes), 60), 2, '0')) AS 'total_working_hours_label'
				, project.name AS 'project_name'
				"
			));

		$workingDate = $workingDate->join("project", "working_date.project_id", "=", "project.id");
		$workingDate = $workingDate->where("working_date.user_id", "=", $user_id);
		if(!is_null($is_off) && in_array($is_off, array(0, 1))){
			$workingDate = $workingDate->where("project.is_off", "=", $is_off);
		}
// dd($month);
		$workingDate = $workingDate->where("working_date.date", "LIKE", $year . "-" . $month . "-" . $day . "%");
		$workingDate = $workingDate->where("working_date.working_minutes", ">", "0");

		$workingDate = $workingDate->groupBy(["project.id", "project.is_off", "working_date.user_id", "project.name"]);
		$workingDate = $workingDate->orderBy("project.is_off");
// dd($workingDate->get());
// dd($workingDate->toSql());
		return $workingDate->get();
	}
}
