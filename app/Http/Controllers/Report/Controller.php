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

		$timeSheet = new ProjectTask();
		$timeSheetList = $timeSheet->getTimeSheetList($this->reportUser, $year, $month);

		$taskSheet 						= array();

		$data["models"] 								= $timeSheetList;
		$arrTasks["task_label"] 						= "稼働プロジェクト";
		$arrTasks["total_minutes"] 						= 0;
		$arrTasks["total_working_hours_label"] 			= "";

		$taskSheet["on_task"] 							= $arrTasks;

		$data["taskSheet"] 	= $taskSheet;

		$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		// $sheet->setCellValue('A1', 'Hello World !');


		// $excel = \Maatwebsite\Excel\Facades\Excel::store($filename, function($excel) use($data)
		{
			// SpreadSheet
			{
				$taskSheet 			= $data["taskSheet"];

				$arrTotalData		= array(
						"label"				=> __("message.total"),
						"minutes"			=> 0,
					);

				// タイトル
				$sheet->setTitle($this->reportUser->id . "_" . $data["user_name"]);
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
					__('message.project.project'),
					__('message.task.task'),
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

		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

		// // Chain the setters
		// $writer->setCreator('Nguyen Nam')->setCompany(env("APP_COMP_NAME"));
		// $writer->setDescription($data["filename"]);

		$file_path = storage_path('tmp/' . $filename . '.xlsx');
		if(file_exists($file_path)){
			unlink($file_path);
		}
		$writer->save($file_path);

		$headers = array(
			  'Content-Type: ' . mime_content_type( $file_path ),
			);
		return \Response::download($file_path, $filename . '.xlsx', $headers)->deleteFileAfterSend(true);;

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
