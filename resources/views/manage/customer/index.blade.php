@include('_include.admin_header',
	[
		'id'				=> 'manage_customer',
	]
)

<div ng-app="myApp" ng-controller="myCtrl">

<div class="w3-row">
	<h1>顧客一覧</h1>
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

	<input type="hidden" id="data_source_url" value="/api/manage/customer">

	<table class="timesheet_table w3-table-all w3-hoverable w3-striped w3-bordered">
		<thead>
		<tr class="w3-brown">
			<th>ID</th>
			<th>ユーザー名</th>
			<th>email</th>
			<th>携帯・電話番号</th>
			<th></th>
		</tr>
		</thead>

		<tr class="@{{ model.DELETED_CSS_CLASS }}" ng-repeat="model in model_list">
			<td><span ng-bind="model.id"></span></td>
			<td>
				<a href="{{ $data['url_pattern'] }}/edit/@{{ model.id }}"><span class="fa fa-pencil"></span> <span ng-bind="model.name"></span></a><br>
				生年月日: <span ng-bind="model.birthday"></span><br>
			</td>
			<td><a href="mailto:@{{ model.email }}"><span class="fa fa-envelope"></span> <span ng-bind="model.email"></span></a></td>
			<td><a href="tel:@{{ model.phone }}" ng-bind="model.phone"></a></td>

			<td>
				<a href="{{ $data['url_pattern'] }}/edit/@{{ model.id }}"><span class="fa fa-pencil"></span></a>
				| <a href="javascript:void(0);" ng-click="delete_recover(model.id, model.DELETE_FLAG_ACTION)"><i class="@{{model.DELETED_RECOVER_CLASS}}"></i></a>
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
