@include('_include.admin_header',
	[
		'id'				=> 'user',
	]
)

<div class="w3-row">
	<h1>{{__('message.login_info')}}</h1>
	<br>
</div>

<div class="w3-row">
	<a href="{{ $data['url_pattern'] }}" class="btn w3-brown"><span class="fas fa-list-ul"></span></a>&nbsp;
	@if(in_array($logged_in_user->role, array("Owner", "Manager")))
	<a href="{{ $data['url_pattern'] }}/add" class="btn w3-brown"><span class="fas fa-plus"></span></a>
	@endif
	<br><br>
</div>

<div class="w3-row">

	<div class="container-fluid">
		<div class="row">
			@if(isset($model) && isset($model->id))
			@include('manage.user.include.user_card', [
				'model' 			=>$model,
				'data' 				=>$data,
				'departments' 		=>$data["arrSelectSessions"]["items"],
				'user' 				=>$logged_in_user,
			])
			<div class="col-sm-9">
			@else
			<div class="col-sm-12">
			@endif

				{!! Form::model($model) !!}
				{!! Form::hidden('id') !!}

				@if(isset($message) || session("message"))
					@include('_include.alert_message', ["message" => (isset($message) ? $message : session("message"))])
				@endif

				@if(isset($model) && isset($model->id))
				<ul class="nav nav-tabs nav-justified">
					<li class="nav-item">
						<a class="nav-link active" href="{{ action('Manage\UserController@edit', ['user_id' => $model->id]) }}">{{__('message.login_info')}}</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{ action('Manage\UserController@editUserInfo', ['user_id' => $model->id]) }}">{{__('message.user.info')}}</a>
					</li>
					@if(in_array($logged_in_user->role, array("Owner", "Manager")) || ($logged_in_user->id == $model->id))
					<li class="nav-item">
						<a class="nav-link" href="{{ action('Manage\UserController@language') }}"><i class="fas fa-language"></i> {{__('message.language.language')}}</a>
					</li>
					@endif
				</ul>
				@endif

				<table class="timesheet_table w3-table border shadow">
					<tr>
						<th>{!! Form::label('email', 'email※') !!}</th>
						<td>
							{!! Form::text('email', null, ['class'=>'form-control', 'placeholder'=>'email', 'required'=>'required']) !!}
						</td>
					</tr>
					<tr>
					@if($model->id)
						<th>{!! Form::label('password', __('message.password')) !!}</th>
						<td>
							{!! Form::password('password', ['placeholder'=>__('message.password'), 'min'=>'8', 'max'=>'100', 'class'=>'form-control']) !!}
							<br>
							<label class="w3-text-green">パスワードを入力しない場合は、パスワードが変わらないです。</label>
						</td>
					@else
						<th>{!! Form::label('password', __('message.password') . '※') !!}</th>
						<td>
							{!! Form::password('password', ['placeholder'=>__('message.password'), 'min'=>'8', 'max'=>'100', 'class'=>'form-control', 'required'=>'required']) !!}
						</td>
					@endif
					</tr>

					@if(in_array($logged_in_user->role, array("Owner", "Manager")) || ($logged_in_user->id == $model->id))
					<tfoot>
					<tr>
						<td colspan="2">
							<div class="w3-center">
								<button type="submit" class="btn w3-brown w3-xlarge">　　<span class="fas fa-hdd"></span>　{{__('message.register')}}　　</button>
							</div>
						</td>
					</tr>
					</tfoot>
					@endif
				</table>
				{!! Form::close() !!}

			</div>
		</div>
	</div>
	<br>

</div>

@include('_include.admin_footer')
