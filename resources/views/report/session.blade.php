@include('_include.admin_header',
	[
		'id'				=> 'report_session',
	]
)

<div class="w3-row">
	<h1>部署一覧</h1>
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
			<th>部署</th>
			@if (in_array($logged_in_user->permission_flag, array("Owner", "Manager")))
			<th>先月のレポート<br>{{ $data['prev_yearmonth'] }}</th>
			<th>当月のレポート<br>{{ $data['curr_yearmonth'] }}</th>
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
			@if (in_array($logged_in_user->permission_flag, array("Owner", "Manager")))
			<td><a href="{{ \Request::url() }}/{{ $session->id }}/download/{{ $data['prev_yearmonth'] }}" class="w3-text-brown"><span class="fas fa-cloud-download-alt"></span></a></td>
			<td><a href="{{ \Request::url() }}/{{ $session->id }}/download/{{ $data['curr_yearmonth'] }}" class="w3-text-brown"><span class="fas fa-cloud-download-alt"></span></a></td>
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
