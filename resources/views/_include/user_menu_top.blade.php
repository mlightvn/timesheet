<div class="w3-bar w3-brown w3-border">
	<a href="/admin" class="w3-bar-item w3-button {{ (isset($id) && ($id == 'home')) ? 'w3-gray' : ''}}"><span class="glyphicon glyphicon-time"></span> {{ env("APP_NAME") }}</a>
	<div class="w3-right">
		@if(isset($logged_in_user))
		<div class="w3-dropdown-hover w3-brown">
			<button class="w3-button w3-brown">
				<div class="chip">
					<img src="/common/images/avatar_male.png" alt="{{ $logged_in_user->name }}">
					{{ $logged_in_user->name }}
							<span class="glyphicon glyphicon-triangle-bottom"></span>
				</div>
			</button>
			<div class="w3-dropdown-content w3-bar-block w3-card-4">
				<a href="/admin/user/edit/{{ $logged_in_user->id }}" class="w3-bar-item w3-button">プロフィール修正</a>
				<a href="/admin" class="w3-bar-item w3-button">管理画面</a>
				<a href="/admin/logout" class="w3-bar-item w3-button">ログアウト</a>
			</div>
		</div>
		@else
		<a href="/admin/login" class="w3-bar-item w3-button {{ (isset($id) && ($id == 'login')) ? 'w3-gray' : ''}}"><span class="glyphicon glyphicon-log-in"></span> Login</a>
		<a href="/admin/register" class="w3-bar-item w3-button {{ (isset($id) && ($id == 'register')) ? 'w3-gray' : ''}}"><span class="glyphicon glyphicon-log-in"></span> Register</a>
		@endif
	</div>
</div>
<br>
