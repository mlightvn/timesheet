@include('_include.admin_header',
	[
		'id'				=> 'master_user',
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
	<a href="{{ $data['url_pattern'] }}/add" class="w3-button w3-brown"><span class="glyphicon glyphicon-plus"></span></a>
	<br><br>

	@if(isset($data['permission_flag']))
	<input type="hidden" id="permission_flag" name="permission_flag" value="{{ $data['permission_flag'] }}">
	<input type="hidden" id="data_source_url" value="/api{{ $data['url_pattern'] }}?permission={{ $data['permission_flag'] }}">
	@else
	<input type="hidden" id="permission_flag" name="permission_flag" value="">
	<input type="hidden" id="data_source_url" value="/api{{ $data['url_pattern'] }}">
	@endif

	<div class="w3-bar w3-light-gray">
		<a class="w3-bar-item w3-button" href="{{ $data['url_pattern'] }}?permission=master">Master</a>
		<a class="w3-bar-item w3-button" href="{{ $data['url_pattern'] }}?permission=other">Other users</a>
	</div>

	<table class="timesheet_table w3-table-all w3-hoverable w3-striped w3-bordered">
		<thead>
		<tr class="w3-brown">
			<th>ID</th>
			<th>企業名</th>
			<th>ユーザー名</th>
			<th>部署</th>
			<th>email</th>
			<th>Dayoff</th>
			<th>レポート</th>
			<th></th>
		</tr>
		</thead>
		<tr class="@{{ model.DELETED_CSS_CLASS }}" ng-repeat="model in model_list">
			<td><span ng-bind="model.id"></span></td>
			<td><span ng-bind="model.organization_name"></span></td>
			<td>
				<span class="@{{ model.ICON_CLASS }}"></span>
				&nbsp;

				<a href="{{ $data['url_pattern'] }}/edit/@{{ model.id }}"><span class="glyphicon glyphicon-pencil"></span> <span ng-bind="model.name"></span></a>

			</td>
			<td><span ng-bind="model.session_name"></span></td>
			<td><a href="mailto:@{{ model.email }}"><span class="glyphicon glyphicon-envelope"></span> <span ng-bind="model.email"></span></a></td>
			<td><span ng-bind="model.dayoff"></span></td>
			<td><a href="/report/project?user_id=@{{ model.id }}"><span class="fa fa-file-o" aria-hidden="true"></span> プロジェクトのレポート</a></td>
			<td>
				<a href="{{ $data['url_pattern'] }}/edit/@{{ model.id }}"><span class="glyphicon glyphicon-pencil"></span></a>
				| <a href="javascript:void(0);" ng-click="delete_recover(model.id, model.DELETE_FLAG_ACTION)"><i class="@{{model.DELETED_RECOVER_ICON}} @{{model.DELETED_RECOVER_COLOR}}"></i></a>
			</td>
		</tr>
	</table>
	<br>

	@include('_include.user_pagination')
	<br>

</div>

</div> {{-- <div ng-app="myApp" ng-controller="myCtrl"> --}}

@include('_include.admin_footer', [
	'js_list'				=> true,
])
