@include('_include.admin_header',
	[
		'id'				=> 'manage-application-template',
	]
)

<div class="w3-row">
	<h1>Application Template</h1>
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
	'id'			=>'manage-application-template',
	'js'			=>'manage/application_template',
])
