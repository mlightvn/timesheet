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
	<a href="{{ $data['url_pattern'] }}" class="w3-button w3-brown"><span class="fas fa-list-ul"></span></a>&nbsp;
	@if(in_array($logged_in_user->role, array("Owner", "Manager")))
	<a href="{{ $data['url_pattern'] }}/add" class="w3-button w3-brown"><span class="fas fa-plus"></span></a>
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

				<table class="timesheet_table w3-table w3-bordered">
					<tr class="w3-xlarge">
						<th colspan="2">{{__('message.login_info')}}</th>
					</tr>
					<tr>
						<th>email</th>
						<td>
							<a href="mailto:{{ $model->email }}">{{ $model->email }}</a>
						</td>
					</tr>
					<tr>
						<th colspan="2"><br></th>
					</tr>
					<tr class="w3-xlarge">
						<th colspan="2">{{__('message.personal_info')}}</th>
					</tr>
					<tr>
						<th>{{__('message.user.name')}}</th>
						<td>
							{{ $model->name }}
						</td>
					</tr>
					@if(in_array($logged_in_user->role, array("Owner", "Manager")))
					<tr>
						<th>{{__('message.flag.manager')}}</th>
						<td>
							{{ $model->role }}
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
						<th>{{__('message.user.gender')}}</th>
						<td>
							{{ ($model->gender == 0) ? __('message.user.male') : __('message.user.female') }}
						</td>
					</tr>

					<tr>
						<th>{{__('message.user.date_of_birth')}}</th>
						<td>
							{{ $model->birthday }}
						</td>
					</tr>

					<tr>
						<th>{{__('message.user.phone_number')}}</th>
						<td>
							{{ $model->tel }}
						</td>
					</tr>

					<tr>
						<th>{{__('message.description')}}</th>
						<td>
							{!! nl2br(e($model->description)) !!}
						</td>
					</tr>

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
