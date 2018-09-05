<div class="w3-bar w3-brown w3-border">
	<a href="/dashboard" class="w3-bar-item w3-button w3-hover-black {{ (isset($id) && ($id == 'home')) ? 'w3-gray' : ''}}"><span class="fas fa-clock"></span> {{ __('message.APP_NAME') }}</a>

	@if(isset($logged_in_user))
		<div class="w3-dropdown-hover w3-brown">
			<button class="w3-button w3-brown w3-hover-black"><span class="fas fa-file-powerpoint"></span> {{ __('message.menu.report.report') }} <span class="fas fa-caret-down"></span></button>
			<div class="w3-dropdown-content w3-bar-block w3-card-4">
				<a href="/report/time" class="w3-bar-item w3-button w3-hover-black {{ ($id == 'report_time') ? 'w3-gray' : ''}}">{{ __('message.menu.report.input_time_screen') }}</a>
				<a href="/report/day" class="w3-bar-item w3-button w3-hover-black {{ ($id == 'report_day') ? 'w3-gray' : ''}}">{{ __('message.menu.report.summary_by_day') }}</a>
				<a href="/report/month" class="w3-bar-item w3-button w3-hover-black {{ ($id == 'report_month') ? 'w3-gray' : ''}}">{{ __('message.menu.report.summary_by_month') }}</a>
				<a href="/report/project" class="w3-bar-item w3-button w3-hover-black {{ ($id == 'report_project') ? 'w3-gray' : ''}}">{{ __('message.menu.report.summary_by_project') }}</a>
				<a href="/report/department" class="w3-bar-item w3-button w3-hover-black {{ ($id == 'report_department') ? 'w3-gray' : ''}}">{{ __('message.menu.report.summary_by_department') }}</a>
			</div>
		</div>

{{--
		<div class="w3-dropdown-hover w3-brown">
			<button class="w3-button w3-brown w3-hover-black"><span class="fas fa-file-powerpoint"></span> Work time <span class="fas fa-caret-down"></span></button>
			<div class="w3-dropdown-content w3-bar-block w3-card-4">
				<a href="/work-time/month" class="w3-bar-item w3-button w3-hover-black {{ ($id == 'work_time_month') ? 'w3-gray' : ''}}">Month</a>
			</div>
		</div>
--}}

		<div class="w3-dropdown-hover w3-brown">
			<button class="w3-button w3-brown w3-hover-black"><span class="fas fa-calendar"></span> {{ __('message.menu.day_off.day_off') }} <span class="fas fa-caret-down"></span></button>
			<div class="w3-dropdown-content w3-bar-block w3-card-4">
				<a href="/dayoff/application-form" class="w3-bar-item w3-button w3-hover-black">{{ __('message.menu.day_off.application_form') }}</a>
				<a href="/report/day" class="w3-bar-item w3-button w3-hover-black">{{ __('message.menu.day_off.applied_history') }}</a>
			</div>
		</div>

