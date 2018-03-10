@include('_include.user_header',
	[
		'id'				=> 'login',
	]
)

<div class="w3-row">
	<h1 class="w3-center">ログイン</h1>
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
	{{-- csrf_field() --}}

	<table class="w3-table w3-bordered">
		<tr>
			<td>email</td>
			<td><input type="email" name="email" class="w3-col s6 m6 l6" placeholder="user@coxanh.net"></td>
		</tr>
		<tr>
			<td>パスワード</td>
			<td><input type="password" name="password" class="w3-col s6 m6 l6" placeholder="password"></td>
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
			<td colspan="2"><div class="w3-center"><button type="submit" class="w3-button w3-brown w3-xlarge">　　<span class="fas fa-sign-in-alt"></span>&nbsp;&nbsp;ログイン　　</button></div></td>
		</tr>
	</table>
	{!! Form::close() !!}
	<br>
</div>

@include('_include.user_footer')
