@include('_include.admin_header',
	[
		'id'				=> 'task',
		'title'				=> 'Task table',
		'css'				=> 'task',
	]
)

		<form action="{{ $data['url_pattern'] }}" method="post">
			{{ csrf_field() }}

			<input type="hidden" id="report_user_id" value="{{ $report_user_id }}">
			<input type="hidden" id="sRequestYearMonth" name="sRequestYearMonth" value="{{ $sRequestYearMonth }}">
			<input type="hidden" id="sRequestDate" name="sRequestDate" value="{{ $sDbRequestDate }}">
			<input type="hidden" id="iTotalWorkingMinutes" name="iTotalWorkingMinutes" value="{{ $total_working_minutes }}">
			<input type="hidden" id="sTotalWorkingHoursLabel" name="sTotalWorkingHoursLabel" value="{{ $total_working_hours_label }}">

		<div id="divMessageBorder" class="container w3-responsive">
			<div class="w3-row w3-col s12 m12 l12">
				<div class="w3-center">
						<span id="datepicker"></span>
				</div>
			</div>
			<br><br><br>
		</div>

		@if (session("message"))
		<div id="divMessageBorder" class="w3-responsive">
			<div class="w3-row w3-col s12 m12 l12 w3-border w3-border-green">
				<br>
				&nbsp;&nbsp;<div id="divMessage" class="w3-text-red">{{ session("message") }}</div>
				<br>
			</div>
			<br><br><br>
		</div>
		@endif

		<div class="w3-responsive">
		@if(count($arrTaskSheet["on_task"]) > 0)
		<table class="timesheet_table w3-table-all w3-hoverable w3-bordered">
			<thead>
			<tr class="w3-brown">
				<th nowrap="nowrap">稼働のプロジェクト</th>
				<th>時間</th>
			</tr>
			</thead>

			@foreach($arrTaskSheet["on_task"]["task"] as $day => $oTask)
			<tr>
				<td>
					{{ $oTask->project_name }}
				</td>
				<td>
					{{ $oTask->total_working_hours_label }}
				</td>
			</tr>
			@endforeach

			<tfoot>
			<tr>
				<td align="right">
				</td>
				<td><label class="w3-xlarge">{{ $arrTaskSheet["on_task"]["total_working_hours_label"] }}</label>
				</td>
			</tr>
			</tfoot>
		</table>
		@else
		稼働のデータがありません。<br>
		@endif
		<br><br>
		</div>

		<div class="w3-responsive">
		@if(count($arrTaskSheet["off_task"]) > 0)
		<table class="timesheet_table w3-table-all w3-hoverable w3-bordered">
			<thead>
			<tr class="w3-brown">
				<th nowrap="nowrap">休憩のプロジェクト</th>
				<th>時間</th>
			</tr>
			</thead>

			@foreach($arrTaskSheet["off_task"]["task"] as $day => $oTask)
			<tr>
				<td>
					{{ $oTask->project_name }}
				</td>
				<td>
					{{ $oTask->total_working_hours_label }}
				</td>
			</tr>
			@endforeach

			<tfoot>
			<tr>
				<td align="right">
				</td>
				<td><label class="w3-xlarge">{{ $arrTaskSheet["off_task"]["total_working_hours_label"] }}</label>
				</td>
			</tr>
			</tfoot>
		</table>
		@else
		休憩のデータがありません。<br>
		@endif
		<br><br>
		</div>

		<div class="w3-responsive">
		<table class="timesheet_table w3-table-all w3-hoverable w3-bordered w3-xlarge">
			<tr>
				<td><label class="w3-right">合計：</label>
				</td>
				<td><label class="w3-xlarge">{{ $total_working_hours_label }}</label>
				</td>
			</tr>

			<tfoot>
			<tr>
				<td colspan="2">
					<div class="w3-center">
						<button type="button" onclick="window.open('/admin/report/task_download_{{ $requestYear }}_{{ $requestMonth }}?user_id={{ $report_user_id }}','_blank');" class="w3-button w3-brown w3-xlarge">　　<span class="fa fa-download"></span> ダウンロード　　</button>
					</div>
				</td>
			</tr>
			</tfoot>
		</table>
		<br>
		</div>

		</form>


@include('_include.admin_footer', [
	"js"			=> "task",
])
