@include('_include.user_header',
	[
		'id'				=> 'domain_list',
	]
)

<div ng-app="myApp" ng-controller="myCtrl">


@if(session("message"))
	@include('_include.alert_message', ["message" => (isset($message) ? $message : session("message")), "alert_type" => (isset($alert_type) ? $alert_type : session("alert_type"))])
@endif

<div class="w3-row">

	<div class="w3-col s12 m12 l12 w3-center">
		<button class="w3-button w3-brown w3-xxlarge"><i class="fas fa-sign-in-alt"></i> Check In</button>
		&nbsp;&nbsp;&nbsp;&nbsp;
		<button class="w3-button w3-brown w3-xxlarge">Check Out</button>
	</div>

</div>

</div> {{-- <div ng-app="myApp" ng-controller="myCtrl"> --}}

@include('_include.user_footer', [
		'id'				=> 'domain',
		'js_list'			=> true,
])
