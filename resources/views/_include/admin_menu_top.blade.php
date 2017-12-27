<div class="w3-bar w3-brown w3-border">
	<a href="/admin" class="w3-bar-item w3-button w3-hover-black {{ (isset($id) && ($id == 'home')) ? 'w3-gray' : ''}}"><span class="glyphicon glyphicon-time"></span> {{ env("APP_NAME") }}</a>

	@if(isset($logged_in_user))
	<div class="w3-dropdown-hover w3-brown">
		<button class="w3-button w3-brown w3-hover-black">レポート <span class="glyphicon glyphicon-triangle-bottom"></span></button>
		<div class="w3-dropdown-content w3-bar-block w3-card-4">
			<a href="/admin/report/time" class="w3-bar-item w3-button w3-hover-black {{ ($id == 'time') ? 'w3-gray' : ''}}">工数入力画面</a>
			<a href="/admin/report/day" class="w3-bar-item w3-button w3-hover-black {{ ($id == 'day') ? 'w3-gray' : ''}}">日別工数集計</a>
			<a href="/admin/report/month" class="w3-bar-item w3-button w3-hover-black {{ ($id == 'month') ? 'w3-gray' : ''}}">月別工数集計</a>
			<a href="/admin/report/task" class="w3-bar-item w3-button w3-hover-black {{ ($id == 'task') ? 'w3-gray' : ''}}">プロジェクト別工数集計</a>
		</div>
	</div>

	<div class="w3-dropdown-hover w3-brown">
		<button class="w3-button w3-brown w3-hover-black">休暇・有給 <span class="glyphicon glyphicon-triangle-bottom"></span></button>
		<div class="w3-dropdown-content w3-bar-block w3-card-4">
			<a href="/admin/dayoff/dayoff" class="w3-bar-item w3-button w3-hover-black {{ ($id == 'time') ? 'w3-gray' : ''}}">休暇・有給</a>
			<a href="/admin/dayoff/application" class="w3-bar-item w3-button w3-hover-black {{ ($id == 'day') ? 'w3-gray' : ''}}">各種申請</a>
			<a href="/admin/dayoff/history" class="w3-bar-item w3-button w3-hover-black {{ ($id == 'month') ? 'w3-gray' : ''}}">休暇履歴</a>
		</div>
	</div>

	<a href="/admin/domain" class="w3-bar-item w3-button w3-hover-black {{ ($id == 'domain_list') ? 'w3-gray' : ''}}"><span class="fa fa-list"></span> ドメイン</a>

	<div class="w3-dropdown-hover w3-brown">
		<button class="w3-button w3-brown w3-hover-black">設定 <span class="glyphicon glyphicon-triangle-bottom"></span></button>
		<div class="w3-dropdown-content w3-bar-block w3-card-4">
			<a href="/admin/user" class="w3-bar-item w3-button {{ ($id == 'user') ? 'w3-gray' : ''}}"><span class="fa fa-user"></span> ユーザー</a>
			<a href="/admin/task" class="w3-bar-item w3-button {{ ($id == 'task_list') ? 'w3-gray' : ''}}"><span class="fa fa-list"></span> プロジェクト</a>
			<a href="/admin/session" class="w3-bar-item w3-button {{ ($id == 'session') ? 'w3-gray' : ''}}"><span class="fa fa-list"></span> 部署</a>
		</div>
	</div>

		@if ( $logged_in_user->permission_flag == "Administrator" )
	<div class="w3-dropdown-hover w3-brown">
		<button class="w3-button w3-brown w3-hover-black">管理 <span class="glyphicon glyphicon-triangle-bottom"></span></button>
		<div class="w3-dropdown-content w3-bar-block w3-card-4">
			<a href="/admin/organization" class="w3-bar-item w3-button {{ ($id == 'organization') ? 'w3-gray' : ''}}"><span class="fa fa-bank"></span> 企業</a>
			<a href="/admin/holiday" class="w3-bar-item w3-button"><span class="fa fa-calendar"></span> 祭日・祝日・休日</a>

			<a href="/bin/pullSourceCode" class="w3-bar-item w3-button" target="_blank"><span class="fa fa-git"></span> プルコード</a>
		</div>
	</div>
		@endif
	@endif

	<div class="w3-right">
		@if(isset($logged_in_user))
		<span class="w3-bar-item">ようこそ</span>
		<div class="w3-dropdown-hover w3-brown">
			<button class="w3-button w3-brown">
				<div class="chip">
					<img src="/common/images/avatar_male.png" alt="{{ $logged_in_user->name }}">
					{{ $logged_in_user->name }}
					<span class="glyphicon glyphicon-triangle-bottom"></span>
				</div>
			</button>
			<div class="w3-dropdown-content w3-bar-block w3-card-4">
				<a href="/admin/user/edit/{{ $logged_in_user->id }}" class="w3-bar-item w3-button"><span class="fa fa-user"></span> プロフィール修正</a>
				<a href="/admin" class="w3-bar-item w3-button">管理画面</a>
				@if ( in_array($logged_in_user->permission_flag, array("Administrator", "Manager")) )
				<a href="/admin/profile/organization/edit" class="w3-bar-item w3-button">企業修正</a>
				@endif
				<a href="/admin/profile/organization/info" class="w3-bar-item w3-button">企業情報</a>
				<a href="/admin/logout" class="w3-bar-item w3-button"><span class="glyphicon glyphicon-log-out"></span> ログアウト</a>
			</div>
		</div>
		@else
		<a href="/admin/login" class="w3-bar-item w3-button w3-hover-black {{ (isset($id) && ($id == 'login')) ? 'w3-gray' : ''}}"><span class="glyphicon glyphicon-log-in"></span> ログイン</a>
		<a href="/admin/register" class="w3-bar-item w3-button {{ (isset($id) && ($id == 'register')) ? 'w3-gray' : ''}}"><span class="glyphicon glyphicon-log-in"></span> 登録</a>
		@endif
	</div>
</div>
<br>
