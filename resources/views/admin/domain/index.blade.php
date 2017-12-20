@include('_include.admin_header',
	[
		'id'				=> 'domain_list',
	]
)

<div class="w3-row">
	<h1>タスク一覧</h1>
	<br>
</div>

@include('_include.admin_search', ['keyword'=>$data["keyword"]])

@if(session("message"))
	@include('_include.alert_message', ["message" => (isset($message) ? $message : session("message")), "alert_type" => (isset($alert_type) ? $alert_type : session("alert_type"))])
@endif

<div class="w3-row">
	<a href="{{ \Request::url() }}" class="w3-button w3-brown"><span class="fa fa-list"></span></a>&nbsp;
	{{--
	<a class="w3-button w3-brown" data-toggle="modal" data-target="#modal"><span class="fa fa-plus"></span></a>
	--}}
	<a href="{{ \Request::url() }}/add" class="w3-button w3-brown"><span class="fa fa-plus"></span></a>
	<br><br>

	<form action="{{ \Request::url() }}/update" method="post">
	{{ csrf_field() }}
	<table class="timesheet_table w3-table-all w3-hoverable w3-striped w3-bordered">
		<thead>
		<tr class="w3-brown">
			<th>ID</th>
			<th>Domain Name</th>
			<th>url</th>
			<th></th>
		</tr>
		</thead>
		@foreach($arrModel as $key => $model)
		<tr class="{{ ($model->is_deleted == 1) ? 'w3-gray' : '' }}">
			<td>{{ $model->id }}</td>
			<td><a href="{{ \Request::url() }}/edit/{{ $model->id }}">{{ $model->name }}</a></td>
			<td><a href="{{ \Request::url() }}/edit/{{ $model->id }}">{{ $model->url }}</a></td>
			<td><a href="{{ \Request::url() }}/edit/{{ $model->id }}"><span class="fa fa-pencil"></span></a>
			@if($logged_in_user->session_is_manager == "Manager")
					@if ($model->is_deleted)
			| <a href="{{ \Request::url() }}/recover/{{ $model->id }}"><span class="fa fa-recycle w3-text-green"></span></a>
					@else
			| <a href="{{ \Request::url() }}/delete/{{ $model->id }}"><span class="fa fa-trash w3-text-red"></span></a>
					@endif
			@endif
			</td>
		</tr>
		@endforeach

{{--
		<tfoot>
		<tr>
			<td colspan="5">
				<div class="w3-center">
					<button type="submit" class="w3-button w3-brown w3-xlarge">　　<span class="fa fa-pencil"></span> 登録　　</button>
				</div>
			</td>
		</tr>
		</tfoot>
	--}}
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
