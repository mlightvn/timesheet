@include('_include.master.header',
	[
		'id'				=> 'master_user',
	]
)

<div class="w3-row">
	<h1>ユーザー</h1>
	<br>
</div>

<div class="w3-row">
	<a href="{{ $data['url_pattern'] }}?permission=Owner" class="w3-button w3-brown"><span class="fas fa-list-ul"></span></a>&nbsp;
	<a href="{{ $data['url_pattern'] }}/add" class="w3-button w3-brown"><span class="fas fa-plus"></span></a>
	<br><br>
</div>

<div class="w3-row rakuhin">
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

		@if($model->id != 1)
		<tr>
			<th></th>
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

				{!! Form::radio('permission_flag', 'Owner', true, ['class'=>'', 'id'=>'permission_flag[3]']) !!}
				<label for="permission_flag[3]" class="radio-inline control-label">Owner</label>
				&nbsp;&nbsp;&nbsp;&nbsp;

				{!! Form::radio('permission_flag', 'Master', true, ['class'=>'', 'id'=>'permission_flag[4]']) !!}
				<label for="permission_flag[4]" class="radio-inline control-label">Master</label>
				&nbsp;&nbsp;&nbsp;&nbsp;

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

@include('_include.master.footer')
