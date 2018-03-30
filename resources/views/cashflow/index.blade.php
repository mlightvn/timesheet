@include('_include.user_header',
	[
		'id'				=> 'cashflow_list',
	]
)

<div ng-app="myApp" ng-controller="myCtrl">

<div class="w3-row">
	<h1>Cash Flow一覧</h1>
</div>

@include('_include.api_search', ['keyword'=>$data["keyword"]])

@if(session("message"))
	@include('_include.alert_message', ["message" => (isset($message) ? $message : session("message")), "alert_type" => (isset($alert_type) ? $alert_type : session("alert_type"))])
@endif

<div class="w3-row">
	<button class="w3-button w3-brown" ng-click="reset()"><span class="fas fa-list-ul"></span></button>&nbsp;
	<a href="{{ $data['url_pattern'] }}/add" class="w3-button w3-brown"><span class="fas fa-plus"></span></a>
	<br><br>

	<form action="{{ $data['url_pattern'] }}/update" method="post">
	{{ csrf_field() }}
	<input type="hidden" id="data_source_url" value="/api{{ $data['url_pattern'] }}">
	<table class="timesheet_table w3-table-all w3-hoverable w3-striped w3-bordered">
		<thead>
		<tr class="w3-brown">
			<th>ID</th>
			<th>Title</th>
			<th>Cash Out</th>
			<th>Cash In</th>
			<th>Remain amount</th>
			<th></th>
		</tr>
		</thead>
		<tr class="@{{ model.DELETED_CSS_CLASS }}" ng-repeat="model in model_list">
			<td>
				<span ng-bind="model.id"></span>
			</td>
			<td>
				<a href="{{ $data['url_pattern'] }}/edit/@{{ model.id }}"><i class="fas fa-pencil-alt"></i> <span ng-bind="model.name"></span></a>
			</td>
			<td>
				<span ng-bind="model.AMOUNT_OUT"></span>
			</td>
			<td>
				<span ng-bind="model.AMOUNT_IN"></span>
			</td>
			<td>
			</td>
			<td>
				<a href="{{ $data['url_pattern'] }}/edit/@{{ model.id }}"><i class="fas fa-pencil-alt"></i></a>
			</td>
		</tr>

	</table>
	</form>
	<br>

	@include('_include.user_pagination')

</div>

</div> {{-- <div ng-app="myApp" ng-controller="myCtrl"> --}}

@include('_include.user_footer', [
		'id'				=> 'domain',
		'js_list'			=> true,
])
