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
		@if(in_array($logged_in_user->permission_flag, array("Owner", "Manager")))
		<tr>
			<th>{!! Form::label('permission_flag', '管理フラグ') !!}</th>
			<td>
				{!! Form::radio('permission_flag', 'Member', true, ['class'=>'', 'id'=>'permission_flag[0]']) !!}
				<label for="permission_flag[0]" class="radio-inline control-label">Member</label>
				&nbsp;&nbsp;&nbsp;&nbsp;

				{!! Form::radio('permission_flag', 'Manager', true, ['class'=>'', 'id'=>'permission_flag[1]']) !!}
				<label for="permission_flag[1]" class="radio-inline control-label">Manager</label>
				&nbsp;&nbsp;&nbsp;&nbsp;

				{!! Form::radio('permission_flag', 'Administrator', true, ['class'=>'', 'id'=>'permission_flag[2]']) !!}
				<label for="permission_flag[2]" class="radio-inline control-label">Administrator</label>
				&nbsp;&nbsp;&nbsp;&nbsp;

				@if($model->permission_flag == "Owner")
				{!! Form::radio('permission_flag', 'Owner', true, ['class'=>'', 'id'=>'permission_flag[3]']) !!}
				<label for="permission_flag[3]" class="radio-inline control-label">Owner</label>
				@endif
			</td>
		</tr>

		<tr>
			<th>{!! Form::label('session_id', '部署') !!}</th>
			<td>
				{!! Form::select('session_id', $data["arrSelectSessions"]["items"], NULL, ['class'=>'form-control', 'placeholder'=>'▼下記の項目を選択してください。'], $data["arrSelectSessions"]["deletedItemStyles"]) !!}
			</td>
		</tr>
		@endif

		<tr>
			<th>{!! Form::label('dayoff', 'Dayoff') !!}</th>
			<td>
				@if(in_array($logged_in_user->permission_flag, array("Owner", "Administrator", "Manager")))
					{!! Form::input('number', 'dayoff', null, ['class'=>'form-control', 'placeholder'=>'0']) !!}
				@else
					{{ $model->dayoff }}
				@endif
			</td>
		</tr>

		<tr>
			<th>性別</th>
			<td>
				{!! Form::radio('gender', '0', null, ['class'=>'', 'id'=>'gender_male']) !!}&nbsp;{!! Form::label('gender_male', '男性') !!}
				&nbsp;&nbsp;&nbsp;&nbsp;
				{!! Form::radio('gender', '1', null, ['class'=>'', 'id'=>'gender_female']) !!}&nbsp;{!! Form::label('gender_female', '女性') !!}
			</td>
		</tr>

		<tr>
			<th>{!! Form::label('birthday', '生年月日') !!}</th>
			<td>
				{!! Form::text('birthday', null, ['class'=>'form-control', 'placeholder'=>'YYYY-MM-DD', 'datepicker'=>'datepicker']) !!}
			</td>
		</tr>

		<tr>
			<th>{!! Form::label('phone', '携帯・電話番号') !!}</th>
			<td>
				{!! Form::input('tel', 'phone', null, ['class'=>'form-control', 'placeholder'=>'携帯・電話番号']) !!}
			</td>
		</tr>

		<tr>
			<th>{!! Form::label('description', '詳細') !!}</th>
			<td>
				{!! Form::textarea('description', null, ['class'=>'form-control', 'placeholder'=>'詳細', 'rows'=>20]) !!}
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

@include('_include.admin_footer', [
	'datepicker' 				=> true,
	'js'						=> 'common/datepicker',
])
