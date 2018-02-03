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
	<a href="{{ $data['url_pattern'] }}" class="w3-button w3-brown"><span class="glyphicon glyphicon-list"></span></a>&nbsp;
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
			<td>@{{ model.id }}</td>
			<td>
				<a href="{{ $data['url_pattern'] }}/edit/@{{ model.id }}"><span class="fa fa-pencil"></span> @{{ model.name }}</a><br>
				生年月日: @{{ model.birthday }}<br>
			</td>
			<td><a href="mailto:@{{ model.email }}"><span class="fa fa-envelope"></span> @{{ model.email }}</a></td>
			<td><a href="callto:@{{ model.phone }}">@{{ model.phone }}</a></td>

			<td>
				<a href="{{ $data['url_pattern'] }}/edit/@{{ model.id }}"><span class="fa fa-pencil"></span></a>

				<span ng-if="model.is_deleted == true">
					| <a href="{{ $data['url_pattern'] }}/recover/@{{ model.id }}"><span class="fa fa-recycle w3-text-green"></span></a>
				</span>
				<span ng-if="model.is_deleted == false">
					| <a href="{{ $data['url_pattern'] }}/delete/@{{ model.id }}"><span class="fa fa-trash w3-text-red"></span></a>
				</span>
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
