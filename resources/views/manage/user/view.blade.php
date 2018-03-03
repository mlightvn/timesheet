@include('_include.admin_header',
	[
		'id'						=> 'manage_user',
		'datepicker' 				=> true,
	]
)

<div class="w3-row">
	<h1>ユーザー</h1>
	<br>
</div>

<div class="w3-row">
	<a href="{{ $data['url_pattern'] }}" class="w3-button w3-brown"><span class="glyphicon glyphicon-list"></span></a>&nbsp;
	@if(in_array($logged_in_user->permission_flag, array("Owner", "Administrator", "Manager")))
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
			<th>email</th>
			<td>
				<a href="mailto:{{ $model->email }}">{{ $model->email }}</a>
			</td>
		</tr>
		<tr>
			<th>パスワード</th>
			<td>
				********
		</tr>
		<tr>
			<th colspan="2"><br></th>
		</tr>
		<tr class="w3-xlarge">
			<th colspan="2">個人情報</th>
		</tr>
		<tr>
			<th>名前</th>
			<td>
				{{ $model->name }}
			</td>
		</tr>
		@if(in_array($logged_in_user->permission_flag, array("Owner", "Manager")))
		<tr>
			<th>管理フラグ</th>
			<td>
				{{ $model->permission_flag }}
			</td>
		</tr>

		<tr>
			<th>Department</th>
			<td>
				{{ $model->session_name }}
			</td>
		</tr>
		@endif

		<tr>
			<th>Dayoff</th>
			<td>
				{{ $model->dayoff }}
			</td>
		</tr>

		<tr>
			<th>性別</th>
			<td>
				{{ ($model->gender == 0) ? '男性' : '女性' }}
			</td>
		</tr>

		<tr>
			<th>生年月日</th>
			<td>
				{{ $model->birthday }}
			</td>
		</tr>

		<tr>
			<th>携帯・電話番号</th>
			<td>
				{{ $model->tel }}
			</td>
		</tr>

		<tr>
			<th>詳細</th>
			<td>
				{!! nl2br(e($model->description)) !!}
			</td>
		</tr>

	</table>
	<br>
	{!! Form::close() !!}
</div>

@include('_include.admin_footer', [
	'datepicker' 				=> true,
	'js'						=> 'common/datepicker',
])
