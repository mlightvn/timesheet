@include('_include.user_header',
	[
		'id'				=> 'manage_application_template',
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
	<button type="button" class="w3-button w3-brown" ng-click="reset()"><span class="glyphicon glyphicon-list"></span></button>&nbsp;
	<a href="{{ $data['url_pattern'] }}/add" class="w3-button w3-brown"><span class="glyphicon glyphicon-plus"></span></a>
	<br><br>

	{{ csrf_field() }}

	<input type="hidden" id="data_source_url" value="/api/application-template">

	<table class="timesheet_table w3-table-all w3-hoverable w3-striped w3-bordered">
		<thead>
		<tr class="w3-brown">
			<th>ID</th>
			<th>タイトル</th>
			<th></th>
		</tr>
		</thead>
		<tr class="@{{ model.DELETED_CSS_CLASS }}" ng-repeat="model in model_list">
			<td>
				<span ng-bind="model.id"></span>
			</td>
			<td>
				<a href="{{ $data['url_pattern'] }}/edit/@{{ model.id }}"><i class="fa fa-pencil"></i> <span ng-bind="model.name"></span></a>
			</td>
			<td>
				<a href="{{ $data['url_pattern'] }}/edit/@{{ model.id }}"><i class="fa fa-pencil"></i></a>

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

</div>

</div> {{-- <div ng-app="myApp" ng-controller="myCtrl"> --}}

@include('_include.user_footer', [
		'id'				=> 'manage_application_template',
		'js_list'			=> true,
])
