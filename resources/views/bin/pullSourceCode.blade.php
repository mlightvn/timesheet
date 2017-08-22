@include('_include.user_header',
	[
		'id'				=> 'pull_code',
	]
)


<div class="container">
	<h3>Backlogのアカウント</h3>

	<form action="{{ \Request::url() }}" method="post">
		{{ csrf_field() }}
		<div class="input-group">
			<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
			<input id="username" type="text" class="form-control" name="username" placeholder="Username">
		</div>
		<div class="input-group">
			<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
			<input id="password" type="password" class="form-control" name="password" placeholder="Password">
		</div>
		<br>
		<div class="w3-center">
			<button type="submit" class="w3-button w3-brown w3-xlarge">PULL</button>
		</div>
	</form>
	<br>
</div>

@include('_include.user_footer')
