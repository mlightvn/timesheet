@include('_include.admin_header',
	[
		'id'				=> 'manage_project_task',
	]
)

<div class="w3-row">
	<h1>タスク</h1>
	<br>
</div>

<div class="w3-row">
	<a href="{{ $data['url_pattern'] }}" class="w3-button w3-brown"><span class="fas fa-list-ul"></span></a>&nbsp;
	<a href="{{ $data['url_pattern'] }}/add" class="w3-button w3-brown"><span class="fas fa-plus"></span></a>
	<br><br>
</div>

<div class="w3-row">
	{!! Form::model($model) !!}
	{!! Form::hidden('id') !!}
	{!! Form::hidden('organization_id') !!}

	@if(isset($message) || session("message"))
		@include('_include.alert_message', ["message" => (isset($message) ? $message : session("message"))])
	@endif

	<table class="timesheet_table w3-table-all w3-striped w3-bordered">
		<tr>
			<th>{!! Form::label('project_id', 'プロジェクト') !!}</th>
			<td>
				<select name="project_id" id="project_id" class="form-control" placeholder='稼働プロジェクト' required='required'>
					@foreach($data["projectList"] as $project_id => $project)
					<option value="{{ $project->id }}" class="{{ ($project->is_deleted) ? 'w3-gray' : '' }}" {{ ($project->id == $model->project_id) ? 'selected="selected"' : '' }}>{{ $project->name }}</option>
					@endforeach
				</select>
			</td>
		</tr>

		<tr>
			<th>{!! Form::label('name', 'タスク') !!}</th>
			<td>
				{!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'タスク', 'required'=>'required']) !!}
			</td>
		</tr>

		<tr>
			<th>{!! Form::label('description', '備考') !!}</th>
			<td>
				{!! Form::text('description', null, ['class'=>'form-control', 'placeholder'=>'備考']) !!}
			</td>
		</tr>

		<tfoot>
		<tr>
			<td colspan="2">
				<div class="w3-center">
					<button type="submit" class="w3-button w3-brown w3-xlarge">　　<span class="fas fa-pencil-alt"></span>　登録　　</button>
				</div>
			</td>
		</tr>
		</tfoot>
	</table>
	<br>
	{!! Form::close() !!}
</div>

@include('_include.admin_footer')
