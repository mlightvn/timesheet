@include('_include.admin_header',
	[
		'id'				=> 'user',
	]
)

<div class="w3-row">
	<h1>ユーザー一覧</h1>
	<br>
</div>

@include('_include.admin_search', ['keyword'=>$data["keyword"]])

@if(isset($message) || session("message"))
	@include('_include.alert_message', ["message" => (isset($message) ? $message : session("message")), "alert_type" => (isset($alert_type) ? $alert_type : session("alert_type"))])
@endif

<div class="w3-row">
	<a href="{{ \Request::url() }}" class="w3-button w3-brown"><span class="glyphicon glyphicon-list"></span></a>&nbsp;
	@if ( $logged_in_user->session_is_manager == "Manager" )
	<a href="{{ \Request::url() }}/add" class="w3-button w3-brown"><span class="glyphicon glyphicon-plus"></span></a>
	@endif
	<br><br>
	<table class="timesheet_table w3-table-all w3-hoverable w3-striped w3-bordered w3-tiny">
		<thead>
		<tr class="w3-brown">
			<th>ID</th>
			<th>ユーザー名</th>
			<th>部署</th>
			<th>email</th>
			@if ( $logged_in_user->session_is_manager == "Manager" )
			<th>レポート</th>
			@endif
			<th></th>
		</tr>
		</thead>
		@foreach($arrUsers as $key => $user)
		<tr class="{{ ($user->is_deleted == 1) ? 'w3-gray' : '' }}">
			<td>{{ $user->id }}</td>
			<td>
			@if (($user->session_is_manager == "Manager"))
			<span class="glyphicon glyphicon-king"></span> 
			@else
			<span class="glyphicon glyphicon-pawn"></span> 
			@endif
			&nbsp;
			@if (($logged_in_user->session_is_manager == "Manager") || ($logged_in_user->id == $user->id) )
			<a href="{{ \Request::url() }}/edit/{{ $user->id }}"><span class="glyphicon glyphicon-edit"></span> {{ $user->name }}</a>
			@else
			{{ $user->name }}
			@endif
			</td>
			<td>{{ $user->session_name }}</td>
			<td><a href="mailto:{{ $user->email }}"><span class="glyphicon glyphicon-envelope"></span> {{ $user->email }}</a></td>
			@if ( $logged_in_user->session_is_manager == "Manager" )
			<td><a href="/admin/report/task?user_id={{ $user->id }}"><span class="fa fa-file-o" aria-hidden="true"></span> タスクのレポート</a></td>
			@endif
			<td>
			@if (($logged_in_user->session_is_manager == "Manager") || ($logged_in_user->id == $user->id) )
			<a href="{{ \Request::url() }}/edit/{{ $user->id }}"><span class="glyphicon glyphicon-edit"></span></a> 
			@endif
			@if ( $logged_in_user->session_is_manager == "Manager" )
				@if ( $user->session_is_manager != "Manager" )
					@if ($user->is_deleted)
			| <a href="{{ \Request::url() }}/recover/{{ $user->id }}"><span class="fa fa-recycle"></span></a>
					@else
			| <a href="{{ \Request::url() }}/delete/{{ $user->id }}"><span class="fa fa-trash"></span></a>
					@endif
				@endif
			@endif
			</td>
		</tr>
		@endforeach
	</table>
	<br>

	@if(count($arrUsers) == 0)
	データが存在していません。
	<br>
	@endif

	@include('_include.admin_pagination', ['list'=>$arrUsers, 'keyword'=>$data["keyword"]])
	<br>
</div>

@include('_include.admin_footer')
