@include('_include.admin_header',
	[
		'id'				=> 'report_department',
	]
)

<div class="w3-row">
	<h1>{{__('screen.report.department.department_list')}}</h1>
	<br>
</div>

@include('_include.admin_search', ['keyword'=>$data["keyword"]])

@if(isset($message) || session("message"))
	@include('_include.alert_message', ["message" => (isset($message) ? $message : session("message")), "alert_type" => (isset($alert_type) ? $alert_type : session("alert_type"))])
@endif

<div class="w3-row">
	<br><br>
	<table class="timesheet_table w3-table-all w3-hoverable w3-striped w3-bordered">
		<thead>
		<tr class="w3-brown">
			<th>#</th>
			<th>{{__('screen.report.department.department')}}</th>
			@if (in_array($logged_in_user->role, array("Owner", "Manager")))
			<th>{{__('screen.report.department.last_month_report')}}<br>{{ $data['prev_yearmonth'] }}</th>
			<th>{{__('screen.report.department.current_month_report')}}<br>{{ $data['curr_yearmonth'] }}</th>
			@endif
		</tr>
		</thead>
		<tbody id="listBody">
		@foreach($arrSessions as $key => $session)
		<tr class="{{ ($session->is_deleted == 1) ? 'w3-gray' : '' }}">
			<td>{{ $session->id }}</td>
			<td>
			{{ $session->name }}
			</td>
			@if (in_array($logged_in_user->role, array("Owner", "Manager")))
			<td><a href="{{ \Request::url() }}/download/{{ $session->id }}?year={{ $data['prev_year'] }}&month={{$data['prev_month']}}" class="w3-text-brown"><span class="fas fa-cloud-download-alt"></span></a></td>
			<td><a href="{{ \Request::url() }}/download/{{ $session->id }}?year={{ $data['curr_year'] }}&month={{$data['curr_month']}}" class="w3-text-brown"><span class="fas fa-cloud-download-alt"></span></a></td>
			@endif
		</tr>
		@endforeach
		</tbody>
	</table>
	<br>

	@if(count($arrSessions) == 0)
	データが存在していません。
	<br>
	@endif

	@include('_include.admin_pagination', ['list'=>$arrSessions, 'keyword'=>$data["keyword"]])
	<br>
</div>

@include('_include.admin_footer', [
		'js'				=> 'admin/session',
])
