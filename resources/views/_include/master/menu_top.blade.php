<div class="w3-bar w3-brown w3-border">
	<a href="/master" class="w3-bar-item w3-button w3-hover-black {{ (isset($id) && ($id == 'home')) ? 'w3-gray' : ''}}"><span class="glyphicon glyphicon-time"></span> {{ env("APP_NAME") }}</a>

	@if(isset($logged_in_user))
	<a href="/master/user?permission=Owner" class="w3-bar-item w3-button {{ ($id == 'master_user') ? 'w3-gray' : ''}}"><span class="fas fa-user"></span> 会員</a>
	<a href="/master/organization" class="w3-bar-item w3-button {{ ($id == 'master_organization') ? 'w3-gray' : ''}}"><span class="fas fa-building"></span> 企業</a>
	<a href="/master/promotion" class="w3-bar-item w3-button {{ ($id == 'master_promotion') ? 'w3-gray' : ''}}"><i class="fas fa-gift"></i> Promotion</a>
	<a href="/master/price" class="w3-bar-item w3-button {{ ($id == 'master_price') ? 'w3-gray' : ''}}"><i class="fas fa-dollar-sign"></i> Price</a>

	<div class="w3-dropdown-hover w3-brown">
		<button class="w3-button w3-brown w3-hover-black light-glow"><i class="fab fa-empire"></i> マスタ <span class="fas fa-caret-down"></span></button>
		<div class="w3-dropdown-content w3-bar-block w3-card-4">
			<a href="/master/holiday" class="w3-bar-item w3-button"><span class="fas fa-calendar"></span> 祭日・祝日・休日</a>

			<a href="/bin/pullSourceCode" class="w3-bar-item w3-button" target="_blank"><span class="fab fa-git"></span> プルコード</a>
		</div>
	</div>

	@endif

	<a href="javascript:void(0);" onclick="donate()" class="w3-btn w3-green">Donate <span class="glyphicon glyphicon-apple"></span></a>

	<div class="w3-right">
		@if(isset($logged_in_user))
		<span class="w3-bar-item">ようこそ</span>
		<div class="w3-dropdown-hover w3-brown">
			<button class="w3-button w3-brown">
				<div class="chip">
					<img data-original="/common/images/avatar_male.png" alt="{{ $logged_in_user->name }}" class="lazy">
					{{ $logged_in_user->name }}
					<span class="fas fa-caret-down"></span>
				</div>
			</button>
			<div class="w3-dropdown-content w3-bar-block w3-card-4">
				<a href="/master/user/edit/{{ $logged_in_user->id }}" class="w3-bar-item w3-button"><span class="fas fa-user"></span> プロフィール修正</a>

				<a href="/logout" class="w3-bar-item w3-button"><span class="fas fa-sign-out"></span> ログアウト</a>
			</div>
		</div>
		@else
		<a href="/login" class="w3-bar-item w3-button w3-hover-black {{ (isset($id) && ($id == 'login')) ? 'w3-gray' : ''}}"><span class="fas fa-sign-in"></span> ログイン</a>
		<a href="/register" class="w3-bar-item w3-button {{ (isset($id) && ($id == 'register')) ? 'w3-gray' : ''}}"><span class="fas fa-sign-in"></span> {{__('message.register')}}</a>
		@endif
	</div>
</div>
<br>
