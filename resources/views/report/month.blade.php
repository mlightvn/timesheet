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
{{--
				<th>
					<input type="checkbox" id="chkMonthAll">
				</th>
--}}
				<th nowrap="nowrap">月</th>
				<th></th>
			</tr>
			</thead>

			@foreach($arrMonth as $month_key => $month_label)
			<tr>
{{--
				<td><input type="checkbox" id="chkMonth[{{ $month_key }}]" name="chkMonth[{{ $month_key }}]">
--}}
				</td>
				<td>
					<a href="/admin/report/day?year_month={{ $requestYear }}-{{ str_pad($month_key, 2, '0', STR_PAD_LEFT) }}">
						{{ $month_key }}月
					</a>

				</td>
				<td>
					<a href="day_download_{{ $requestYear }}-{{ $month_key }}" class="w3-text-brown"><span class="fas fa-cloud-download-alt"></span></a>
				</td>
			</tr>
			@endforeach
			<tfoot>
			<tr>
				<td colspan="2">
					<div class="w3-center">
						<button type="button" disabled="disabled" class="w3-button w3-brown w3-xlarge">　　<span class="fas fa-cloud-download-alt"></span> ダウンロード　　</button>
					</div>
				</td>
			</tr>
			</tfoot>
		</table>

	<br>
	</div>

</form>



@include('_include.admin_footer', [
	'datepicker'			=> true,
	'js'					=> 'report/month',
])
