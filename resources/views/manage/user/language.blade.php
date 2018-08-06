@include('_include.admin_header',
	[
		'id'				=> 'user',
	]
)

<div class="w3-row">
	<h1>{{__('message.language.language_setting')}}</h1>
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
						<a class="nav-link" href="{{ action('Manage\UserController@edit', ['user_id' => $model->id]) }}">{{__('message.user.info')}}</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{ action('Manage\UserController@editLoginInfo', ['user_id' => $model->id]) }}">{{__('message.login_info')}}</a>
					</li>
					<li class="nav-item">
						<a class="nav-link active" href="{{ action('Manage\UserController@language', ['user_id' => $model->id]) }}"><i class="fas fa-language"></i> {{__('message.language.language')}}</a>
					</li>
				</ul>

				<table class="timesheet_table w3-table border shadow">
					<tr>
						<th>{{__('message.language.language')}}</th>
						<td>
							<div class="custom-control custom-radio">
								<input type="radio" id="language_en" name="language" class="custom-control-input" value="en" {{(($logged_in_user->language == 'en') ? 'checked="checked"' : '')}}>
								<label for="language_en">English</label>
								<input type="radio" id="language_ja" name="language" class="custom-control-input" value="ja" {{(($logged_in_user->language == 'ja') ? 'checked="checked"' : '')}}>
								<label for="language_ja">日本語</label>
{{--
								<input type="radio" id="language_vi" name="language" class="custom-control-input" value="vi">
								<label for="language_vi">Tiếng Việt</label>
--}}

							</div>
						</td>
					</tr>

					<tfoot>
					<tr>
						<td></td>
						<td>
							<div>
								<button type="submit" class="btn w3-brown w3-xlarge">　　<span class="fas fa-cloud-upload-alt"></span>　{{__('message.register')}}　　</button>
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
