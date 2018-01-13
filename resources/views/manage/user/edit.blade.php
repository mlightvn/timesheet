@include('_include.admin_header',
	[
		'id'				=> 'user',
	]
)

<div class="w3-row">
	<h1>ユーザー</h1>
	<br>
</div>

<div class="w3-row">
	<a href="{{ $data['url_pattern'] }}" class="w3-button w3-brown"><span class="glyphicon glyphicon-list"></span></a>&nbsp;
	@if(in_array($logged_in_user->permission_flag, array("Administrator", "Manager")))
	<a href="{{ $data['url_pattern'] }}/add" class="w3-button w3-brown"><span class="glyphicon glyphicon-plus"></span></a>
	@endif
	<br><br>
</div>

<div class="w3-row">
	{!! Form::model($model) !!}
	{!! Form::hidden('id') !!}
	{!! Form::hidden('organization_id') !!}

	@if(isset($message) || session("message"))
		@include('_include.alert_message', ["message" => (isset($message) ? $message : session("message"))])
	@endif

	<table class="timesheet_table w3-table w3-bordered">
		<tr class="w3-xlarge">
			<th colspan="2">ログイン情報</th>
		</tr>
		<tr>
			<th>{!! Form::label('email', 'email※') !!}</th>
			<td>
				{!! Form::text('email', null, ['class'=>'form-control', 'placeholder'=>'email', 'required'=>'required']) !!}
			</td>
		</tr>
		<tr>
			<th>{!! Form::label('password', 'パスワード') !!}</th>
			<td>
			@if($model->id)
				{!! Form::password('password', ['placeholder'=>'パスワード', 'min'=>'8', 'max'=>'100', 'class'=>'form-control']) !!}
				<br>
				<label class="w3-text-green">パスワードを入力しない場合は、パスワードが変わらないです。</label>
			@else
				{!! Form::password('password', ['placeholder'=>'パスワード', 'min'=>'8', 'max'=>'100', 'class'=>'form-control', 'required'=>'required']) !!}
			</td>
			@endif
		</tr>
		<tr>
			<th colspan="2"><br></th>
		</tr>
		<tr class="w3-xlarge">
			<th colspan="2">個人情報</th>
		</tr>
		<tr>
			<th>{!! Form::label('name', '名前※') !!}</th>
			<td>
				{!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'名前', 'required'=>'required']) !!}
			</td>
		</tr>
		@if(in_array($logged_in_user->permission_flag, array("Manager")))
		<tr>
			<th>{!! Form::label('permission_flag', '管理フラグ') !!}</th>
			<td>
				<!-- Rounded switch -->
				<label class="switch">
					{!! Form::checkbox('permission_flag', "Manager", ($model->permission_flag == "Manager" ? 1 : 0), ['placeholder'=>'管理フラグ']) !!}
					<span class="slider round"></span>
				</label>
			</td>
		</tr>

		<tr>
			<th>{!! Form::label('session_id', '部署') !!}</th>
			<td>
				{!! Form::select('session_id', $data["arrSelectSessions"]["items"], NULL, ['class'=>'form-control', 'placeholder'=>'▼下記の項目を選択してください。'], $data["arrSelectSessions"]["deletedItemStyles"]) !!}
			</td>
		</tr>
		@endif
		<tfoot>
		<tr>
			<td colspan="2">
				<div class="w3-center">
					<button type="submit" class="w3-button w3-brown w3-xlarge">　　<span class="fa fa-pencil"></span>　登録　　</button>
				</div>
			</td>
		</tr>
		</tfoot>
	</table>
	<br>
	{!! Form::close() !!}
</div>

@include('_include.admin_footer')