{{--
		<a href="/customer" class="w3-bar-item w3-button {{ ($id == 'user_customer') ? 'w3-gray' : ''}}"><i class="fas fa-address-card" aria-hidden="true"></i> {{ __('message.menu.customer.customer') }}</a>

		<a href="/cashflow" class="w3-bar-item w3-button w3-hover-black {{ ($id == 'cashflow_list') ? 'w3-gray' : ''}}"><span class="fas fa-list-ul"></span> Cashflow</a>
--}}
		<a href="/domain" class="w3-bar-item w3-button w3-hover-black {{ ($id == 'domain_list') ? 'w3-gray' : ''}}"><span class="fas fa-list-ul"></span> {{__('screen.domain.domain')}}</a>
		<a href="/bookmark" class="w3-bar-item w3-button w3-hover-black {{ ($id == 'bookmark_list') ? 'w3-gray' : ''}}"><span class="fas fa-list-ul"></span> {{__('screen.bookmark.bookmark')}}</a>

		<div class="w3-dropdown-hover w3-brown">
			<button class="w3-button w3-brown w3-hover-black"><i class="fas fa-cogs"></i> <span class="fas fa-caret-down"></span></button>
			<div class="w3-dropdown-content w3-bar-block w3-card-4">
				<a href="/manage/user" class="w3-bar-item w3-button {{ ($id == 'manage_user') ? 'w3-gray' : ''}}"><span class="fas fa-user"></span> {{ __('message.member') }}</a>

				<a href="/manage/project" class="w3-bar-item w3-button {{ ($id == 'manage_project') ? 'w3-gray' : ''}}"><span class="fas fa-list-ul"></span> {{ __('screen.project.project') }}</a>
				<a href="/manage/project_task" class="w3-bar-item w3-button {{ ($id == 'manage_project_task') ? 'w3-gray' : ''}}"><span class="fas fa-list-ul"></span> {{ __('screen.task.task') }}</a>
				<a href="/manage/department" class="w3-bar-item w3-button {{ ($id == 'manage_department') ? 'w3-gray' : ''}}"><span class="fas fa-list-ul"></span> {{ __('message.department') }}</a>

				<a href="/manage/application-template" class="w3-bar-item w3-button {{ ($id == 'manage-application-template') ? 'w3-gray' : ''}}"><span class="fas fa-list-ul"></span> {{ __('message.application_templates') }}</a>

				<a href="/manage/user/language" class="w3-bar-item w3-button w3-border-top {{ ($id == 'manage-language') ? 'w3-gray' : ''}}"><span class="fas fa-language"></span> {{__('message.language.language')}}</a>
			</div>
		</div>

		@if ($logged_in_user->role == "Master")
		<a href="/master" class="w3-bar-item w3-button w3-red w3-hover-blue light-glow"><span class="fab fa-empire"></span> {{ __('message.master') }}</a>
		@endif

		@if (in_array($logged_in_user->role, array("Owner", 'Manager')))
{{--
		<a href="/promotion" class="w3-bar-item w3-button"><i class="fas fa-gift"></i> {{ __('message.promotion') }}</a>
		<a href="/price" class="w3-bar-item w3-button"><i class="fas fa-dollar-sign"></i> {{ __('message.payment') }}</a>
--}}

		<a href="javascript:void(0);" onclick="donate()" class="w3-btn w3-green"><i class="fas fa-dollar-sign"></i> {{ __('message.payment') }} <span class="glyphicon glyphicon-apple"></span></a>
		@endif

	@endif

{{--
	<a href="javascript:void(0);" onclick="donate()" class="w3-btn w3-green">Donate <span class="glyphicon glyphicon-apple"></span></a>
	--}}

	<div class="w3-right">
		@if(isset($logged_in_user))
		<span class="w3-bar-item">{{ __('message.hello') }}</span>
		<div class="w3-dropdown-hover w3-brown">
			<button class="w3-button w3-brown">
				<div class="chip">
					<img id="profile_picture" name="profile_picture"
						@if($logged_in_user->profile_picture)
							src="/upload/user/{{$logged_in_user->profile_picture}}"
						@else
							src="/common/images/avatar_male.png"
						@endif
						alt="{{$logged_in_user->name}}" width="30px"
					>
					{{ $logged_in_user->name }}
					<span class="fas fa-caret-down"></span>
				</div>
			</button>
			<div class="w3-dropdown-content w3-bar-block w3-card-4">
				@if ($logged_in_user->role == "Master")
				<a href="/master" class="w3-bar-item w3-button w3-hover-black"><span class="fab fa-empire"></span> {{ __('message.master') }}</a>
				@endif

				<a href="/manage/user/edit/{{ $logged_in_user->id }}" class="w3-bar-item w3-button"><span class="fas fa-user"></span> {{ __('message.profile_edit') }}</a>
				<a href="/manage/user/language" class="w3-bar-item w3-button"><span class="fas fa-language"></span> {{__('message.language.language')}}</a>

				<a href="/profile/organization/info" class="w3-bar-item w3-button w3-border-top"><i class="fas fa-building"></i> {{ __('message.organization_info') }}</a>
				@if ( in_array($logged_in_user->role, array("Owner", "Manager")) )
				<a href="/profile/organization/edit" class="w3-bar-item w3-button"><i class="fas fa-building"></i> {{ __('message.organization_edit') }}</a>
				@endif
				<a href="/logout" class="w3-bar-item w3-button w3-border-top"><span class="fas fa-sign-out-alt"></span> {{ __('message.logout') }}</a>
			</div>
		</div>
		@else
		<a href="/login" class="w3-bar-item w3-button w3-hover-black {{ (isset($id) && ($id == 'login')) ? 'w3-gray' : ''}}"><span class="fas fa-sign-in-alt"></span> {{ __('message.login') }}</a>
		<a href="/register" class="w3-bar-item w3-button {{ (isset($id) && ($id == 'register')) ? 'w3-gray' : ''}}"><span class="fas fa-address-card"></span> {{ __('message.register') }}</a>
		@endif
	</div>
</div>
<br>
