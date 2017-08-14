@include('_include.admin_header',
	[
		'id'				=> 'day',
		'title'				=> 'Day table',
		'css'				=> 'day',
	]
)

		<form action="{{ \Request::url() }}" method="post">
			{{ csrf_field() }}

			<input type="hidden" name="sRequestYearMonth" value="{{ $sRequestYearMonth }}">
			<input type="hidden" id="sRequestDate" name="sRequestDate" value="{{ $sDbRequestDate }}">
			<input type="hidden" id="iTotalWorkingMinutes" name="iTotalWorkingMinutes" value="{{ $total_working_minutes }}">
			<input type="hidden" id="sTotalWorkingHoursLabel" name="sTotalWorkingHoursLabel" value="{{ $total_working_hours_label }}">

		<div id="divMessageBorder" class="container w3-responsive w3-hide">
			<div class="w3-row w3-col s12 m12 l12 w3-border w3-border-green">
				<br>
				&nbsp;&nbsp;<div id="divMessage" class="w3-text-green"></div>
				<br>
			</div>
			<br>
		</div>

		<div id="divMessageBorder" class="container w3-responsive">
			<div class="w3-row w3-col s12 m12 l12">
				<div class="w3-center">
						<span id="datepicker"></span>
				</div>
			</div>
			<br><br><br>
		</div>

		<div class="w3-responsive">
		<table class="timesheet_table w3-table-all w3-hoverable w3-bordered w3-tiny">
			<thead>
			<tr class="w3-brown">
				<th nowrap="nowrap">日</th>
				<th>時間</th>
				<th></th>
			</tr>
			</thead>

			@foreach($arrWorkingDays as $day => $arrWorkingDay)
			<tr {!! ($arrWorkingDay['is_holiday']) ? 'class="w3-gray"' : '' !!}>
				<td align="right">
					<a href="/admin/report/time?date={{ $sRequestYearMonth . '-' . $day }}" title="{{ $arrWorkingDay['name'] }}">{{ $day }} <span class="glyphicon glyphicon-new-window"></span></a>
				</td>
				<td>
					<div class="{{ ((intval($arrWorkingDay['minutes']) >= 480) || ($arrWorkingDay['is_holiday'])) ? 'w3-text-green' : 'w3-text-red' }}">
					{{ $arrWorkingDay["hour_label"] }} 
					</div>
				</td>
				<td>
					<a href="/admin/report/time?date={{ $sRequestYearMonth . '-' . $day }}"><span class="glyphicon glyphicon-info-sign"></span></a>
				</td>
			</tr>
			@endforeach

			<tr>
				<td align="right">
				</td>
				<td><label class="w3-xlarge">{{ $total_working_hours_label }}</label>
				</td>
				<td>
				</td>
			</tr>

			<tfoot>
			<tr>
				<td colspan="3">
					<div class="w3-center">
						<button type="button" onclick="window.open('/admin/report/day_download_{{ $requestYear }}_{{ $requestMonth }}','_blank');" class="w3-button w3-brown w3-xlarge">　　<span class="fa fa-download"></span> ダウンロード　　</button>
					</div>
				</td>
			</tr>
			</tfoot>
		</table>
		</form>
		<br>
		</div>


@include('_include.admin_footer', [
	"js"			=> "day",
])
