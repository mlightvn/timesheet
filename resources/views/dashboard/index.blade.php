@include('_include.user_header',
	[
		'id'				=> 'dashboard',
	]
)

@if(session("message"))
	@include('_include.alert_message', ["message" => (isset($message) ? $message : session("message")), "alert_type" => (isset($alert_type) ? $alert_type : session("alert_type"))])
@endif

<div class="w3-row">

	<div class="w3-col">
		<div class="w3-col m2 l3">&nbsp;</div>
		<div class="w3-col s12 m8 l6">
			<form method="post">
				<table class="w3-table w3-centered w3-xxlarge">
					<tr class="w3-light-gray">
						<th>Check in</th>
						<th>&nbsp;&nbsp;&nbsp;&nbsp;</th>
						<th>Check out</th>
					</tr>
					<tr>
						<td>
							@if($workDateTime->time_in)
							<span id="workTimeIn">{{$workDateTime->time_in}}</span>
							@else
							<span id="workTimeIn"></span>
							<button type="button" class="w3-button w3-brown" id="check-in"><i class="fas fa-sign-in-alt"></i> Check In</button>
							@endif
						</td>
						<td></td>
						<td>
							@if($workDateTime->time_out)
							<span id="workTimeOut">{{$workDateTime->time_out}}</span>
							@else
							<span id="workTimeOut"></span>
							<button type="button" class="w3-button w3-brown" id="check-out">Check Out <i class="fas fa-sign-out-alt"></i></button>
							@endif
						</td>
					</tr>
				</table>

			</form>
		</div>
		<div class="w3-col m2 l3">&nbsp;</div>
	</div>

</div>

@include('_include.user_footer', [
		'id'				=> 'dashboard',
		'js'				=> 'dashboard',
])
