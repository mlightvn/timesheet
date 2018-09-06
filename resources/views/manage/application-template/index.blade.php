@include('_include.admin_header',
	[
		'id'				=> 'manage-application-template',
	]
)

<div ng-app="myApp" ng-controller="myCtrl">

<div class="w3-row">
	<h1>Application Template List</h1>
</div>

@include('_include.api_search', ['keyword'=>$data["keyword"]])

@if(session("message"))
	@include('_include.alert_message', ["message" => (isset($message) ? $message : session("message")), "alert_type" => (isset($alert_type) ? $alert_type : session("alert_type"))])
@endif

<div class="w3-row">
	<button type="button" class="w3-button w3-brown" ng-click="reset()"><span class="fas fa-list-ul"></span></button>&nbsp;
	@if($logged_in_user->role != "Member")
	<a href="{{ $data['url_pattern'] }}/add" class="w3-button w3-brown"><span class="fas fa-plus"></span></a>
	@endif
	<br><br>

	{{ csrf_field() }}

	<input type="hidden" id="data_source_url" value="/api{{ $data['url_pattern'] }}">

	<table class="w3-table-all w3-hoverable w3-striped w3-bordered">
		<thead>
		<tr class="w3-brown">
			<th>ID</th>
			<th>{{__('screen.common.title')}}</th>
			<th></th>
		</tr>
		</thead>
		<tr class="@{{ model.DELETED_CSS_CLASS }}" ng-repeat="model in model_list">
			<td>
				<span ng-bind="model.id"></span>
			</td>
			<td>
				<a ng-href="{{ $data['url_pattern'] }}/edit/@{{ model.id }}"><i class="fas fa-pencil-alt"></i> <span ng-bind="model.name"></span></a>
			</td>
			<td>
				<a ng-href="{{ $data['url_pattern'] }}/edit/@{{ model.id }}" class="btn w3-brown btn-xs"><i class="fas fa-pencil-alt"></i></a>

				| <a href="javascript:void(0);" ng-click="delete_recover(model.id, model.DELETE_FLAG_ACTION)" class="btn @{{model.DELETED_RECOVER_COLOR}} btn-xs"><i class="@{{model.DELETED_RECOVER_ICON}}"></i></a>
			</td>
		</tr>

	</table>
	<br>

	@include('_include.user_pagination')

</div>

</div> {{-- <div ng-app="myApp" ng-controller="myCtrl"> --}}

@include('_include.admin_footer', [
		'id'				=> 'manage-application-template',
		'js_list'			=> true,
])
