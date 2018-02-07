@include('_include.admin_header',
	[
		'id'					=> 'dayoff_application_form',
		'daterangepicker'		=> true,
	]
)

<div class="w3-row">
	@if ($data["view_mode"] == true)
	<h1>各種申請</h1>
	@else
	<h1>各種申請</h1>
	@endif
	<br>
</div>

<div class="w3-row">
	<a href="{{ $data['url_pattern'] }}" class="w3-button w3-brown"><span class="glyphicon glyphicon-list"></span></a>&nbsp;
	<a href="{{ $data['url_pattern'] }}/add" class="w3-button w3-brown"><span class="glyphicon glyphicon-plus"></span></a>
	<br><br>
</div>

<div class="w3-row">
	{!! Form::model($model, ['ng-app'=>'']) !!}
	{!! Form::hidden('id') !!}

	@if(isset($message) || session("message"))
		@include('_include.alert_message', ["message" => (isset($message) ? $message : session("message"))])
	@endif

	<table class="timesheet_table w3-table-all w3-striped w3-bordered">
		@if ($data["view_mode"] !== true)
		@if (isset($data['template_list']))
		<tr>
			<th>{!! Form::label('application-template', 'Template') !!}</th>
			@if ($data["view_mode"] !== true)
			<th><button type="button" name="btnCopy" value="name"><i class="fa fa-copy"></i></button></th>
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
			<th><button type="button" name="btnCopy" value="name"><i class="fa fa-copy"></i></button></th>
			@endif
			<td>
				@if ($data["view_mode"] == true)
				{{ $model['name'] }}
					@if ($model["status"] == "1")
						<span class="badge w3-green">
					@elseif ($model["status"] == "2")
						<span class="badge w3-gray">
					@else
						<span>
					@endif
					{{ $model['STATUS_LABEL'] }}</span>
				@else
				{!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'タイトル', 'required'=>'required']) !!}
				@endif
			</td>
		</tr>

		<tr>
			<th>{!! Form::label('description', '詳細情報') !!}</th>
			@if ($data["view_mode"] !== true)
			<th><button type="button" name="btnCopy" value="description"><i class="fa fa-copy"></i></button></th>
			@endif
			<td>
				@if ($data["view_mode"] == true)
				{!! nl2br(e($model['description'])) !!}
				@else
				{!! Form::textarea('description', NULL, ['class'=>'form-control', 'placeholder'=>'詳細情報']) !!}
				@endif
			</td>
		</tr>

		<tr>
			<th>{!! Form::label('applied_user_id', 'Applied User') !!}</th>
			@if ($data["view_mode"] !== true)
			<th><button type="button" name="btnCopy" value="applied_user_id"><i class="fa fa-copy"></i></button></th>
			@endif
			<td>
				{{ $data['applied_user_name'] }}
				{!! Form::hidden('applied_user_id') !!}
			</td>
		</tr>

		<tr>
			<th>{!! Form::label('date_range', '日付') !!} <span class="w3-text-red">※</span></th>
			@if ($data["view_mode"] !== true)
			<th><button type="button" name="btnCopy" value="date_range"><i class="fa fa-copy"></i></button>
			</th>
			@endif
			<td>
				@if ($data["view_mode"] == true)
				{{-- $model['date_range'] --}}
				@else
				<input type="text" id="date_range" class="form-control" placeholder="YYYY-MM-DD - YYYY-MM-DD" daterangepicker="daterangepicker" readonly="readonly">
				@endif
			</td>
		</tr>

		@if ($data["view_mode"] == true)
		<tr>
			<th>{!! Form::label('status', '状態') !!}</th>
			<td class="{{ ($model['status'] == '1') ? 'w3-green' : (($model['status'] == '2') ? 'w3-gray' : '') }}">
				{{ $model['STATUS_LABEL'] }}
			</td>
		</tr>
		@endif

{{--
		<tr>
			<th>{!! Form::label('approved_user_id', 'Approver') !!}</th>
			@if ($data["view_mode"] !== true)
			<th><button type="button" name="btnCopy" value="approved_user_id"><i class="fa fa-copy"></i></button></th>
			<td>
				{!! Form::text('approved_user_id', null, ['class'=>'form-control', 'placeholder'=>'Approver']) !!}
			</td>
		</tr>

		<tr>
			<th>{!! Form::label('status', '状態') !!}</th>
			@if ($data["view_mode"] !== true)
			<th><button type="button" name="btnCopy" value="status"><i class="fa fa-copy"></i></button></th>
			@endif
			<td>
				{!! Form::select('status', ['0'=>'Applied', '1'=>'Approved', '2'=>'Rejected', ], NULL, ['class'=>'form-control']) !!}
			</td>
		</tr>
--}}

		@if ($model->status == 0)
		<tfoot>
		<tr>
			<td colspan="3">
				<div class="w3-center">
					@if ($data["view_mode"] == true)
						@if ( $logged_in_user->permission_flag == "Manager" || ($logged_in_user->id == $model->applied_user_id))
						<a href="{{ $data['url_pattern'] }}/{{$model->id}}/reject" class="w3-button w3-gray w3-xlarge">　　<span class="fa fa-close"></span>　却下　　</a>
						@endif
						@if ( $logged_in_user->permission_flag == "Manager" )
						<a href="{{ $data['url_pattern'] }}/{{$model->id}}/approve" class="w3-button w3-brown w3-xlarge">　　<span class="fa fa-check"></span>　同意　　</a>
						@endif
					@else
					<button type="submit" class="w3-button w3-brown w3-xlarge">　　<span class="fa fa-pencil"></span>　登録　　</button>
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
	'daterangepicker'		=> true,
])
