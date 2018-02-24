<div class="w3-bar w3-brown w3-border">
	<a href="/" class="w3-bar-item w3-button w3-hover-black {{ (isset($id) && ($id == 'home')) ? 'w3-gray' : ''}}"><span class="glyphicon glyphicon-time"></span> {{ env("APP_NAME") }}</a>

	@if(isset($logged_in_user))
	<div class="w3-dropdown-hover w3-brown">
		<button class="w3-button w3-brown w3-hover-black"><span class="fa fa-file-powerpoint-o"></span> レポート <span class="fa fa-caret-down"></span></button>
		<div class="w3-dropdown-content w3-bar-block w3-card-4">
			<a href="/report/time" class="w3-bar-item w3-button w3-hover-black {{ ($id == 'report_time') ? 'w3-gray' : ''}}">工数入力画面</a>
			<a href="/report/day" class="w3-bar-item w3-button w3-hover-black {{ ($id == 'report_day') ? 'w3-gray' : ''}}">日別工数集計</a>
			<a href="/report/month" class="w3-bar-item w3-button w3-hover-black {{ ($id == 'report_month') ? 'w3-gray' : ''}}">月別工数集計</a>
			<a href="/report/project" class="w3-bar-item w3-button w3-hover-black {{ ($id == 'report_project') ? 'w3-gray' : ''}}">プロジェクト別工数集計</a>
			<a href="/report/session" class="w3-bar-item w3-button w3-hover-black {{ ($id == 'report_session') ? 'w3-gray' : ''}}">部署</a>
		</div>
	</div>

	<div class="w3-dropdown-hover w3-brown">
		<button class="w3-button w3-brown w3-hover-black"><span class="fa fa-calendar"></span> 休暇・有給 <span class="fa fa-caret-down"></span></button>
		<div class="w3-dropdown-content w3-bar-block w3-card-4">
			<a href="/dayoff/application-form" class="w3-bar-item w3-button w3-hover-black">各種申請</a>
			<a href="/report/day" class="w3-bar-item w3-button w3-hover-black">休暇履歴</a>
		</div>
	</div>

	<a href="/user/customer" class="w3-bar-item w3-button {{ ($id == 'manage_customer') ? 'w3-gray' : ''}}"><i class="fa fa-address-card" aria-hidden="true"></i> 顧客</a>

	<a href="/cashflow" class="w3-bar-item w3-button w3-hover-black {{ ($id == 'cashflow_list') ? 'w3-gray' : ''}}"><span class="fa fa-list"></span> Cashflow</a>
	<a href="/domain" class="w3-bar-item w3-button w3-hover-black {{ ($id == 'domain_list') ? 'w3-gray' : ''}}"><span class="fa fa-list"></span> ドメイン</a>

	@if ( $logged_in_user->permission_flag == "Member" )
	<div class="w3-dropdown-hover w3-brown">
		<button class="w3-button w3-brown w3-hover-black"> <span class="fa fa-cog"></span></button>
		<div class="w3-dropdown-content w3-bar-block w3-card-4">
			<a href="/user/user" class="w3-bar-item w3-button {{ ($id == 'manage_user') ? 'w3-gray' : ''}}"><span class="fa fa-user"></span> 会員</a>

			<a href="/user/project" class="w3-bar-item w3-button {{ ($id == 'manage_project') ? 'w3-gray' : ''}}"><span class="fa fa-list"></span> プロジェクト</a>
			<a href="/user/session" class="w3-bar-item w3-button {{ ($id == 'manage_session') ? 'w3-gray' : ''}}"><span class="fa fa-list"></span> 部署</a>

		</div>
	</div>
	@endif

	@if ( in_array($logged_in_user->permission_flag, array("Owner", "Administrator", "Manager")) )
	<div class="w3-dropdown-hover w3-brown">
		<button class="w3-button w3-brown w3-hover-black">設定 <span class="fa fa-caret-down"></span></button>
		<div class="w3-dropdown-content w3-bar-block w3-card-4">
			<a href="/manage/user" class="w3-bar-item w3-button {{ ($id == 'manage_user') ? 'w3-gray' : ''}}"><span class="fa fa-user"></span> 会員</a>

			<a href="/manage/project" class="w3-bar-item w3-button {{ ($id == 'manage_project') ? 'w3-gray' : ''}}"><span class="fa fa-list"></span> プロジェクト</a>
			<a href="/manage/session" class="w3-bar-item w3-button {{ ($id == 'manage_session') ? 'w3-gray' : ''}}"><span class="fa fa-list"></span> 部署</a>

			<a href="/manage/application-template" class="w3-bar-item w3-button {{ ($id == 'manage-application-template') ? 'w3-gray' : ''}}"><span class="fa fa-list"></span> Application Templates</a>
		</div>
	</div>
	@endif

	@if ($logged_in_user->permission_flag == "Master")
	<a href="/master" class="w3-bar-item w3-button w3-hover-black"><span class="fa fa-empire"></span> マスタ</a>
	@endif

	@endif

	<a href="javascript:void(0);" onclick="donate()" class="w3-btn w3-green">Donate <span class="glyphicon glyphicon-apple"></span></a>

	<div class="w3-right">
		@if(isset($logged_in_user))
		<span class="w3-bar-item">ようこそ</span>
		<div class="w3-dropdown-hover w3-brown">
			<button class="w3-button w3-brown">
				<div class="chip">
					<img src="/common/images/avatar_male.png" alt="{{ $logged_in_user->name }}">
					{{ $logged_in_user->name }}
					<span class="fa fa-caret-down"></span>
				</div>
			</button>
			<div class="w3-dropdown-content w3-bar-block w3-card-4">
				@if ($logged_in_user->permission_flag == "Master")
				<a href="/master" class="w3-bar-item w3-button w3-hover-black"><span class="fa fa-empire"></span> マスタ</a>
				@endif

				<a href="/manage/user/edit/{{ $logged_in_user->id }}" class="w3-bar-item w3-button"><span class="fa fa-user"></span> プロフィール修正</a>

{{--
				@if ( $logged_in_user->permission_flag == "Administrator" )
				<a href="/admin" class="w3-bar-item w3-button">管理画面</a>
				@endif
--}}

				@if ( in_array($logged_in_user->permission_flag, array("Administrator", "Manager")) )
				<a href="/profile/organization/edit" class="w3-bar-item w3-button">企業修正</a>
				@endif
				<a href="/profile/organization/info" class="w3-bar-item w3-button">企業情報</a>
				<a href="/logout" class="w3-bar-item w3-button"><span class="glyphicon glyphicon-log-out"></span> ログアウト</a>
			</div>
		</div>
		@else
		<a href="/login" class="w3-bar-item w3-button w3-hover-black {{ (isset($id) && ($id == 'login')) ? 'w3-gray' : ''}}"><span class="glyphicon glyphicon-log-in"></span> ログイン</a>
		<a href="/register" class="w3-bar-item w3-button {{ (isset($id) && ($id == 'register')) ? 'w3-gray' : ''}}"><span class="glyphicon glyphicon-log-in"></span> 登録</a>
		@endif
	</div>
</div>
<br>
