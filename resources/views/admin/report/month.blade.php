@include('_include.admin_header',
	[
		'id'				=> 'month',
		'title'				=> 'Month table',
	]
)

		<form action="{{ \Request::url() }}" method="get">

		<div id="divMessageBorder" class="w3-container">
			<div class="w3-row w3-col s12 m12 l12">
				<div class="form-group form-inline">
					<div class="input-group">
						<input placeholder="{{ $requestYear }}" class="form-control" name="year" type="number" value="{{ $requestYear }}">
						<span class="input-group-btn">
							<button type="submit" class="btn w3-brown"><span class="fa fa-refresh"></span></button>
						</span>
					</div>
				</div>
			</div>
			<br><br>
		</div>

		<div class="w3-container">
		<table class="timesheet_table w3-table-all w3-hoverable w3-striped w3-bordered">
			<thead>
			<tr class="w3-brown">
				<th>
					<input type="checkbox" id="chkMonthAll">
				</th>
				<th nowrap="nowrap">月</th>
				<th></th>
			</tr>
			</thead>

			@foreach($arrMonth as $month_key => $month_label)
			<tr>
				<td><input type="checkbox" id="chkMonth[{{ $month_key }}]" name="chkMonth[{{ $month_key }}]">
				</td>
				<td>
					<a href="/admin/report/day?year_month={{ $requestYear }}-{{ str_pad($month_key, 2, '0', STR_PAD_LEFT) }}">
						{{ $month_key }}月
					</a>

				</td>
				<td>
					<a href="/admin/report/day?year_month={{ $requestYear }}-{{ str_pad($month_key, 2, '0', STR_PAD_LEFT) }}"><span class="glyphicon glyphicon-info-sign"></span></a> 
					| 
					<a href="day_download_{{ $requestYear }}_{{ $month_key }}"><span class="fa fa-download"></span></a>
				</td>
			</tr>
			@endforeach
			<tfoot>
			<tr>
				<td colspan="3">
					<div class="w3-center">
						<button type="button" disabled="disabled" class="w3-button w3-brown w3-xlarge">　　<span class="fa fa-download"></span> ダウンロード　　</button>
					</div>
				</td>
			</tr>
			</tfoot>
		</table>
		</form>
		<br>
		</div>


@include('_include.admin_footer', [
])
