@include('_include.admin_header',
	[
		'id'				=> 'task_list',
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
	<a href="{{ \Request::url() }}" class="w3-button w3-brown"><span class="glyphicon glyphicon-list"></span></a>&nbsp;
	<a class="w3-button w3-brown" data-toggle="modal" data-target="#modal"><span class="glyphicon glyphicon-plus"></span></a>
	{{--
	<a href="{{ \Request::url() }}/add" class="w3-button w3-brown"><span class="glyphicon glyphicon-plus"></span></a>
	--}}
	<br><br>

	<form action="{{ \Request::url() }}/update" method="post">
	{{ csrf_field() }}
	<table class="timesheet_table w3-table-all w3-hoverable w3-striped w3-bordered">
		<thead>
		<tr class="w3-brown">
			<th>ID</th>
			<th>休憩のフラグ</th>
			<th>タスク</th>
			<th>自分のタスク</th>
			<th></th>
		</tr>
		</thead>
		@foreach($arrTasks as $key => $task)
		<tr class="{{ ($task->is_deleted == 1) ? 'w3-gray' : '' }}">
			<td>{{ $task->id }}</td>
			<td>
				<label class="switch">
					<input type="checkbox" name="task[{{ $task->id }}][is_off_task]" value="1" {{ (($task->is_off_task) ? 'checked="checked"' : '') }} {{ ($logged_in_user->session_is_manager != "Manager") ? 'disabled="disabled' : '' }}>
					<span class="slider round"></span>
				</label>
			</td>
			<td><a href="{{ \Request::url() }}/edit/{{ $task->id }}">{{ $task->name }}</a></td>
			<td>
				<label class="switch">
					<input type="checkbox" name="task[{{ $task->id }}][user_id]" {{ (($task->task_id) ? 'checked="checked"' : '') }}>
					<span class="slider round"></span>
				</label>
			</td>
			<td><a href="{{ \Request::url() }}/edit/{{ $task->id }}"><span class="glyphicon glyphicon-edit"></span></a>
			@if($logged_in_user->session_is_manager == "Manager")
					@if ($task->is_deleted)
			| <a href="{{ \Request::url() }}/recover/{{ $task->id }}"><span class="fa fa-recycle"></span></a>
					@else
			| <a href="{{ \Request::url() }}/delete/{{ $task->id }}"><span class="fa fa-trash"></span></a>
					@endif
			@endif
			</td>
		</tr>
		@endforeach

		<tfoot>
		<tr>
			<td colspan="5">
				<div class="w3-center">
					<button type="submit" class="w3-button w3-brown w3-xlarge">　　<span class="fa fa-edit"></span> 登録　　</button>
				</div>
			</td>
		</tr>
		</tfoot>
	</table>
	</form>
	<br>
	@if(count($arrTasks) == 0)
	データが存在していません。
	<br>
	@endif

	@include('_include.admin_pagination', ['list'=>$arrTasks, 'keyword'=>$data["keyword"]])
	<br>
</div>
	@include('_include.admin.task.add')

@include('_include.admin_footer', [
		'js'				=> 'admin/task',
])
