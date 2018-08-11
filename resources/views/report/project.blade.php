@include('_include.admin_header',
	[
		'id'					=> 'report_project',
		'title'					=> 'Task table',
		'css'					=> 'report/project',
		'datepicker'			=> true,
	]
)

		<form action="{{ $data['url_pattern'] }}" method="post">
			{{ csrf_field() }}

{{--
			<input type="hidden" id="report_user_id" value="{{ $report_user_id }}">
			<input type="hidden" id="sRequestYearMonth" name="sRequestYearMonth" value="{{ $sRequestYearMonth }}">
			<input type="hidden" id="sRequestDate" name="sRequestDate" value="{{ $sDbRequestDate }}">
			<input type="hidden" id="iTotalWorkingMinutes" name="iTotalWorkingMinutes" value="{{ $total_working_minutes }}">
			<input type="hidden" id="sTotalWorkingHoursLabel" name="sTotalWorkingHoursLabel" value="{{ $total_working_hours_label }}">
--}}

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

			@if(count($data["timeSheetList"]) > 0)
			<table class="timesheet_table w3-table-all w3-hoverable w3-bordered">
				<thead>
				<tr class="w3-brown">
					<th nowrap="nowrap">{{__('message.excel_output_flag')}}</th>
					<th nowrap="nowrap">{{__('message.project.project')}}</th>
					<th nowrap="nowrap">{{__('message.task.task')}}</th>
					<th nowrap="nowrap">{{__('message.total_working_hours')}}</th>
				</tr>
				</thead>

				@php
				$total_working_minutes = 0;
				$total_working_hours_display = "00:00";
				$time_line_previous = null;

				$project_summary = array();
				$project_summary["minutes"] = 0;
				$project_summary["hours_display"] = "00:00";

				@endphp

				@foreach($data["timeSheetList"] as $key => $time_line)
					@php
						$total_working_minutes += $time_line->TOTAL_MINUTES;
					@endphp

					@if(($time_line_previous !== null) && ($time_line_previous->project_id !== $time_line->project_id))
						@php
							$minutes = $project_summary["minutes"];
							$hours = floor($minutes / 60);
							$remained_minutes = ($minutes % 60);

							$project_summary["hours_display"] = str_pad($hours, 2, 0, STR_PAD_LEFT) . ":" . str_pad($remained_minutes, 2, 0, STR_PAD_LEFT);

						@endphp
				<tr>
					<td colspan="3" class="text-right"><strong>{{__('message.total')}}</strong></td>
					<td><strong>{{$project_summary["hours_display"]}}</strong></td>
				</tr>

						@php
							$project_summary["minutes"] = 0;
						@endphp

					@endif

				<tr>
					<td>
						@if($time_line->excel_flag)
						<i class="fa fa-flag" aria-hidden="true"></i>
						@endif
					</td>
					<td>
					@if($time_line_previous == null || ($time_line_previous->project_id !== $time_line->project_id))
						<strong>{{ $time_line->project_name }}</strong>
					@endif
					</td>
					<td>{{ $time_line->project_task_name }}</td>
					<td>{{ $time_line->HOURS_DISPLAY }}</td>
				</tr>

					@php
						$time_line_previous = $time_line;

						$project_summary["minutes"] += $time_line->TOTAL_MINUTES;

					@endphp
				@endforeach

				@php
					$minutes = $project_summary["minutes"];
					$hours = floor($minutes / 60);
					$remained_minutes = ($minutes % 60);

					$project_summary["hours_display"] = str_pad($hours, 2, 0, STR_PAD_LEFT) . ":" . str_pad($remained_minutes, 2, 0, STR_PAD_LEFT);

				@endphp
				<tr>
					<td colspan="3" class="text-right"><strong>{{__('message.total')}}</strong></td>
					<td><strong>{{$project_summary["hours_display"]}}</strong></td>
				</tr>

				@php

				$total_working_hours = floor($total_working_minutes / 60);
				$total_working_hours_minutes = $total_working_minutes % 60;
				$total_working_hours_display = str_pad($total_working_hours, 2, 0, STR_PAD_LEFT) . ":" . str_pad($total_working_hours_minutes, 2, 0, STR_PAD_LEFT);
				@endphp

				@if($time_line_previous->project_id !== $time_line->project_id)
				<tr>
					<td colspan="3">{{__('message.total')}}：</td>
					<td><label class="w3-xlarge">{{ $total_working_hours_display }}</label>
					</td>
				</tr>
				@endif

				<tfoot>
					<tr>
						<td colspan="2">
							<div class="w3-center">
								<button type="button" onclick="window.open('/report/project_download_{{ $requestYear }}_{{ $requestMonth }}?user_id={{ $report_user_id }}','_blank');" class="w3-button w3-brown w3-xlarge" disabled="disabled">　　<span class="fas fa-cloud-download-alt"></span> {{__('message.download')}}　　</button>
							</div>
						</td>
					</tr>
				</tfoot>

			</table>
			@else
			{{__('message.data_does_not_exist')}}
			@endif
			<br><br>


		</div>

		</form>


@include('_include.admin_footer', [
	"js"				=> "report/project",
	'datepicker'		=> true,
])
