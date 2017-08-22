<div class="w3-bar w3-brown w3-border">
	<a href="/admin" class="w3-bar-item w3-button w3-border-right {{ (isset($id) && ($id == 'home')) ? 'w3-gray' : ''}}"><span class="glyphicon glyphicon-time"></span> {{ env("APP_NAME") }}</a>

	@if(isset($logged_in_user))
	<a href="/admin/report/time" class="w3-bar-item w3-button w3-border-right {{ ($id == 'time') ? 'w3-gray' : ''}}">工数入力画面</a>
	<a href="/admin/report/day" class="w3-bar-item w3-button w3-border-right {{ ($id == 'day') ? 'w3-gray' : ''}}">日別工数集計</a>
	<a href="/admin/report/month" class="w3-bar-item w3-button w3-border-right {{ ($id == 'month') ? 'w3-gray' : ''}}">月別工数集計</a>
	<a href="/admin/report/task" class="w3-bar-item w3-button w3-border-right {{ ($id == 'task') ? 'w3-gray' : ''}}">タスク別工数集計</a>

		<div class="w3-dropdown-hover w3-brown w3-border-right">
			<button class="w3-button w3-brown"><span class="glyphicon glyphicon-cog"></span></button>
			<div class="w3-dropdown-content w3-bar-block w3-card-4">
				<a href="/admin/user" class="w3-bar-item w3-button {{ ($id == 'user') ? 'w3-gray' : ''}}"><span class="glyphicon glyphicon-user"></span> ユーザー</a>
				<a href="/admin/task" class="w3-bar-item w3-button {{ ($id == 'task_list') ? 'w3-gray' : ''}}"><span class="glyphicon glyphicon-list"></span> タスク</a>
				<a href="/admin/session" class="w3-bar-item w3-button {{ ($id == 'session') ? 'w3-gray' : ''}}"><span class="glyphicon glyphicon-list"></span> 部署</a>

				<a href="/admin/holiday" class="w3-bar-item w3-button"><span class="glyphicon glyphicon-calendar"></span> 祭日・祝日・休日</a>

				<a href="/bin/pullSourceCode" class="w3-bar-item w3-button"><span class="fa fa-git"></span> プルコード</a>
			</div>
		</div>
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
				<a href="/admin/user/edit/{{ $logged_in_user->id }}" class="w3-bar-item w3-button"><span class="glyphicon glyphicon-user"></span> プロフィール修正</a>
				<a href="/admin" class="w3-bar-item w3-button">管理画面</a>
				<a href="/admin/logout" class="w3-bar-item w3-button"><span class="glyphicon glyphicon-log-out"></span> ログアウト</a>
			</div>
		</div>
		@else
		<a href="/admin/login" class="w3-bar-item w3-button w3-border-right {{ (isset($id) && ($id == 'login')) ? 'w3-gray' : ''}}"><span class="glyphicon glyphicon-log-in"></span> ログイン</a>
		<a href="/admin/register" class="w3-bar-item w3-button {{ (isset($id) && ($id == 'register')) ? 'w3-gray' : ''}}"><span class="glyphicon glyphicon-log-in"></span> 登録</a>
		@endif
	</div>
</div>
<br>
