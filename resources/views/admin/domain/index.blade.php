@include('_include.admin_header',
	[
		'id'				=> 'domain_list',
	]
)

<div class="w3-row">
	<h1>ドメイン一覧</h1>
	<br>
</div>

@include('_include.admin_search', ['keyword'=>$data["keyword"]])

@if(session("message"))
	@include('_include.alert_message', ["message" => (isset($message) ? $message : session("message")), "alert_type" => (isset($alert_type) ? $alert_type : session("alert_type"))])
@endif

<div class="w3-row">
	<a href="{{ $data['url_pattern'] }}" class="w3-button w3-brown"><span class="glyphicon glyphicon-list"></span></a>&nbsp;
	<a href="{{ $data['url_pattern'] }}/add" class="w3-button w3-brown"><span class="glyphicon glyphicon-plus"></span></a>
	<br><br>

	<form action="{{ $data['url_pattern'] }}/update" method="post">
	{{ csrf_field() }}
	<table class="timesheet_table w3-table-all w3-hoverable w3-striped w3-bordered">
		<thead>
		<tr class="w3-brown">
			<th>ID</th>
			<th>環境</th>
			<th>ドメイン名</th>
			<th>SSHとDB接続</th>
			<th></th>
		</tr>
		</thead>
		@foreach($arrModel as $key => $model)
		<tr class="{{ ($model->is_deleted == 1) ? 'w3-gray' : '' }}">
			<td>{{ $model->id }}</td>
			<td><a href="?development_flag={{ $model->development_flag }}"><i class="fa fa-search"></i> {{ $model->development_flag_label }}</a></td>
			<td>
				<a href="{{ $data['url_pattern'] }}/edit/{{ $model->id }}"><i class="fa fa-pencil"></i> {{ $model->name }}</a><br><br>
				サイト： <a href="{{ $model->url }}">{{ $model->url }}</a><br>
				管理： <a href="{{ $model->admin_url }}">{{ $model->admin_url }}</a>
			</td>
			<td>
				SSH： {{ $model->ssh_access_command }}
				<br>
				DB： {{ $model->db_access_command }}
			</td>
			<td><a href="{{ $data['url_pattern'] }}/edit/{{ $model->id }}"><i class="fa fa-pencil"></i></a>
			@if($logged_in_user->permission_flag == "Manager")
					@if ($model->is_deleted)
			| <a href="{{ $data['url_pattern'] }}/recover/{{ $model->id }}"><i class="fa fa-recycle w3-text-green"></i></a>
					@else
			| <a href="{{ $data['url_pattern'] }}/delete/{{ $model->id }}"><i class="fa fa-trash w3-text-red"></i></a>
					@endif
			@endif
			</td>
		</tr>
		@endforeach

	</table>
	</form>
	<br>
	@if(count($arrModel) == 0)
	データが存在していません。
	<br>
	@endif

	@include('_include.admin_pagination', ['list'=>$arrModel, 'keyword'=>$data["keyword"]])
	<br>
</div>

@include('_include.admin_footer', [
		'js'				=> 'admin/task',
])
