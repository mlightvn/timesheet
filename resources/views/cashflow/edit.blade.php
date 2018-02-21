@include('_include.admin_header',
	[
		'id'						=> 'cashflow_list',
		'datetimepicker'			=> true,
	]
)

<div class="w3-row">
	<h1>Cash Flow</h1>
	<br>
</div>

<div class="w3-row">
	<a href="{{ $data['url_pattern'] }}" class="w3-button w3-brown"><span class="fa fa-list"></span></a>&nbsp;
	<a href="{{ $data['url_pattern'] }}/add" class="w3-button w3-brown"><span class="fa fa-plus"></span></a>
	<br><br>
</div>

<div class="w3-row">

	{!! Form::model($model, ['ng-app'=>'', 'ng-init'=>"url='" . $model->url . "';admin_url='" . $model->admin_url . "';repository_url='" . $model->repository_url . "'"]) !!}
	{!! Form::hidden('id') !!}
	{!! Form::hidden('organization_id') !!}

	@if(isset($message) || session("message"))
		@include('_include.alert_message', ["message" => (isset($message) ? $message : session("message"))])
	@endif

	<table class="timesheet_table w3-table-all w3-striped w3-bordered">
		<tr>
			<th>{!! Form::label('name', 'Title') !!} <span class="w3-text-red">※</span></th>
			<th><button type="button" name="btnCopy" value="name"><i class="fa fa-copy"></i></button></th>
			<td>
				{!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'Title', 'required'=>'required']) !!}
			</td>
		</tr>

		<tr>
			<th>{!! Form::label('in_out_flag', 'Cash out') !!}</th>
			<th><button type="button" name="btnCopy" value="in_out_flag"><i class="fa fa-copy"></i></button></th>
			<td>
				<!-- Rounded switch -->
				<label class="switch">
					{!! Form::checkbox('in_out_flag', NULL, $model->in_out_flag, ['placeholder'=>'Cash out']) !!}
					<span class="slider round"></span>
				</label>

			</td>
		</tr>

		<tr>
			<th>{!! Form::label('amount', 'amount') !!}</th>
			<th><button type="button" name="btnCopy" value="amount"><i class="fa fa-copy"></i></button></th>
			<td>
				{{--
				https://developer.mozilla.org/ja/docs/Web/HTML/Element/Input/number
				--}}
				{!! Form::number('amount', NULL, ['class'=>'form-control', 'step'=>'any']) !!}
			</td>
		</tr>

		<tr>
			<th>{!! Form::label('datetime', 'datetime') !!}</th>
			<th><button type="button" name="btnCopy" value="datetime"><i class="fa fa-copy"></i></button></th>
			<td>
				{!! Form::text('datetime', NULL, ['class'=>'form-control', 'datetimepicker'=>'datetimepicker', 'readonly'=>'readonly']) !!}
			</td>
		</tr>

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
	'js'					=>'cashflow',
	'datetimepicker'			=> true,
])
