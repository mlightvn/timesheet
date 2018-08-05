@include('_include.user_header',
	[
		'id'				=> 'register',
	]
)

<div class="w3-row">
	<h1 class="w3-center">{{ __('message.register_user') }}</h1>
	<br>
</div>

@if(session("csrf_error"))
<div class="w3-row">
	<div class="w3-col s12 m12 l12">
		<div id="divMessage" class="w3-text-red">{{ session("csrf_error") }}</div>
	</div>
	<br><br>
</div>
@endif

<div class="w3-row">
	{!! Form::model($model) !!}

	<table class="w3-table w3-bordered">
		<tr>
			<td>名前</td>
			<td><input type="name" name="name" class="w3-col s6 m6 l6" placeholder="名前"></td>
		</tr>
		<tr>
			<td>email</td>
			<td><input type="email" name="email" class="w3-col s6 m6 l6" placeholder="example@urban-funes.co.jp"></td>
		</tr>
		<tr>
			<td>__('message.password')</td>
			<td><input type="password" name="password" class="w3-col s6 m6 l6" placeholder="{{__('message.password')}}"></td>
		</tr>
		<tr>
			<td></td>
			<td><input type="password" name="confirm_password" class="w3-col s6 m6 l6" placeholder="{{__('message.confirm_password')}}"></td>
		</tr>

		<tr>
			<td colspan="2"><div class="w3-center"><button type="submit" class="w3-button w3-brown w3-xlarge">　　<span class="fas fa-address-card"></span>&nbsp;&nbsp;__('message.register')　　</button></div></td>
		</tr>
	</table>
	{!! Form::close() !!}
	<br>
</div>

@include('_include.user_footer')
