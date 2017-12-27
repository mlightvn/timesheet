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
	<a href="{{ $data['url_pattern'] }}" class="w3-button w3-brown"><span class="glyphicon glyphicon-list"></span></a>&nbsp;
	@if ( in_array($logged_in_user->permission_flag, array("Administrator", "Manager")) )
	<a href="{{ $data['url_pattern'] }}/add" class="w3-button w3-brown"><span class="glyphicon glyphicon-plus"></span></a>
{{--
	<a class="w3-button w3-brown" data-toggle="modal" data-target="#modal"><span class="glyphicon glyphicon-plus"></span></a>
--}}
	@endif
	<br><br>
	<table class="timesheet_table w3-table-all w3-hoverable w3-striped w3-bordered">
		<thead>
		<tr class="w3-brown">
			<th>ID</th>
			@if ( in_array($logged_in_user->permission_flag, array("Administrator")) )
			<th>企業名</th>
			@endif
			<th>ユーザー名</th>
			<th>部署</th>
			<th>email</th>
			@if ( in_array($logged_in_user->permission_flag, array("Administrator", "Manager")) )
			<th>レポート</th>
			@endif
			<th></th>
		</tr>
		</thead>
		@foreach($arrUsers as $key => $user)
		<tr class="{{ ($user->is_deleted == 1) ? 'w3-gray' : '' }}">
			<td>{{ $user->id }}</td>
			@if ( in_array($logged_in_user->permission_flag, array("Administrator")) )
			<td>{{ $user->organization_name }}</td>
			@endif
			<td>
			@if (($user->permission_flag == "Manager"))
			<span class="glyphicon glyphicon-king"></span> 
			@else
			<span class="glyphicon glyphicon-pawn"></span> 
			@endif
			&nbsp;
			@if ((in_array($logged_in_user->permission_flag, array("Administrator", "Manager"))) || ($logged_in_user->id == $user->id) )
			<a href="{{ $data['url_pattern'] }}/edit/{{ $user->id }}"><span class="glyphicon glyphicon-pencil"></span> {{ $user->name }}</a>
			@else
			{{ $user->name }}
			@endif
			</td>
			<td>{{ $user->session_name }}</td>
			<td><a href="mailto:{{ $user->email }}"><span class="glyphicon glyphicon-envelope"></span> {{ $user->email }}</a></td>
			@if ( in_array($logged_in_user->permission_flag, array("Administrator", "Manager")) )
			<td><a href="/admin/report/task?user_id={{ $user->id }}"><span class="fa fa-file-o" aria-hidden="true"></span> プロジェクトのレポート</a></td>
			@endif
			<td>
			@if ((in_array($logged_in_user->permission_flag, array("Administrator", "Manager"))) || ($logged_in_user->id == $user->id) )
			<a href="{{ $data['url_pattern'] }}/edit/{{ $user->id }}"><span class="glyphicon glyphicon-pencil"></span></a> 
			@endif
			@if ( in_array($logged_in_user->permission_flag, array("Administrator", "Manager")) )
				@if ( $user->permission_flag != "Manager" )
					@if ($user->is_deleted)
			| <a href="{{ $data['url_pattern'] }}/recover/{{ $user->id }}"><span class="fa fa-recycle w3-text-green"></span></a>
					@else
			| <a href="{{ $data['url_pattern'] }}/delete/{{ $user->id }}"><span class="fa fa-trash w3-text-red"></span></a>
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
