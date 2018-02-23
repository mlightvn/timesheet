@include('_include.admin_header',
	[
		'id'				=> 'master_organization',
	]
)

@if (in_array($logged_in_user->permission_flag, array("Administrator")))
<div ng-app="myApp" ng-controller="myCtrl">

<div class="w3-row">
	<h1>企業一覧</h1>
</div>

@include('_include.api_search', ['keyword'=>$data["keyword"]])

@if(isset($message) || session("message"))
	@include('_include.alert_message', ["message" => (isset($message) ? $message : session("message")), "alert_type" => (isset($alert_type) ? $alert_type : session("alert_type"))])
@endif

<div class="w3-row">
	<button class="w3-button w3-brown" ng-click="reset()"><span class="fa fa-list"></span></button>&nbsp;
	<a href="{{ $data['url_pattern'] }}/add" class="w3-button w3-brown"><span class="fa fa-plus"></span></a>
	<br><br>

	<input type="hidden" id="data_source_url" value="/api/admin/organization">

	<table class="timesheet_table w3-table-all w3-hoverable w3-striped w3-bordered">
		<thead>
		<tr class="w3-brown">
			<th>ID</th>
			<th>企業名</th>
			<th>Website</th>
			<th></th>
		</tr>
		</thead>

		<tr class="@{{ model.DELETED_CSS_CLASS }}" ng-repeat="model in model_list">
			<td>@{{ model.id }}</td>
			<td>
				<a href="{{ $data['url_pattern'] }}/edit/@{{ model.id }}"><span class="glyphicon glyphicon-pencil"></span> @{{ model.name }}</a>
			</td>
			<td><a href="@{{ model.website }}" target="_blank">@{{ model.website }}</a></td>
			<td>
				<a href="{{ $data['url_pattern'] }}/edit/@{{ model.id }}"><span class="glyphicon glyphicon-pencil"></span></a> 

				| <a href="@{{model.RECOVER_OR_DELETE_URL}}"><span class="@{{ model.RECOVER_OR_DELETE_ICON }} @{{ model.RECOVER_OR_DELETE_COLOR }}"></span></a>
			</td>
		</tr>

	</table>
	<br>

	@include('_include.user_pagination')
	<br>
</div>

</div> {{-- <div ng-app="myApp" ng-controller="myCtrl"> --}}
@else
<div class="w3-row">
	<h1 class="w3-text-red">許可なし</h1>
</div>
@endif

@include('_include.admin_footer', [
	'js_list'	=> true,
])
