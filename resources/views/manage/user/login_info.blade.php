@include('_include.admin_header',
	[
		'id'				=> 'user',
	]
)

<div class="w3-row">
	<h1>ユーザー・ログイン情報</h1>
	<br>
</div>

<div class="w3-row">
	<a href="/admin/user" class="btn w3-brown"><span class="fas fa-th-list"></span></a>&nbsp;
	@if ( $logged_in_user->session_is_manager == "Manager" )
	<a href="/admin/user/add" class="btn w3-brown"><span class="fas fa-plus"></span></a>
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

				@if(isset($message) || session("message"))
					@include('_include.alert_message', ["message" => (isset($message) ? $message : session("message"))])
				@endif

				<ul class="nav nav-tabs nav-justified">
					<li class="nav-item">
						<a class="nav-link" href="{{ action('Manage\UserController@edit', ['user_id' => $model->id]) }}">ユーザ情報</a>
					</li>
					<li class="nav-item">
						<a class="nav-link active" href="{{ action('Manage\UserController@editLoginInfo', ['user_id' => $model->id]) }}">ログイン情報</a>
					</li>
				</ul>

				<table class="timesheet_table w3-table border shadow">
					<tr>
						<th>{!! Form::label('email', 'email※') !!}</th>
						<td>
							{!! Form::text('email', null, ['class'=>'form-control', 'placeholder'=>'email', 'required'=>'required']) !!}
						</td>
					</tr>
					<tr>
					@if($model->id)
						<th>{!! Form::label('password', 'パスワード') !!}</th>
						<td>
							{!! Form::password('password', ['placeholder'=>'パスワード', 'min'=>'8', 'max'=>'100', 'class'=>'form-control']) !!}
							<br>
							<label class="w3-text-green">パスワードを入力しない場合は、パスワードが変わらないです。</label>
						</td>
					@else
						<th>{!! Form::label('password', 'パスワード※') !!}</th>
						<td>
							{!! Form::password('password', ['placeholder'=>'パスワード', 'min'=>'8', 'max'=>'100', 'class'=>'form-control', 'required'=>'required']) !!}
						</td>
					@endif
					</tr>
					<tfoot>
					<tr>
						<td colspan="2">
							<div class="w3-center">
								<button type="submit" class="btn w3-brown w3-xlarge">　　<span class="fas fa-hdd"></span>　登録　　</button>
							</div>
						</td>
					</tr>
					</tfoot>
				</table>
				{!! Form::close() !!}

			</div>
		</div>
	</div>
	<br>

</div>

@include('_include.admin_footer')
