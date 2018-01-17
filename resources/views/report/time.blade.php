@include('_include.admin_header',
	[
		'id'				=> 'time',
		'title'				=> 'Time table',
		'css'				=> 'time',
	]
)

		<form action="{{ $data['url_pattern'] }}" method="post">
			{{ csrf_field() }}
			<input type="hidden" id="sDbRequestDate" name="sDbRequestDate" value="{{ $sDbRequestDate }}">

		<div class="w3-container w3-responsive">
			<div class="w3-row">
				<div class="w3-col s12 m4 l4">
					<label class="w3-xlarge">{{ date('Y年m月d日', strtotime($sDbRequestDate)) }}</label>
					<br>
					<div id="datepicker"></div>
				</div>
				<div class="w3-col s12 m4 l4">
					@include('_include.alert_message', ["is_hidden" => TRUE])
				</div>
				<div class="w3-col s12 m4 l4">
					&nbsp;
				</div>
			</div>
			<br>
		</div>

		@foreach($arrOffTasks as $key => $task)
			<input type="hidden" id="input_task[{{ $task->project_id }}][is_off_task]" name="input_task[{{ $task->project_id }}][is_off_task]" value="1">
			@foreach ($task->timeline as $timeKey => $timeFlag)
			<input type="hidden" id="input_task[{{ $task->project_id }}][{{ $timeKey }}]" name="input_task[{{ $task->project_id }}][{{ $timeKey }}]" value="{{ $timeFlag }}">
			@endforeach
		@endforeach

		@foreach($arrOnTasks as $key => $task)
			<input type="hidden" id="input_task[{{ $task->project_id }}][is_off_task]" name="input_task[{{ $task->project_id }}][is_off_task]" value="0">
			@foreach ($task->timeline as $timeKey => $timeFlag)
			<input type="hidden" id="input_task[{{ $task->project_id }}][{{ $timeKey }}]" name="input_task[{{ $task->project_id }}][{{ $timeKey }}]" value="{{ $timeFlag }}">
			@endforeach
		@endforeach


		<div class="w3-responsive">
		<table class="timesheet_table w3-table-all w3-hoverable w3-striped w3-bordered w3-tiny">
		<thead>
			<tr>
				<td colspan="{{ $iTimesLength + 3 }}"><h2>稼働</h2></td>
			</tr>

			<tr class="w3-brown">
				<th>
					<input type="checkbox" id="chkTopAll">
				</th>
				<th nowrap="nowrap">プロジェクト</th>
				@foreach ($arrTimes as $timeKey => $time)
				<th>{{ $time }}</th>
				@endforeach
				<th></th>
			</tr>
			</thead>

			@foreach($arrOnTasks as $key => $task)
			<tr class="{{ ($task->is_deleted) ? 'w3-gray' : '' }}">
				<td>
					<input type="checkbox" id="chkTop[{{ $key }}]">
				</td>
				<td nowrap="nowrap" width="200px">{{ $task->name }}</td>
				@foreach ($task->timeline as $timeKey => $timeFlag)
					<td id="task[{{ $task->id }}][{{ $timeKey }}]" class="timesheet valign center {{ ($timeFlag == 1) ? 'w3-green' : '' }}">{{ ($timeFlag == 1) ? '30分' : '' }}</td>
				@endforeach
				<td id="hourSum[{{ $task->id }}]">00:00</td>
			</tr>
			@endforeach
			<tfoot>
			<tr>
				<td colspan="{{ $iTimesLength + 2 }}"><span class="w3-right w3-medium">合計</span></td>
				<td><span class="w3-medium" id="divAllOnWorkingHours">00:00</span></td>
			</tr>
			</tfoot>
		</table>

		<br><br>
		<table class="timesheet_table w3-table-all w3-hoverable w3-striped w3-bordered w3-tiny">
			<thead>
			<tr>
				<td colspan="{{ $iTimesLength + 3 }}"><h2>休憩</h2></td>
			</tr>
			<tr class="w3-brown">
				<th>
					<input type="checkbox" id="chkTopAll">
				</th>
				<th nowrap="nowrap">プロジェクト</th>
				@foreach ($arrTimes as $timeKey => $time)
				<th>{{ $time }}</th>
				@endforeach
				<th></th>
			</tr>
			</thead>

			@foreach($arrOffTasks as $key => $task)
			<tr class="{{ ($task->is_deleted) ? 'w3-gray' : '' }}">
				<td>
					<input type="checkbox" id="chkTop[{{ $key }}]">
				</td>
				<td nowrap="nowrap" width="200px"><span>{{ $task->name }}</span></td>
				@foreach ($task->timeline as $timeKey => $timeFlag)
					<td id="task[{{ $task->id }}][{{ $timeKey }}]" class="timesheet valign center {{ ($timeFlag == 1) ? 'w3-green' : '' }}">{{ ($timeFlag == 1) ? '30分' : '' }}</td>
				@endforeach
				<td id="hourSum[{{ $task->id }}]">00:00</td>
			</tr>
			@endforeach
			<tfoot>
			<tr>
				<td colspan="{{ $iTimesLength + 2 }}"><span class="w3-right w3-medium">合計</span></td>
				<td><span class="w3-medium" id="divAllOffWorkingHours">00:00</span></td>
			</tr>
			</tfoot>
		</table>
		<br><br>
		</div>

		<div class="w3-container">
		<br>
		<table class="timesheet_table w3-table w3-bordered w3-tiny w3-center">
			<tr>
				<td><span class="w3-right w3-xlarge">合計</span></td>
				<td><span class="w3-xlarge" id="divAllWorkingHours">00:00</span></td>
			</tr>
			<tfoot>
			<tr>
				<td colspan="2">
					<div class="w3-center">
						<button type="button" id="btnReportSubmit" class="btn w3-button w3-brown w3-xlarge ">　　<span class="fa fa-save"></span> 登録　　</button>
					</div>
				</td>
			</tr>
			</tfoot>
		</table>
		<br>
		</div>

		</form>


@include('_include.admin_footer', [
		'js'				=> 'time',
])
