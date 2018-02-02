@include('_include.admin_header',
	[
		'id'				=> 'dayoff_application_form',
		'datetimepicker'	=> true,
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
	{!! Form::model($model, ['ng-app'=>'']) !!}
	{!! Form::hidden('id') !!}
	{!! Form::hidden('status') !!}

	@if(isset($message) || session("message"))
		@include('_include.alert_message', ["message" => (isset($message) ? $message : session("message"))])
	@endif

	<table class="timesheet_table w3-table-all w3-striped w3-bordered">
		<tr>
			<th>{!! Form::label('application-template', 'Template') !!}</th>
			<th><button type="button" name="btnCopy" value="name"><i class="fa fa-copy"></i></button></th>
			<td>
				{!! Form::select('application-template', $data['template_list'], null, ['class'=>'form-control', 'required'=>'required']) !!}
			</td>
		</tr>

		<tr>
			<th>{!! Form::label('name', 'タイトル') !!} <span class="w3-text-red">※</span></th>
			<th><button type="button" name="btnCopy" value="name"><i class="fa fa-copy"></i></button></th>
			<td>
				{!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'タイトル', 'required'=>'required']) !!}
			</td>
		</tr>

		<tr>
			<th>{!! Form::label('description', '詳細情報') !!}</th>
			<th><button type="button" name="btnCopy" value="description"><i class="fa fa-copy"></i></button></th>
			<td>
				{!! Form::textarea('description', NULL, ['class'=>'form-control', 'placeholder'=>'詳細情報']) !!}
			</td>
		</tr>

		<tr>
			<th>{!! Form::label('applied_user_id', 'Applied User') !!}</th>
			<th><button type="button" name="btnCopy" value="applied_user_id"><i class="fa fa-copy"></i></button></th>
			<td>
				{!! $model['applied_user_name'] !!}
				{!! Form::hidden('applied_user_id') !!}
			</td>
		</tr>

		<tr>
			<th>{!! Form::label('datetime_from', 'From Date time') !!}</th>
			<th><button type="button" name="btnCopy" value="datetime_from"><i class="fa fa-copy"></i></button></th>
			<td>
				{!! Form::text('datetime_from', null, ['class'=>'form-control', 'placeholder'=>'YYYY-MM-DD HH:mm', 'datetimepicker'=>'datetimepicker']) !!}
			</td>
		</tr>

		<tr>
			<th>{!! Form::label('datetime_to', 'To Date time') !!}</th>
			<th><button type="button" name="btnCopy" value="datetime_to"><i class="fa fa-copy"></i></button></th>
			<td>
				{!! Form::text('datetime_to', null, ['class'=>'form-control', 'placeholder'=>'YYYY-MM-DD HH:mm', 'datetimepicker'=>'datetimepicker']) !!}
			</td>
		</tr>

{{--
		<tr>
			<th>{!! Form::label('approved_user_id', 'Approver') !!}</th>
			<th><button type="button" name="btnCopy" value="approved_user_id"><i class="fa fa-copy"></i></button></th>
			<td>
				{!! Form::text('approved_user_id', null, ['class'=>'form-control', 'placeholder'=>'Approver']) !!}
			</td>
		</tr>

		<tr>
			<th>{!! Form::label('status', '状態') !!}</th>
			<th><button type="button" name="btnCopy" value="status"><i class="fa fa-copy"></i></button></th>
			<td>
				{!! Form::select('status', ['0'=>'Applied', '1'=>'Approved', '2'=>'Dismissed', ], NULL, ['class'=>'form-control']) !!}
			</td>
		</tr>
--}}

		<tfoot>
		<tr>
			<td colspan="3">
				<div class="w3-center">
					<button type="submit" class="w3-button w3-brown w3-xlarge">　　<span class="fa fa-pencil"></span>　登録　　</button>
				</div>
			</td>
		</tr>
		</tfoot>
	</table>
	<br>
	{!! Form::close() !!}
</div>

@include('_include.admin_footer', [
	'id'			=>'dayoff_application_form',
	'js'			=>'dayoff/application_form',
	'datetimepicker'	=> true,
])
