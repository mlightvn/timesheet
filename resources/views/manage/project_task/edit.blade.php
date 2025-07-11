@include('_include.admin_header',
	[
		'id'				=> 'manage_project_task',
	]
)

<div class="w3-row">
	<h1>{{__('screen.task.task')}}</h1>
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

	<table class="w3-table-all w3-striped w3-bordered">
		<tr>
			<th>{!! Form::label('project_id', __('screen.project.project')) !!}</th>
			<td>
				<select name="project_id" id="project_id" class="form-control" placeholder='{{__('screen.project.project')}}' required='required'>
					@foreach($data["projectList"] as $project_id => $project)
					<option value="{{ $project->id }}" class="{{ ($project->is_deleted) ? 'w3-gray' : '' }}" {{ ($project->id == $model->project_id) ? 'selected="selected"' : '' }}>{{ $project->name }}</option>
					@endforeach
				</select>
			</td>
		</tr>

		<tr>
			<th>{!! Form::label('name', __('screen.task.task')) !!}</th>
			<td>
				{!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>__('screen.task.task'), 'required'=>'required']) !!}
			</td>
		</tr>

		<tr>
			<th>{!! Form::label('description', __('message.detail')) !!}</th>
			<td>
				{!! Form::text('description', null, ['class'=>'form-control', 'placeholder'=>__('message.detail')]) !!}
			</td>
		</tr>

		<tr>
			<th>{!! Form::label('user_id', __('screen.task.my_task')) !!}</th>
			<td>
				<label class="switch">
					{{ Form::checkbox('user_id', NULL, NULL, ['id' => 'user_id']) }}
					<span class="slider round"></span>
				</label>
			</td>
		</tr>

		@if(in_array($logged_in_user->role, array("Owner", "Manager")))
		<tr>
			<th>{!! Form::label('excel_flag', __('message.excel_output_flag')) !!}</th>
			<td>
				<label class="switch">
					{{ Form::checkbox('excel_flag', NULL, NULL, ['id' => 'excel_flag']) }}
					<span class="slider round"></span>
				</label>
			</td>
		</tr>
		@endif

		<tfoot>
		<tr>
			<td colspan="2">
				<div class="w3-center">
					<button type="submit" class="w3-button w3-brown w3-xlarge">　　<span class="fas fa-cloud-upload-alt"></span>　{{__('message.register')}}　　</button>
				</div>
			</td>
		</tr>
		</tfoot>
	</table>
	<br>
	{!! Form::close() !!}
</div>

@include('_include.admin_footer')
