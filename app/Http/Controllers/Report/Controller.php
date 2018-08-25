<?php namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Model\ProjectTask;

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
		$this->data["user_id"] = $user_id;
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

	public function downloadProject()
	{
		$this->data["user_list"] = array();
		$this->data["user_list"][$this->reportUser->id] = $this->reportUser;

		return $this->download();
	}

	public function downloadByDepartment()
	{
		if(!isset(request()->department_id)){
			return __("message.data_does_not_exist");
		}

		$this->data["user_list"] = array();

		$department_id = request()->department_id;
		$model = new \App\Model\Department();
		$model = $model->join("users", function($join)
		{
			$join->on("users.department_id", "=", "department.id")
				 ->on("users.organization_id", "=", "department.organization_id")
			;
		});

		$model = $model->where("department.id", $department_id);

		$model = $model->where("department.organization_id", $this->organization_id);

		$model = $model->where("users.is_deleted", \App\Model\BaseModel::IS_NOT_DELETED);
		$model = $model->where("department.is_deleted", \App\Model\BaseModel::IS_NOT_DELETED);

		$model = $model->select([
			\DB::raw("users.id 					AS 'user_id'"),
			"users.*",
		]);

		$user_list = $model->get();

		$this->data["user_list"] = $user_list;

		return $this->download();
	}

	// http://www.maatwebsite.nl/laravel-excel/docs/export#sheets
	public function download()
	{
		if(isset($this->data["user_list"]) && (count($this->data["user_list"]) > 0)){
			$year 		= request()->year;
			$month 		= request()->month;
			$day 		= request()->day;

			$day 		= ($day ?? "");
			$month 		= ($month ?? str_pad($month, 2, 0 , STR_PAD_LEFT));

			$this->data["year"] 				= $year;
			$this->data["month"] 				= $month;
			$this->data["day"] 					= $day;

			$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
			$this->data["spreadsheet"] = &$spreadsheet;

			$data 		= $this->data;

			$i = 0;
			$data["sheet_exist"] = &$i;
			foreach ($data["user_list"] as $key => $user) {
				$i++;

				$user_name = $user->name;
				$user_name = str_replace("　", "-", $user_name);
				$user_name = str_replace("　", "-", $user_name);
				$user_name = str_replace("\\", "-", $user_name);
				$user_name = str_replace("/", "-", $user_name);
				$user_name = str_replace("\.", "_", $user_name);

				$filename = "タスク別工数集計表_" . $year . $month . $day . "_" . $user_name;

				$data["user_id"] 			= $user->id;
				$data["user_name"] 			= $user_name;
				$data["filename"] 			= $filename;

				$timeSheet = new ProjectTask();
				$timeSheetList = $timeSheet->getTimeSheetList($user, $year, $month);

				$taskSheet 					= array();

				$data["models"] 								= $timeSheetList;
				$arrTasks["task_label"] 						= __("message.project.project");
				$arrTasks["total_minutes"] 						= 0;
				$arrTasks["total_working_hours_label"] 			= "00:00";

				$taskSheet["on_task"] 							= $arrTasks;

				$data["taskSheet"] 	= $taskSheet;

				$this->excelSheetCreate($data);
			}

			$file_path = $this->excelCreate($data);

			$headers = array(
				  // 'Content-Type: ' . mime_content_type( $file_path ),
				  'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
				);

			return \Response::download($file_path, $filename . '.xlsx', $headers)->deleteFileAfterSend(true);

		}

		return __("message.data_does_not_exist");

	}

	// https://phpspreadsheet.readthedocs.io/en/develop/topics/recipes/#setting-a-columns-width
	private function excelCreate($data)
	{
		if(!isset($data["spreadsheet"])){
			return NULL;
		}

		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($data["spreadsheet"]);

		// // Chain the setters
		// $writer->setCreator('Nguyen Nam')->setCompany(env("APP_COMP_NAME"));
		// $writer->setDescription($data["filename"]);

		$file_path = storage_path('tmp/' . $data["filename"] . '.xlsx');
		if(file_exists($file_path)){
			unlink($file_path);
		}
		$writer->save($file_path);

		return $file_path;

	}

	// https://phpspreadsheet.readthedocs.io/en/develop/topics/recipes/#setting-a-columns-width
	private function excelSheetCreate(&$data)
	{
		$spreadsheet = $data["spreadsheet"];
		if($data["sheet_exist"] === 1){
			$sheet = $spreadsheet->getActiveSheet();
		}else{
			$sheet = $spreadsheet->createSheet();
		}

		{
			// SpreadSheet
			{
				$taskSheet 			= $data["taskSheet"];

				$arrTotalData		= array(
						"label"				=> __("message.total"),
						"minutes"			=> 0,
					);

				// タイトル
				$sheet->setTitle($data["user_id"] . "_" . $data["user_name"]);
				// $sheet->setFontFamily('ＭＳ Ｐゴシック');

				$sheet->mergeCells("C3:D3");
				$sheet->mergeCells("C4:D4");

				$sheet->getStyle('I3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
				$sheet->getStyle('I4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

				$sheet->getStyle('B2')->getFont()->setSize(18)->setBold(true);

				$sheet->setCellValue("B2", __('message.excel.table_of_working_hours_by_task'));

				$sheet->setCellValue("C3", $data["year"] . '/' . $data["month"] . '/01　～　' . date("Y/m/t", strtotime($data["year"] . '/' . $data["month"] . '/01')));
				$sheet->setCellValue("C4", $this->reportUser->name);

				$iRow = 6;
				$row = [
					__('screen.project.project'),
					__('screen.task.task'),
					__('message.total_working_hours'),
				];

				$sheet->fromArray([$row], NULL, 'B' . $iRow);
				$sheet->getStyle('B6:D6')->getFont()->setBold(true);

				$iRow = 7;
				$minutes = 0;
				$table = [];

				$total_working_minutes = 0;
				$total_working_hours_display = "00:00";
				$time_line_previous = null;

				$project_summary = array();
				$project_summary["minutes"] = 0;
				$project_summary["hours_display"] = "00:00";

				$styleArraySubTotal = [
					'font' => [
						'bold' => true,
					],
					'fill' => [
						'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
						'color' => [
							'argb' => 'FFEEEEEE',
						],
					],
				];

				$timeSheetList = $data["models"];
				if(count($timeSheetList) > 0){
					foreach ($timeSheetList as $key => $time_line) {
						$total_working_minutes += $time_line->TOTAL_MINUTES;

						if(($time_line_previous !== null) && ($time_line_previous->project_id !== $time_line->project_id)){
								$minutes = $project_summary["minutes"];
								$hours = floor($minutes / 60);
								$remained_minutes = ($minutes % 60);

								$project_summary["hours_display"] = str_pad($hours, 2, 0, STR_PAD_LEFT) . ":" . str_pad($remained_minutes, 2, 0, STR_PAD_LEFT);

								$table[] = [
									NULL,
									__('message.total'),
									$project_summary["hours_display"],
								];

								$sheet->getStyle('B' . $iRow . ':D' . $iRow)->applyFromArray($styleArraySubTotal);
								$iRow++;

								$project_summary["minutes"] = 0;

						}

						if($time_line_previous == null || ($time_line_previous->project_id !== $time_line->project_id)){
							$project_name = $time_line->project_name;
						}else{
							$project_name = NULL;
						}
						$table[] = [
							$project_name,
							$time_line->project_task_name,
							$time_line->HOURS_DISPLAY,
						];
						$iRow++;

						$time_line_previous = $time_line;

						$project_summary["minutes"] += $time_line->TOTAL_MINUTES;
					}

					// total row of last project
					$minutes = $project_summary["minutes"];
					$hours = floor($minutes / 60);
					$remained_minutes = ($minutes % 60);

					$project_summary["hours_display"] = str_pad($hours, 2, 0, STR_PAD_LEFT) . ":" . str_pad($remained_minutes, 2, 0, STR_PAD_LEFT);

					$table[] = [
						NULL,
						__('message.total'),
						$project_summary["hours_display"],
					];
					$sheet->getStyle('B' . $iRow . ':D' . $iRow)->applyFromArray($styleArraySubTotal);
					$iRow++;

				}

				// Total row (ALL)
				$total_working_hours = floor($total_working_minutes / 60);
				$total_working_hours_minutes = $total_working_minutes % 60;
				$total_working_hours_display = str_pad($total_working_hours, 2, 0, STR_PAD_LEFT) . ":" . str_pad($total_working_hours_minutes, 2, 0, STR_PAD_LEFT);

				$table[] = [
					NULL,
					__('message.total'),
					$total_working_hours_display,
				];
				$sheet->getStyle('B' . $iRow . ':D' . $iRow)->getFont()->setBold(true)->setSize(18);
				$iRow++;

				$sheet->fromArray($table, NULL, 'B7');

				$sheet->getColumnDimension('A')->setWidth(3);
				$sheet->getColumnDimension('B')->setWidth(30);
				$sheet->getColumnDimension('C')->setWidth(30);
				$sheet->getColumnDimension('D')->setWidth(30);

				$data["last_row_index"] = ($iRow - 1);
				$this->excelSheetFormat($sheet, $data);

			}

		}

		return $sheet;

	}

	// https://phpspreadsheet.readthedocs.io/en/develop/topics/recipes/#setting-a-columns-width
	private function excelSheetFormat($sheet, $data)
	{

		$models = $data["models"];
		$iLastRow = $data["last_row_index"];

		$sheet->getStyle('C3:D4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

		$sheet->getStyle('B6:D6')->getFont()->setBold(true)->setSize(15);

		$styleArray = [
			'borders' => [
				'inside' => [
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
				],
			],
		];
		$sheet->getStyle('B6:D' . $iLastRow)->applyFromArray($styleArray);

		$styleArray = [
			'borders' => [
				'outline' => [
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
				],
			],
		];
		$sheet->getStyle('B6:D6')->applyFromArray($styleArray);

		$styleArray = [
			'borders' => [
				'outline' => [
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
				],
			],
		];
		$sheet->getStyle('B6:D' . $iLastRow)->applyFromArray($styleArray);

		$styleArray = [
			'font' => [
				'bold' => true,
			],
			'borders' => [
				'outline' => [
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
				],
			],
		];
		$sheet->getStyle('B' . $iLastRow . ':D' . $iLastRow)->applyFromArray($styleArray);

		$styleArray = [
			'alignment' => [
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
			],
		];
		$sheet->getStyle('B' . $iLastRow . ':C' . $iLastRow)->applyFromArray($styleArray);

		// Signature row
		$iRow = $iLastRow + 3;

		$styleArray = [
			'borders' => [
				'allBorders' => [
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
				],
			],
		];
		$sheet->getStyle('C' . $iRow . ':D' . $iRow)->applyFromArray($styleArray);
		$sheet->getRowDimension($iRow)->setRowHeight(150);

	}

}
