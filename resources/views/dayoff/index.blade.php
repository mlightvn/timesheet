@include('_include.user_header',
	[
		'id'				=> 'dayoff_application',
	]
)

<div ng-app="myApp" ng-controller="myCtrl">

<div class="w3-row">
	<h1>Dashboard</h1>
	<br>
</div>

{{--
@include('_include.api_search', ['keyword'=>(isset($data["keyword"]) ? $data["keyword"] : '')])

@if(session("message"))
	@include('_include.alert_message', ["message" => (isset($message) ? $message : session("message")), "alert_type" => (isset($alert_type) ? $alert_type : session("alert_type"))])
@endif

<div class="w3-row">
	<a href="{{ $data['url_pattern'] }}" class="w3-button w3-brown"><span class="glyphicon glyphicon-list"></span></a>&nbsp;
	<a href="{{ $data['url_pattern'] }}/add" class="w3-button w3-brown"><span class="glyphicon glyphicon-plus"></span></a>
	<br><br>

</div>
--}}

</div> {{-- <div ng-app="myApp" ng-controller="myCtrl"> --}}

@include('_include.user_footer', [
		'id'				=> 'dayoff_application',
		'js_list'			=> true,
])
