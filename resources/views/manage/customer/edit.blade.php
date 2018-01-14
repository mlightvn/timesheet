@include('_include.admin_header',
	[
		'id'				=> 'manager_customer',
	]
)

<div class="w3-row">
	<h1>顧客</h1>
	<br>
</div>

<div class="w3-row">
	<a href="{{ $data['url_pattern'] }}" class="w3-button w3-brown"><span class="glyphicon glyphicon-list"></span></a>&nbsp;
	@if(in_array($logged_in_user->permission_flag, array("Administrator", "Manager")))
	<a href="{{ $data['url_pattern'] }}/add" class="w3-button w3-brown"><span class="glyphicon glyphicon-plus"></span></a>
	@endif
	<br><br>
</div>

<div class="w3-row">
	{!! Form::model($model) !!}
	{!! Form::hidden('id') !!}
	{!! Form::hidden('organization_id') !!}

	@if(isset($message) || session("message"))
		@include('_include.alert_message', ["message" => (isset($message) ? $message : session("message"))])
	@endif

	<table class="timesheet_table w3-table w3-bordered">
		<tr class="w3-xlarge">
			<th colspan="2">個人情報</th>
		</tr>
		<tr>
			<th>{!! Form::label('email', 'email※') !!}</th>
			<td>
				{!! Form::text('email', null, ['class'=>'form-control', 'placeholder'=>'email', 'required'=>'required']) !!}
			</td>
		</tr>

		<tr>
			<th>{!! Form::label('name', '名前※') !!}</th>
			<td>
				{!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'名前', 'required'=>'required']) !!}
			</td>
		</tr>

		<tr>
			<th>性別</th>
			<td>
				{!! Form::radio('gender', '0', null, ['class'=>'', 'id'=>'gender_male']) !!}&nbsp;{!! Form::label('gender_male', '男性') !!}
				&nbsp;&nbsp;&nbsp;&nbsp;
				{!! Form::radio('gender', '1', null, ['class'=>'', 'id'=>'gender_female']) !!}&nbsp;{!! Form::label('gender_female', '女性') !!}
			</td>
		</tr>

		<tr>
			<th>{!! Form::label('birthday', '生年月日') !!}</th>
			<td>
				{!! Form::text('birthday', null, ['class'=>'form-control', 'placeholder'=>'生年月日']) !!}
			</td>
		</tr>

		<tr>
			<th>{!! Form::label('phone', '携帯・電話番号') !!}</th>
			<td>
				{!! Form::text('phone', null, ['class'=>'form-control', 'placeholder'=>'携帯・電話番号']) !!}
			</td>
		</tr>


		<tfoot>
		<tr>
			<td colspan="2">
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

@include('_include.admin_footer')
