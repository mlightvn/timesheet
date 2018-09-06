@include('_include.admin_header',
	[
		'id'					=> 'report_month',
		'title'					=> 'Month table',
		'datepicker'			=> true,
		'css'					=> 'report/month',
	]
)

<form action="{{ $data['url_pattern'] }}" method="get" accept-charset="UTF-8">

	<div id="divMessageBorder" class="w3-container">
		<div class="w3-row w3-col w3-section">
			<div class="w3-col s8 m6 l6">
				<input placeholder="{{ $requestYear }}" class="datepicker w3-input w3-border" name="year" value="{{ $requestYear }}">
			</div>
			<div class="w3-col s4 m3 l3">
				<button type="submit" class="w3-button w3-brown"><span class="fas fa-sync-alt"></span></button>
			</div>
		</div>
		<br><br>

	</div>

	<div class="w3-container">
		<table class="timesheet_table w3-table-all w3-hoverable w3-striped w3-bordered">
			<thead>
			<tr class="w3-brown">
				<th nowrap="nowrap">{{__('screen.report.month.month')}}</th>
				<th></th>
			</tr>
			</thead>

			@foreach($arrMonth as $month_key => $month_label)
			<tr>
				</td>
				<td>
					<a href="day?year_month={{ $requestYear }}-{{ $month_key }}" class="btn disabled">
						{{ $month_label }}
					</a>

				</td>
				<td>
					<a href="month/download?year={{ $requestYear }}&month={{ $month_key }}" class="w3-text-brown"><span class="fas fa-cloud-download-alt fa-2x"></span></a>
				</td>
			</tr>
			@endforeach

		</table>

	<br>
	</div>

</form>



@include('_include.admin_footer', [
	'datepicker'			=> true,
	'js'					=> 'report/month',
])
