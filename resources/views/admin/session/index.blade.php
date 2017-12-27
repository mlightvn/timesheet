@include('_include.admin_header',
	[
		'id'				=> 'session',
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
	<a href="{{ $data['url_pattern'] }}" class="w3-button w3-brown"><span class="glyphicon glyphicon-list"></span></a>&nbsp;
	@if (in_array($logged_in_user->permission_flag, array("Administrator", "Manager")))
	<a href="{{ $data['url_pattern'] }}/add" class="w3-button w3-brown"><span class="glyphicon glyphicon-plus"></span></a>
	@endif
	<br><br>
	<table class="timesheet_table w3-table-all w3-hoverable w3-striped w3-bordered">
		<thead>
		<tr class="w3-brown">
			<th>ID</th>
			@if ( in_array($logged_in_user->permission_flag, array("Administrator")) )
			<th>企業名</th>
			@endif
			<th>部署</th>
			<th></th>
		</tr>
		</thead>
		<tbody id="listBody">
		@foreach($arrSessions as $key => $session)
		<tr class="{{ ($session->is_deleted == 1) ? 'w3-gray' : '' }}">
			<td>{{ $session->id }}</td>
			@if ( in_array($logged_in_user->permission_flag, array("Administrator")) )
			<td>{{ $session->organization_name }}</td>
			@endif
			<td>
			@if (in_array($logged_in_user->permission_flag, array("Administrator", "Manager")))
			<a href="{{ $data['url_pattern'] }}/edit/{{ $session->id }}">{{ $session->name }}</a>
			@else
			{{ $session->name }}
			@endif
			</td>
			<td>
			@if (in_array($logged_in_user->permission_flag, array("Administrator", "Manager")))
			<a href="{{ $data['url_pattern'] }}/edit/{{ $session->id }}"><span class="glyphicon glyphicon-pencil"></span></a> 
			|
					@if ($session->is_deleted)
			<a href="{{ $data['url_pattern'] }}/recover/{{ $session->id }}"><span class="fa fa-recycle w3-text-green"></span></a>
					@else
			<a href="{{ $data['url_pattern'] }}/delete/{{ $session->id }}"><span class="fa fa-trash w3-text-red"></span></a>
					@endif
			@endif
			</td>
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

	@include('_include.admin.session.add')

@include('_include.admin_footer', [
		'js'				=> 'admin/session',
])
