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
	<a href="{{ $data['url_pattern'] }}" class="w3-button w3-brown"><span class="fas fa-list-ul"></span></a>&nbsp;
	@if(in_array($logged_in_user->role, array("Owner", "Manager")))
	<a href="{{ $data['url_pattern'] }}/add" class="w3-button w3-brown"><span class="fas fa-plus"></span></a>
	@endif
	<br><br>
</div>

<div class="w3-row">
	<div class="container-fluid">
		<div class="row">
			@include('manage.user.include.user_card', [
				'model' 			=>$model,
				'data' 				=>$data,
				'departments' 		=>$data["arrSelectSessions"]["items"],
				'user' 				=>$logged_in_user,
			])
			<div class="col-sm-9">



				{!! Form::model($model) !!}
				{!! Form::hidden('id') !!}
				{!! Form::hidden('organization_id') !!}

				@if(isset($message) || session("message"))
					@include('_include.alert_message', ["message" => (isset($message) ? $message : session("message"))])
				@endif

				<ul class="nav nav-tabs nav-justified">
					<li class="nav-item">
						<a class="nav-link active" href="{{ action('Manage\UserController@edit', ['user_id' => $model->id]) }}">ユーザ情報</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{ action('Manage\UserController@editLoginInfo', ['user_id' => $model->id]) }}">ログイン情報</a>
					</li>
				</ul>

				<table class="timesheet_table w3-table w3-bordered">
					<tr class="w3-xlarge">
						<th colspan="2">個人情報</th>
					</tr>
					<tr>
						<th>{!! Form::label('name', '名前※') !!}</th>
						<td>
							{!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'名前', 'required'=>'required']) !!}
						</td>
					</tr>

					<tr>
						<th>{!! Form::label('role', '管理フラグ') !!}</th>
						<td>
					@if(($model->id != 1) && ($model->organization_id != 1))
						@if($data["allow_change_permission"] == true)
							{!! Form::radio('role', 'Member', true, ['class'=>'', 'id'=>'role[0]']) !!}
							<label for="role[0]" class="radio-inline control-label">Member</label>
							&nbsp;&nbsp;&nbsp;&nbsp;

							{!! Form::radio('role', 'Manager', true, ['class'=>'', 'id'=>'role[1]']) !!}
							<label for="role[1]" class="radio-inline control-label">Manager</label>
							&nbsp;&nbsp;&nbsp;&nbsp;

							@if($logged_in_user->role == "Owner")
							{!! Form::radio('role', 'Owner', true, ['class'=>'', 'id'=>'role[2]']) !!}
							<label for="role[3]" class="radio-inline control-label">Owner</label>
							@endif
						@else
							{{ $model->role }}
						@endif
					@endif
						</td>
					</tr>

					<tr>
						<th>{!! Form::label('session_id', '部署') !!}</th>
						<td>
							{!! Form::select('session_id', $data["arrSelectSessions"]["items"], NULL, ['class'=>'form-control', 'placeholder'=>'▼下記の項目を選択してください。'], $data["arrSelectSessions"]["deletedItemStyles"]) !!}
						</td>
					</tr>

					<tr>
						<th>{!! Form::label('dayoff', 'Dayoff') !!}</th>
						<td>
							@if(in_array($logged_in_user->role, array("Owner", "Manager")))
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
		</div>
	</div>
</div>

@include('_include.admin_footer', [
	'datepicker' 				=> true,
	'js'						=> 'common/datepicker',
])
