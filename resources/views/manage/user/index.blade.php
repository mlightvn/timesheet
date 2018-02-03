@include('_include.admin_header',
	[
		'id'				=> 'user',
	]
)

<div ng-app="myApp" ng-controller="myCtrl">

<div class="w3-row">
	<h1>ユーザー一覧</h1>
</div>

@include('_include.api_search', ['keyword'=>$data["keyword"]])

@if(isset($message) || session("message"))
	@include('_include.alert_message', ["message" => (isset($message) ? $message : session("message")), "alert_type" => (isset($alert_type) ? $alert_type : session("alert_type"))])
@endif

<div class="w3-row">
	<a href="{{ $data['url_pattern'] }}" class="w3-button w3-brown"><span class="glyphicon glyphicon-list"></span></a>&nbsp;
	@if ( in_array($logged_in_user->permission_flag, array("Manager")) )
	<a href="{{ $data['url_pattern'] }}/add" class="w3-button w3-brown"><span class="glyphicon glyphicon-plus"></span></a>
	@endif
	<br><br>

	<input type="hidden" id="data_source_url" value="/api/manage/user">

	<table class="timesheet_table w3-table-all w3-hoverable w3-striped w3-bordered">
		<thead>
		<tr class="w3-brown">
			<th>ID</th>
			@if ( in_array($logged_in_user->permission_flag, array("Administrator")) )
			<th>企業名</th>
			@endif
			<th>ユーザー名</th>
			<th>部署</th>
			<th>email</th>
			@if ( in_array($logged_in_user->permission_flag, array("Manager")) )
			<th>レポート</th>
			@endif
			<th></th>
		</tr>
		</thead>
		<tr class="@{{ model.DELETED_CSS_CLASS }}" ng-repeat="model in model_list">
			<td>@{{ model.id }}</td>
			@if ( in_array($logged_in_user->permission_flag, array("Administrator")) )
			<td>@{{ model.organization_name }}</td>
			@endif
			<td>
			<span ng-if="model.permission_flag == 'Administrator'">
				<span class="fa fa-ambulance w3-text-red"></span> 
			</span>
			<span ng-if="model.permission_flag == 'Manager'">
			<span class="glyphicon glyphicon-king"></span> 
			</span>
			<span ng-if="model.permission_flag == 'Member'">
				<span class="glyphicon glyphicon-pawn"></span> 
			</span>

			&nbsp;

				<span ng-if="model.id == '{{ $logged_in_user->id }}'">
					<a href="{{ $data['url_pattern'] }}/edit/@{{ model.id }}"><span class="glyphicon glyphicon-pencil"></span> @{{ model.name }}</a>
				</span>

				<span ng-if="model.id != '{{ $logged_in_user->id }}'">
					@if ( in_array($logged_in_user->permission_flag, array("Manager")) )
					<span ng-if="model.permission_flag != 'Administrator'">
						<a href="{{ $data['url_pattern'] }}/edit/@{{ model.id }}"><span class="glyphicon glyphicon-pencil"></span> @{{ model.name }}</a>
					</span>
					<span ng-if="model.permission_flag == 'Administrator'">
						@{{ model.name }}
					</span>
					@else
						@{{ model.name }}
					@endif
				</span>


			</td>
			<td>@{{ model.session_name }}</td>
			<td><a href="mailto:@{{ model.email }}"><span class="glyphicon glyphicon-envelope"></span> @{{ model.email }}</a></td>
			@if ( in_array($logged_in_user->permission_flag, array("Manager")) )
			<td><a href="/report/project?user_id=@{{ model.id }}"><span class="fa fa-file-o" aria-hidden="true"></span> プロジェクトのレポート</a></td>
			@endif
			<td>

				<span ng-if="model.id == '{{ $logged_in_user->id }}'">
					<a href="{{ $data['url_pattern'] }}/edit/@{{ model.id }}"><span class="glyphicon glyphicon-pencil"></span></a>
				</span>

				<span ng-if="model.id != '{{ $logged_in_user->id }}'">
					@if ( in_array($logged_in_user->permission_flag, array("Manager")) )
					<span ng-if="model.permission_flag != 'Administrator'">
						<a href="{{ $data['url_pattern'] }}/edit/@{{ model.id }}"><span class="glyphicon glyphicon-pencil"></span></a>
					</span>
					<span ng-if="model.permission_flag == 'Administrator'">
						<span class="glyphicon glyphicon-pencil"></span>
					</span>
					@else
						<span class="glyphicon glyphicon-pencil"></span>
					@endif
				</span>

				@if ( in_array($logged_in_user->permission_flag, array("Manager")) )
					<span ng-if="model.is_deleted == true">
						| <a href="{{ $data['url_pattern'] }}/recover/@{{ model.id }}"><span class="fa fa-recycle w3-text-green"></span></a>
					</span>
					<span ng-if="model.is_deleted == false">
						| <a href="{{ $data['url_pattern'] }}/delete/@{{ model.id }}"><span class="fa fa-trash w3-text-red"></span></a>
					</span>
				@endif
			</td>
		</tr>
	</table>
	<br>

	@include('_include.user_pagination')
	<br>

</div>

</div> {{-- <div ng-app="myApp" ng-controller="myCtrl"> --}}

@include('_include.admin_footer', [
	'js_list'	=> true,
])
