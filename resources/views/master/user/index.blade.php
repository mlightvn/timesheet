@include('_include.master.header',
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

<br>
<div id="divAlertBox" class="alert w3-hide">
	<span class="closebtn">&times;</span>
	<div id="divMessage"></div>
</div>
<br>

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
	<input type="hidden" id="data_source_url_delete" value="/api{{ $data['url_pattern'] }}">

	<div class="w3-bar w3-light-gray">
		<a class="w3-bar-item w3-button {{ (!isset($data['permission_flag'])) ? 'w3-gray' : '' }}" href="{{ $data['url_pattern'] }}">All</a>
		<a class="w3-bar-item w3-button {{ (isset($data['permission_flag']) && ($data['permission_flag'] == 'Master')) ? 'w3-gray' : '' }}" href="{{ $data['url_pattern'] }}?permission=Master">Master</a>
		<a class="w3-bar-item w3-button {{ (isset($data['permission_flag']) && ($data['permission_flag'] == 'Owner')) ? 'w3-gray' : '' }}" href="{{ $data['url_pattern'] }}?permission=Owner">Owner</a>
		<a class="w3-bar-item w3-button {{ (isset($data['permission_flag']) && ($data['permission_flag'] == 'Other')) ? 'w3-gray' : '' }}" href="{{ $data['url_pattern'] }}?permission=Other">Other users</a>
	</div>

	<table class="timesheet_table w3-table-all w3-hoverable w3-striped w3-bordered">
		<thead>
		<tr class="w3-brown">
			<th>#</th>
			<th>企業名</th>
			<th>ユーザー名</th>
			<th>email</th>
			<th></th>
		</tr>
		</thead>
		<tr class="@{{ model.DELETED_CSS_CLASS }}" ng-repeat="model in model_list">
			<td><span ng-bind="model.id"></span></td>
			<td><span ng-bind="model.organization_name"></span></td>
			<td>
				<span class="@{{ model.ICON_CLASS }}"></span>
				&nbsp;

				<a href="{{ $data['url_pattern'] }}/edit/@{{ model.id }}"><span class="fa fa-pencil"></span> <span ng-bind="model.name"></span></a>

			</td>
			<td><a href="mailto:@{{ model.email }}"><span class="fa fa-envelope"></span> <span ng-bind="model.email"></span></a></td>
			<td>
				@if(isset($data['permission_flag']) && (in_array($data['permission_flag'], array('Master', 'Owner'))))
					<a href="{{ $data['url_pattern'] }}/edit/@{{ model.id }}"><span class="fa fa-pencil"></span></a>

					| <a href="javascript:void(0);" ng-click="delete_recover(model.id, model.DELETE_FLAG_ACTION)"><i class="@{{model.DELETED_RECOVER_ICON}} @{{model.DELETED_RECOVER_COLOR}}"></i></a>
				@endif
			</td>
		</tr>
	</table>
	<br>

	@include('_include.user_pagination')
	<br>

</div>

</div> {{-- <div ng-app="myApp" ng-controller="myCtrl"> --}}

@include('_include.master.footer', [
	'js_list'				=> true,
])
