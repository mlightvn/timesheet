@include('_include.user_header',
	[
		'id'				=> 'login',
	]
)

<div class="w3-row">
	<h1 class="w3-center">{{ __('message.login') }}</h1>
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
	{!! Form::model($model, ['url' => URL::to('login', array(), true)]) !!}

	<table class="table table-bordered">
		<tr>
			<td>email</td>
			<td>{!! Form::email("email", NULL, ["class"=>"w3-col s6 m6 l6 form-control", "placeholder"=>"user@coxanh.net", "required"=>"required"]) !!}</td>
		</tr>
		<tr>
			<td>{{ __('message.password') }}</td>
			<td><input type="password" name="password" class="w3-col s6 m6 l6 form-control" placeholder="password" required="required"></td>
		</tr>
		<tr>
			<td></td>
			<td>
				<input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}> <label for="remember">Remember Me</label>
				<br>
				<a href="password/reset">Forgot password?</a>
			</td>
		</tr>

		<tr>
			<td colspan="2"><div class="w3-center"><button type="submit" class="w3-button w3-brown w3-xlarge">　　<span class="fas fa-sign-in-alt"></span>&nbsp;&nbsp;{{ __('message.login') }}　　</button></div></td>
		</tr>
	</table>
	{!! Form::close() !!}
	<br>
</div>

@include('_include.user_footer')
