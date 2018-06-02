@include('_include.admin.header',
	[
		'id'						=> 'master_price',
		'datetimepicker'			=> true,
	]
)

<div class="w3-row">
	<h1>Price</h1>
	<br>
</div>

<div class="w3-row">
	<a href="{{ $data['url_pattern'] }}" class="w3-button w3-brown"><span class="fas fa-list-ul"></span></a>&nbsp;
	<a href="{{ $data['url_pattern'] }}/add" class="w3-button w3-brown"><span class="fas fa-plus"></span></a>
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
			<th><button type="button" name="btnCopy" value="name"><i class="fas fa-copy"></i></button></th>
			<td>
				{!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'Title', 'required'=>'required']) !!}
			</td>
		</tr>

		<tr>
			<th>{!! Form::label('url', 'url') !!}</th>
			<th><button type="button" name="btnCopy" value="url"><i class="fas fa-copy"></i></button></th>
			<td>
				{!! Form::url('url', NULL, ['class'=>'form-control']) !!}
			</td>
		</tr>

		<tr>
			<th>{!! Form::label('description', 'description') !!}</th>
			<th><button type="button" name="btnCopy" value="description"><i class="fas fa-copy"></i></button></th>
			<td>
				{!! Form::textarea('description', NULL, ['class'=>'form-control']) !!}
			</td>
		</tr>

		<tfoot>
		<tr>
			<td colspan="3">
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

@include('_include.master.footer', [
	'js'					=>'cashflow',
	'datetimepicker'			=> true,
])
