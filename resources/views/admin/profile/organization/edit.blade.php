@include('_include.admin_header',
	[
		'id'				=> 'admin_profile_organization',
	]
)

<div class="w3-row">
	<h1>企業</h1>
	<br>
</div>

{{--
<div class="w3-row">
	@if(in_array($logged_in_user->role, array("Manager")))
	<a href="{{ $data['url_pattern'] }}" class="w3-button w3-brown"><span class="fas fa-list-ul"></span></a>&nbsp;
	@endif
	<a href="{{ $data['url_pattern'] }}/add" class="w3-button w3-brown"><span class="fas fa-plus"></span></a>
	<br><br>
</div>
	--}}

<div class="w3-row">
	{!! Form::model($model, ['ng-app'=>'', 'ng-init'=>"website='" . $model->website . "'"]) !!}
	{!! Form::hidden('id') !!}

	@if(isset($message) || session("message"))
		@include('_include.alert_message', ["message" => (isset($message) ? $message : session("message"))])
	@endif

	<table class="timesheet_table w3-table w3-bordered">
		<tr>
			<th>{!! Form::label('name', '企業名※') !!}</th>
			<td>
				{!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'企業名', 'required'=>'required']) !!}
			</td>
		</tr>
		<tr>
			<th>{!! Form::label('established_date', '設立') !!}</th>
			<td>
				{!! Form::text('established_date', null, ['class'=>'form-control', 'placeholder'=>'設立']) !!}
			</td>
		</tr>
		<tr>
			<th>{!! Form::label('ceo', '代表取締役社長') !!}</th>
			<td>
				{!! Form::text('ceo', null, ['class'=>'form-control', 'placeholder'=>'代表取締役社長']) !!}
			</td>
		</tr>
		<tr>
			<th>{!! Form::label('website', 'Website') !!}</th>
			<td>
				{!! Form::input('url', 'website', null, ['class'=>'form-control', 'placeholder'=>'Website', 'ng-model'=>'website']) !!}
				<a href="@{{website}}" target="_blank">@{{website}}</a>
			</td>
		</tr>
		<tr>
			<th>{!! Form::label('capital', '資本金') !!}</th>
			<td>
				{!! Form::text('capital', null, ['class'=>'form-control', 'placeholder'=>'資本金']) !!}
			</td>
		</tr>
		<tr>
			<th>{!! Form::label('size', '従業員') !!}</th>
			<td>
				{!! Form::text('size', null, ['class'=>'form-control', 'placeholder'=>'従業員']) !!}
			</td>
		</tr>

		<tr>
			<th>{!! Form::label('description', '詳細') !!}</th>
			<td>
				{!! Form::textarea('description', null, ['class'=>'form-control', 'placeholder'=>'詳細']) !!}
			</td>
		</tr>

{{--
		@if(in_array($logged_in_user->role, array("Manager")))
		@endif
	--}}

		<tfoot>
		<tr>
			<td colspan="2">
				<div class="w3-center">
					<button type="submit" class="w3-button w3-brown w3-xlarge">　　<span class="fas fa-pencil-alt"></span>　{{__('message.register')}}　　</button>
				</div>
			</td>
		</tr>
		</tfoot>
	</table>
	<br>
	{!! Form::close() !!}
</div>

@include('_include.admin_footer')
