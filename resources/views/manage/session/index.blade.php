@include('_include.admin_header',
	[
		'id'				=> 'session',
	]
)

<div ng-app="myApp" ng-controller="myCtrl">

<div class="w3-row">
	<h1>部署一覧</h1>
	<br>
</div>

@include('_include.admin_search', ['keyword'=>$data["keyword"]])

@if(isset($message) || session("message"))
	@include('_include.alert_message', ["message" => (isset($message) ? $message : session("message")), "alert_type" => (isset($alert_type) ? $alert_type : session("alert_type"))])
@endif

<div class="w3-row">
	<a href="{{ $data['url_pattern'] }}" class="w3-button w3-brown"><span class="glyphicon glyphicon-list"></span></a>&nbsp;
	@if (in_array($logged_in_user->permission_flag, array("Administrator", "Manager")))
	<a href="{{ $data['url_pattern'] }}/add" class="w3-button w3-brown"><span class="glyphicon glyphicon-plus"></span></a>
	@endif
	<br><br>

	<input type="hidden" id="data_source_url" value="/api/manage/session">

	<table class="timesheet_table w3-table-all w3-hoverable w3-striped w3-bordered">
		<thead>
		<tr class="w3-brown">
			<th>ID</th>
			@if ( in_array($logged_in_user->permission_flag, array("Administrator")) )
			<th>企業名</th>
			@endif
			<th>部署</th>
			<th></th>
		</tr>
		</thead>
		<tbody id="listBody">

		<tr class="" ng-repeat="model in model_list">
			<td>@{{ model.id }}</td>
			@if ( in_array($logged_in_user->permission_flag, array("Administrator")) )
			<td>@{{ model.organization_name }}</td>
			@endif
			<td>
			@if (in_array($logged_in_user->permission_flag, array("Administrator", "Manager")))
			<a href="{{ $data['url_pattern'] }}/edit/@{{ model.id }}">@{{ model.name }}</a>
			@else
			@{{ model.name }}
			@endif
			</td>
			<td>
			@if (in_array($logged_in_user->permission_flag, array("Administrator", "Manager")))
			<a href="{{ $data['url_pattern'] }}/edit/@{{ model.id }}"><span class="glyphicon glyphicon-pencil"></span></a> 

			<span ng-if="model.is_deleted == true">
				| <a href="{{ $data['url_pattern'] }}/recover/@{{ model.id }}"><span class="fa fa-recycle w3-text-green"></span></a>
			</span>
			<span ng-if="model.is_deleted == false">
				| <a href="{{ $data['url_pattern'] }}/delete/@{{ model.id }}"><span class="fa fa-trash w3-text-red"></span></a>
			</span>

			@endif
			</td>
		</tr>

		</tbody>
	</table>
	<br>

	@include('_include.user_pagination')
	<br>

</div>

</div> {{-- <div ng-app="myApp" ng-controller="myCtrl"> --}}

@include('_include.admin_footer', [
	'js_list'	=> true,
])
