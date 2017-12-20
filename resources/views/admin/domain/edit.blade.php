@include('_include.admin_header',
	[
		'id'				=> 'domain_list',
	]
)

<div class="w3-row">
	<h1>ドメイン</h1>
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

	<table class="timesheet_table w3-table-all w3-striped w3-bordered">
		<tr>
			<th>{!! Form::label('name', 'タスク名') !!}</th>
			<td>
				{!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'タスク名', 'required'=>'required']) !!}
			</td>
		</tr>
{{--
		@if(isset($model->id))
		<tr>
			<th>{!! Form::label('user_id', '自分のタスク') !!}</th>
			<td>
				<label class="switch">
					{{ Form::checkbox('user_id', NULL, NULL, ['id' => 'user_id']) }}
					<span class="slider round"></span>
				</label>
			</td>
		</tr>
		@endif
	--}}

		<tr>
			<th>{!! Form::label('url', 'url') !!}</th>
			<td>
				{!! Form::input('url', 'url', NULL, ['class'=>'form-control', 'placeholder'=>'http(s)://']) !!}
			</td>
		</tr>

		<tr>
			<th>{!! Form::label('repository_url', 'repository_url') !!}</th>
			<td>
				{!! Form::input('url', 'repository_url', NULL, ['class'=>'form-control', 'placeholder'=>'http(s)://']) !!}
			</td>
		</tr>

		<tr>
			<th>{!! Form::label('description', '詳細情報') !!}</th>
			<td>
				{!! Form::textarea('description', NULL, ['class'=>'form-control', 'placeholder'=>'詳細']) !!}
			</td>
		</tr>

		<tr>
			<th>{!! Form::label('ssh_description', 'SSH情報') !!}</th>
			<td>
				{!! Form::textarea('ssh_description', NULL, ['class'=>'form-control', 'placeholder'=>'詳細']) !!}
			</td>
		</tr>

		<tr>
			<th>{!! Form::label('db_description', 'DB情報') !!}</th>
			<td>
				{!! Form::textarea('db_description', NULL, ['class'=>'form-control', 'placeholder'=>'詳細']) !!}
			</td>
		</tr>

		<tr>
			<th>{!! Form::label('development_flag', '環境') !!}</th>
			<td>
				{!! Form::select('development_flag', ['0'=>'本番', '1'=>'ステージング', '2'=>'開発', ], NULL, ['class'=>'form-control']) !!}
			</td>
		</tr>

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
