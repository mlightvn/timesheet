@include('_include.admin_header',
	[
		'id'						=> 'manage_user',
		'datepicker' 				=> true,
	]
)

<div class="w3-row">
	<h1>{{__('message.user.info')}}</h1>
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
				{!! Form::hidden('organization_id') !!}

				@if(isset($message) || session("message"))
					@include('_include.alert_message', ["message" => (isset($message) ? $message : session("message"))])
				@endif

				@if(isset($model) && isset($model->id))
				<ul class="nav nav-tabs nav-justified">
					<li class="nav-item">
						<a class="nav-link" href="{{ action('Manage\UserController@edit', ['user_id' => $model->id]) }}">{{__('message.login_info')}}</a>
					</li>
					<li class="nav-item">
						<a class="nav-link active" href="{{ action('Manage\UserController@editUserInfo', ['user_id' => $model->id]) }}">{{__('message.user.info')}}</a>
					</li>
					@if(in_array($logged_in_user->role, array("Owner", "Manager")) || ($logged_in_user->id == $model->id))
					<li class="nav-item">
						<a class="nav-link" href="{{ action('Manage\UserController@language') }}"><i class="fas fa-language"></i> {{__('message.language.language')}}</a>
					</li>
					@endif
				</ul>
				@endif

				<table class="timesheet_table w3-table w3-bordered">
					<tr>
						<th>{!! Form::label('name', __('message.user.name')) !!} <span class="w3-text-red">※</span></th>
						<td>
							{!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'名前', 'required'=>'required']) !!}
						</td>
					</tr>

					<tr>
						<th>{!! Form::label('role', __('message.flag.manager')) !!}</th>
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
						<th>{!! Form::label('session_id', __('message.department')) !!}</th>
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
						<th>{!! Form::label('gender', __('message.user.gender')) !!}</th>
						<td>
							{!! Form::radio('gender', '0', null, ['class'=>'', 'id'=>'gender_male']) !!}&nbsp;{!! Form::label('gender_male', '男性') !!}
							&nbsp;&nbsp;&nbsp;&nbsp;
							{!! Form::radio('gender', '1', null, ['class'=>'', 'id'=>'gender_female']) !!}&nbsp;{!! Form::label('gender_female', '女性') !!}
						</td>
					</tr>

					<tr>
						<th>{!! Form::label('birthday', __('message.user.date_of_birth')) !!}</th>
						<td>
							{!! Form::text('birthday', null, ['class'=>'form-control', 'placeholder'=>'YYYY-MM-DD', 'datepicker'=>'datepicker']) !!}
						</td>
					</tr>

					<tr>
						<th>{!! Form::label('phone', __('message.user.phone_number')) !!}</th>
						<td>
							{!! Form::input('tel', 'phone', null, ['class'=>'form-control', 'placeholder'=>__('message.user.phone_number')]) !!}
						</td>
					</tr>

					<tr>
						<th>{!! Form::label('description', __('message.description')) !!}</th>
						<td>
							{!! Form::textarea('description', null, ['class'=>'form-control', 'placeholder'=>'詳細', 'rows'=>20]) !!}
						</td>
					</tr>

					@if(in_array($logged_in_user->role, array("Owner", "Manager")) || ($logged_in_user->id == $model->id))
					<tfoot>
					<tr>
						<td colspan="2">
							<div class="w3-center">
								<button type="submit" class="w3-button w3-brown w3-xlarge">　　<span class="fas fa-pencil-alt"></span>　{{__('message.register')}}　　</button>
							</div>
						</td>
					</tr>
					</tfoot>
					@endif
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
