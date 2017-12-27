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
	<a href="{{ $data['url_pattern'] }}" class="w3-button w3-brown"><span class="glyphicon glyphicon-list"></span></a>&nbsp;
	<a href="{{ $data['url_pattern'] }}/add" class="w3-button w3-brown"><span class="glyphicon glyphicon-plus"></span></a>
	<br><br>

	<form action="{{ $data['url_pattern'] }}/update" method="post">
	{{ csrf_field() }}
	<table class="timesheet_table w3-table-all w3-hoverable w3-striped w3-bordered">
		<thead>
		<tr class="w3-brown">
			<th>ID</th>
			@if ( in_array($logged_in_user->permission_flag, array("Administrator")) )
			<th>企業名</th>
			@endif
			<th>休憩のフラグ</th>
			<th>タスク</th>
			<th>自分のタスク</th>
			<th></th>
		</tr>
		</thead>
		@foreach($arrTasks as $key => $task)
		<tr class="{{ ($task->is_deleted == 1) ? 'w3-gray' : '' }}">
			<td>{{ $task->id }}</td>
			@if ( in_array($logged_in_user->permission_flag, array("Administrator")) )
			<td>{{ $task->organization_name }}</td>
			@endif
			<td>
				<label class="switch">
					<input type="checkbox" name="task[{{ $task->id }}][is_off_task]" value="1" {{ (($task->is_off_task) ? 'checked="checked"' : '') }} {{ ($logged_in_user->permission_flag == "Member") ? 'disabled="disabled' : '' }}>
					<span class="slider round"></span>
				</label>
			</td>
			<td><a href="{{ $data['url_pattern'] }}/edit/{{ $task->id }}">{{ $task->name }}</a></td>
			<td>
				<label class="switch">
					<input type="checkbox" name="task[{{ $task->id }}][user_id]" {{ (($task->id) ? 'checked="checked"' : '') }}>
					<span class="slider round"></span>
				</label>
			</td>
			<td><a href="{{ $data['url_pattern'] }}/edit/{{ $task->id }}"><span class="glyphicon glyphicon-pencil"></span></a>
				@if (in_array($logged_in_user->permission_flag, array("Administrator", "Manager")))
					@if ($task->is_deleted)
				| <a href="{{ $data['url_pattern'] }}/recover/{{ $task->id }}"><span class="fa fa-recycle w3-text-green"></span></a>
					@else
				| <a href="{{ $data['url_pattern'] }}/delete/{{ $task->id }}"><span class="fa fa-trash w3-text-red"></span></a>
					@endif
				@endif
			</td>
		</tr>
		@endforeach

		<tfoot>
		<tr>
			<td colspan="5">
				<div class="w3-center">
					<button type="submit" class="w3-button w3-brown w3-xlarge">　　<span class="fa fa-pencil"></span> 登録　　</button>
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
