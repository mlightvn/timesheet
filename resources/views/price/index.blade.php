@include('_include.user_header',
	[
		'id'				=> 'price_list',
	]
)

<div ng-app="myApp" ng-controller="myCtrl">

<div class="w3-row">
	<h1>Price 一覧</h1>
</div>

<div class="w3-row">
	<input type="hidden" id="data_source_url" value="/api{{ $data['url_pattern'] }}">

	<table class="timesheet_table w3-table-all w3-hoverable w3-striped w3-bordered">
		<thead>
		<tr class="w3-brown">
			<th>ID</th>
			<th>Title</th>
			<th>Price</th>
			<th></th>
		</tr>
		</thead>
		<tr class="@{{ model.DELETED_CSS_CLASS }}" ng-repeat="model in model_list">
			<td>
				<span ng-bind="model.id"></span>
			</td>
			<td>
				<span ng-bind="model.name"></span>
			</td>
			<td>
				<span ng-bind="model.price"></span>
			</td>
			<td>
				@include('_include.payment.paypal.buy_now_short')
			</td>
		</tr>

	</table>
	<br>

</div>

</div> {{-- <div ng-app="myApp" ng-controller="myCtrl"> --}}

@include('_include.user_footer', [
		'id'				=> 'domain',
		'js_list'			=> true,
])
