@include('_include.admin_header',
	[
		'id'					=> 'dayoff_application_form',
		'datepicker'			=> true,
	]
)

<div class="w3-row">
	<h1>各種申請</h1>
	<br>
</div>

<div class="w3-row">
	<a href="{{ $data['url_pattern'] }}" class="w3-button w3-brown"><span class="glyphicon glyphicon-list"></span></a>&nbsp;
	<a href="{{ $data['url_pattern'] }}/add" class="w3-button w3-brown"><span class="glyphicon glyphicon-plus"></span></a>
	<br><br>
</div>

<div class="w3-row">
{{--
	@if ($data["view_mode"] == true)
		<form method="POST" action="{{ $data['url_pattern'] . '/' . $model->id }}/approve" accept-charset="UTF-8">
			{{ csrf_field() }}
	@else
	@endif
--}}

	{!! Form::model($model) !!}

	{{ Form::hidden('id', $model->id) }}

	@if(isset($message) || session("message"))
		@include('_include.alert_message')
	@endif

	<table class="timesheet_table w3-table-all w3-striped w3-bordered">
		@if ($data["view_mode"] !== true)
		@if (isset($data['template_list']))
		<tr>
			<th>{!! Form::label('application-template', 'Template') !!}</th>
			@if ($data["view_mode"] !== true)
			<th><button type="button" name="btnCopy" value="name"><i class="fas fa-copy"></i></button></th>
			@endif
			<td>
				{!! Form::select('application-template', $data['template_list'], null, ['class'=>'form-control', 'required'=>'required']) !!}
			</td>
		</tr>
		@endif
		@endif

		<tr>
			<th>{!! Form::label('name', 'タイトル') !!} <span class="w3-text-red">※</span></th>
			@if ($data["view_mode"] !== true)
			<th><button type="button" name="btnCopy" value="name"><i class="fas fa-copy"></i></button></th>
			@endif
			<td>
				@if ($data["view_mode"] == true)
				{{ $model['name'] }}
					<span class="badge {{$model->STATUS_COLOR}}">{{ $model->STATUS_LABEL }}</span>
				@else
					{!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'タイトル', 'required'=>'required']) !!}
				@endif
			</td>
		</tr>

		<tr>
			<th>{!! Form::label('description', '詳細情報') !!}</th>
			@if ($data["view_mode"] !== true)
			<th><button type="button" name="btnCopy" value="description"><i class="fas fa-copy"></i></button></th>
			@endif
			<td>
				@if ($data["view_mode"] == true)
				{!! nl2br(e($model->description)) !!}
				@else
				{!! Form::textarea('description', NULL, ['class'=>'form-control', 'placeholder'=>'詳細情報']) !!}
				@endif
			</td>
		</tr>

		<tr>
			<th>{!! Form::label('applied_user_id', 'Applied User') !!}</th>
			@if ($data["view_mode"] !== true)
			<th><button type="button" name="btnCopy" value="applied_user_id"><i class="fas fa-copy"></i></button></th>
			@endif
			<td>
				{{ $data['applied_user_name'] }}
				{!! Form::hidden('applied_user_id') !!}
			</td>
		</tr>

		<tr>
			<th>{!! Form::label('date_list', '日付') !!} <span class="w3-text-red">※</span></th>
			@if ($data["view_mode"] !== true)
			<th><button type="button" name="btnCopy" value="date_list"><i class="fas fa-copy"></i></button>
			</th>
			@endif
			<td>
				@if ($data["view_mode"] == true)
					{!! nl2br(e($model->date_list)) !!}

{{--
				<table class="timesheet_table w3-table-all w3-striped w3-bordered">
					<thead>
						<tr>
							<th>日付</th>
							<th>却下・同意</th>
						</tr>
					</thead>
					<tbody>
						@foreach($data["date_list"] as $key => $date)
						<tr>
							<td>{{$date["applied_date"]}}</td>
							<td>
								<!-- Rounded switch -->
								<label class="switch">
									<input type="checkbox" id="applied_date[{{$date['applied_date']}}]" name="applied_date[{{$date['applied_date']}}]" value="{{$date['applied_date']}}" {{($date['status'] == 1) ? 'checked' : ''}}>
									<span class="slider round"></span>
								</label>

							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
--}}

				@else
				<div class="w3-row s12 m12 l12">
					<div class="w3-col s12 m6 l4">
						<div id="datepicker" datepicker="datepicker"></div>
					</div>
					<div class="w3-col s12 m6 l8">
						<textarea name="date_list" id="date_list" class="form-control" rows="10" readonly="readonly" maxlength="255"></textarea>
						<br>
						<button type="button" class="w3-button w3-brown" action="clear" value="date_list"><i class="fas fa-times"></i></button>
					</div>
				</div>
				@endif
			</td>
		</tr>

		@if ($data["view_mode"] == true)
		<tr>
			<th>{!! Form::label('status', '状態') !!}</th>
			<td class="{{$model->STATUS_COLOR}}">
				{{ $model['STATUS_LABEL'] }}
			</td>
		</tr>
		@endif

		@if ($model->status == 0)
		<tfoot>
		<tr>
			<td colspan="3">
				<div class="w3-center">
					@if ($data["view_mode"] == true)
						@if ( $logged_in_user->permission_flag == "Manager" || ($logged_in_user->id == $model->applied_user_id))
						<a class="w3-button w3-gray w3-xlarge" href="{{ $data['url_pattern'] }}/{{$model->id}}/reject">　　<span class="fas fa-times"></span>　却下　　</a>
						@endif
						@if ( $logged_in_user->permission_flag == "Manager" )
						<a class="w3-button w3-brown w3-xlarge"href="{{ $data['url_pattern'] }}/{{$model->id}}/approve">　　<span class="fas fa-check"></span>　同意　　</a>
						@endif
					@else
					<button type="submit" class="w3-button w3-brown w3-xlarge">　　<span class="fas fa-pencil-alt"></span>　登録　　</button>
					@endif
				</div>
			</td>
		</tr>
		</tfoot>
		@endif

	</table>
	<br>
	{!! Form::close() !!}
</div>

@include('_include.admin_footer', [
	'id'					=>'dayoff_application_form',
	'js'					=>'dayoff/application_form',
	'datepicker'			=> true,
])
