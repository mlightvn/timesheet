@include('_include.admin_header',
	[
		'id'				=> 'manage_user',
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
	<button type="button" class="w3-button w3-brown" ng-click="reset()"><span class="glyphicon glyphicon-list"></span></button>&nbsp;
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
			<th>Dayoff</th>
			<th>レポート</th>
			@endif
			<th></th>
		</tr>
		</thead>
		<tr class="@{{ model.DELETED_CSS_CLASS }}" ng-repeat="model in model_list">
			<td><span ng-bind="model.id"></span></td>
			@if ( in_array($logged_in_user->permission_flag, array("Administrator")) )
			<td><span ng-bind="model.organization_name"></span></td>
			@endif
			<td>
				<span class="@{{ model.ICON_CLASS }}"></span>
				&nbsp;

				<span ng-if="model.id == '{{ $logged_in_user->id }}'">
					<a href="{{ $data['url_pattern'] }}/edit/@{{ model.id }}"><span class="glyphicon glyphicon-pencil"></span> <span ng-bind="model.name"></span></a>
				</span>

				<span ng-if="model.id != '{{ $logged_in_user->id }}'">
					@if ( in_array($logged_in_user->permission_flag, array("Manager")) )
					<span ng-if="model.permission_flag != 'Administrator'">
						<a href="{{ $data['url_pattern'] }}/edit/@{{ model.id }}"><span class="glyphicon glyphicon-pencil"></span> <span ng-bind="model.name"></span></a>
					</span>
					<span ng-if="model.permission_flag == 'Administrator'">
						<span ng-bind="model.name"></span>
					</span>
					@else
						<span ng-bind="model.name"></span>
					@endif
				</span>


			</td>
			<td><span ng-bind="model.session_name"></span></td>
			<td><a href="mailto:@{{ model.email }}"><span class="glyphicon glyphicon-envelope"></span> <span ng-bind="model.email"></span></a></td>
			@if ( in_array($logged_in_user->permission_flag, array("Manager")) )
			<td><span ng-bind="model.dayoff"></span></td>
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
					|
					<span ng-if="model.permission_flag != 'Administrator'">
						<a href="javascript:void(0);" ng-click="delete_recover(model.id, model.DELETE_FLAG_ACTION)"><i class="@{{model.DELETED_RECOVER_ICON}} @{{model.DELETED_RECOVER_COLOR}}"></i></a>
					</span>
					<span ng-if="model.permission_flag == 'Administrator'">
						<i class="@{{model.DELETED_RECOVER_ICON}}"></i>
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
