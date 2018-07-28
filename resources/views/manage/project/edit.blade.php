@include('_include.admin_header',
	[
		'id'				=> 'manage_project',
	]
)

<div class="w3-row">
	<h1>プロジェクト</h1>
	<br>
</div>

<div class="w3-row">
	<a href="{{ $data['url_pattern'] }}" class="w3-button w3-brown"><span class="glyphicon glyphicon-list"></span></a>&nbsp;
	<a href="{{ $data['url_pattern'] }}/add" class="w3-button w3-brown"><span class="glyphicon glyphicon-plus"></span></a>
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
			<th>{!! Form::label('name', 'プロジェクト名') !!}</th>
			<td>
				{!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'プロジェクト名', 'required'=>'required']) !!}
			</td>
		</tr>

		<tr>
			<th>{!! Form::label('description', 'Description') !!}</th>
			<td>
				{!! Form::text('description', null, ['class'=>'form-control', 'placeholder'=>'Description']) !!}
			</td>
		</tr>

		@if(isset($model->id))
		<tr>
			<th>{!! Form::label('user_id', '自分のプロジェクト') !!}</th>
			<td>
				<label class="switch">
					{{ Form::checkbox('user_id', NULL, NULL, ['id' => 'user_id']) }}
					<span class="slider round"></span>
				</label>
			</td>
		</tr>
		@endif
		@if($logged_in_user->permission_flag !== "Member")
		<tr>
			<th>{!! Form::label('is_off', '休憩プロジェクト') !!}</th>
			<td>
				<label class="switch">
					{!! Form::checkbox('is_off', "1", ($model->is_off == "1" ? 1 : 0), ['placeholder'=>'休憩プロジェクト']) !!}
					<span class="slider round"></span>
				</label>
			</td>
		</tr>
		@endif
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
