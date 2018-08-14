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
	<a href="{{ $data['url_pattern'] }}" class="w3-button w3-brown"><span class="fas fa-list-ul"></span></a>&nbsp;
	@if($logged_in_user->role != "Member")
	<a href="{{ $data['url_pattern'] }}/add" class="w3-button w3-brown"><span class="fas fa-plus"></span></a>
	@endif
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
			<th>{!! Form::label('name', __('screen.common.title')) !!} <span class="w3-text-red">※</span></th>
			<th><button type="button" name="btnCopy" value="name"><i class="fas fa-copy"></i></button></th>
			<td>
				@if($logged_in_user->role == "Member")
					{!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>__('screen.common.title'), 'readonly'=>'readonly']) !!}
				@else
					{!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>__('screen.common.title'), 'required'=>'required']) !!}
				@endif
			</td>
		</tr>

		<tr>
			<th>{!! Form::label('description', __('screen.common.detail')) !!}</th>
			<th><button type="button" name="btnCopy" value="description"><i class="fas fa-copy"></i></button></th>
			<td>
				@if($logged_in_user->role == "Member")
					{!! Form::textarea('description', NULL, ['class'=>'form-control', 'placeholder'=>__('screen.common.detail'), 'readonly'=>'readonly']) !!}
				@else
					{!! Form::textarea('description', NULL, ['class'=>'form-control', 'placeholder'=>__('screen.common.detail')]) !!}
				@endif
			</td>
		</tr>

		@if($logged_in_user->role != "Member")
		<tfoot>
		<tr>
			<td colspan="3">
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

@include('_include.admin_footer', [
	'id'			=>'manage-application-template',
])
