@include('_include.admin_header',
	[
		'id'				=> 'report_time',
		'title'				=> 'Time table',
		'css'				=> 'report/time',
		'datepicker'		=> true,
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
					<ol>
						<li><a href="/manage/project" title="" class="w3-button w3-brown">{{__('message.project.list')}}</a> &gt; <a href="/manage/project_task/add" title="" class="w3-button w3-brown"><span class="fas fa-plus"></span></li>
						<li><a href="/manage/project_task" title="" class="w3-button w3-brown">{{__('message.task.list')}}</a> &gt; <a href="/manage/project_task/add" title="" class="w3-button w3-brown"><span class="fas fa-plus"></span></a></li>
					</ol>

				</div>
			</div>
			<br>
		</div>

		@foreach($data["arrAllTasks"] as $key => $model)
			@foreach ($model->timeline as $timeKey => $timeFlag)
			<input type="hidden" id="input_task[{{ $model->project_task_id }}][{{ $timeKey }}]" name="input_task[{{ $model->project_task_id }}][{{ $timeKey }}]" value="{{ $timeFlag }}">
			@endforeach
		@endforeach


		<div class="w3-responsive">
		<table class="timesheet_table w3-table-all w3-hoverable w3-striped w3-bordered w3-tiny">
		<thead>
			<tr class="w3-brown">
				<th nowrap="nowrap" width="200px">{{__('message.project.project')}}</th>
				<th nowrap="nowrap" width="200px">{{__('message.task.task')}}</th>
				@foreach ($arrTimes as $timeKey => $time)
				<th>{{ $time }}</th>
				@endforeach
				<th></th>
			</tr>
			</thead>

			@foreach($data["arrAllTasks"] as $key => $model)
			<tr class="{{$model->DELETED_CSS_CLASS}}">
				<td nowrap="nowrap">
					{{ $model->project_name }}<br>
					<small>{{ $model->project_description }}</small>
				</td>
				<td>
					{{ $model->project_task_name }}<br>
					<small>{{ $model->project_task_description }}</small>
				</td>
				@foreach ($model->timeline as $timeKey => $timeFlag)
					<td id="task[{{ $model->project_task_id }}][{{ $timeKey }}]" class="timesheet valign center {{ ($timeFlag == 1) ? 'w3-green' : '' }}">{{ ($timeFlag == 1) ? '30分' : '' }}</td>
				@endforeach
				<td id="hourSum[{{ $model->project_task_id }}]">00:00</td>
			</tr>
			@endforeach
			<tfoot>
			<tr>
				<td colspan="{{ $iTimesLength + 2 }}"><span class="w3-right w3-medium">{{__('message.total')}}</span></td>
				<td><span class="w3-medium" id="divAllOnWorkingHours">00:00</span></td>
			</tr>
			</tfoot>
		</table>

		<br><br>
		</div>

		<div class="w3-container">
		<br>
		<table class="timesheet_table w3-table w3-bordered w3-tiny w3-center">
			<tr>
				<td><span class="w3-right w3-xlarge">{{__('message.total')}}</span></td>
				<td><span class="w3-xlarge" id="divAllWorkingHours">00:00</span></td>
			</tr>
			<tfoot>
			<tr>
				<td colspan="2">
					<div class="w3-center">
						<button type="button" id="btnReportSubmit" class="btn w3-button w3-brown w3-xlarge ">　　<span class="fas fa-save"></span> {{__('message.register')}}　　</button>
					</div>
				</td>
			</tr>
			</tfoot>
		</table>
		<br>
		</div>

		</form>


@include('_include.admin_footer', [
		'js'				=> 'report/time',
		'datepicker'		=> true,
])
