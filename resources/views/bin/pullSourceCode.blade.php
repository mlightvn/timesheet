@include('_include.user_header',
	[
		'id'				=> 'pull_code',
	]
)

<div class="container">
	<div class="row">
		<div class="centered">
			<div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
				<h3>Backlog(GIT)のアカウント</h3>

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
			</div>
		</div>
	</div>
	<br>
</div>

@include('_include.user_footer')
