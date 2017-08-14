@include('_include.admin_header',
	[
		'id'				=> 'task_list',
	]
)

<div class="w3-row">
	<h1>タスク一</h1>
	<br>
</div>

<div class="w3-row">
	<a href="/admin/task" class="w3-button w3-brown"><span class="glyphicon glyphicon-list"></span></a>&nbsp;
	<a href="/admin/task/add" class="w3-button w3-brown"><span class="glyphicon glyphicon-plus"></span></a>
	<br><br>
</div>

<div class="w3-row">
	{!! Form::model($model) !!}
	{!! Form::hidden('id') !!}

	@if(isset($message) || session("message"))
		@include('_include.alert_message', ["message" => (isset($message) ? $message : session("message"))])
	@endif

	<table class="timesheet_table w3-table-all w3-striped w3-bordered w3-tiny">
		<tr>
			<th>{!! Form::label('name', 'タスク名') !!}</th>
			<td>
				{!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'タスク名', 'required'=>'required']) !!}
			</td>
		</tr>
		@if(isset($model->id))
		<tr>
			<th></th>
			<td>{{ Form::checkbox('user_id', NULL, NULL, ['id' => 'user_id']) }} {!! Form::label('user_id', '自分のタスクにする') !!}</td>
		</tr>
		@endif
		@if($logged_in_user->session_is_manager == "Manager")
		<tr>
			<th>{!! Form::label('is_off_task', '休憩タスクのフラグ') !!}</th>
			<td>
				<!-- Rounded switch -->
				<label class="switch">
					{!! Form::checkbox('is_off_task', "1", ($model->is_off_task == "1" ? 1 : 0), ['placeholder'=>'休憩タスクのフラグ']) !!}
					<span class="slider round"></span>
				</label>
			</td>
		</tr>
		@endif
		<tfoot>
		<tr>
			<td colspan="2">
				<div class="w3-center">
					<button type="submit" class="w3-button w3-brown w3-xlarge">　　<span class="glyphicon glyphicon-edit"></span>　登録　　</button>
				</div>
			</td>
		</tr>
		</tfoot>
	</table>
	<br>
	{!! Form::close() !!}
</div>

@include('_include.admin_footer')
