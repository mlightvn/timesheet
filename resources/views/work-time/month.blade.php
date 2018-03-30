@include('_include.admin_header',
	[
		'id'					=> 'work_time_month',
		'title'					=> 'Month',
		'css'					=> 'work_time/month',
		'datepicker'			=> true,
	]
)

<div ng-app="myApp" ng-controller="myCtrl">

		<form action="{{ $data['url_pattern'] }}" method="post">
			{{ csrf_field() }}

			<input type="hidden" id="data_source_url" value="/api{{ $data['url_pattern'] }}?user_id={{ $data['user_id'] }}">

			<input type="hidden" name="sRequestYearMonth" value="@{{ model_list.sRequestYearMonth }}">
			<input type="hidden" id="sRequestDate" name="sRequestDate" value="@{{ model_list.sDbRequestDate }}">
			<input type="hidden" id="iTotalWorkingMinutes" name="iTotalWorkingMinutes" value="@{{ model_list.total_working_minutes }}">
			<input type="hidden" id="sTotalWorkingHoursLabel" name="sTotalWorkingHoursLabel" value="@{{ model_list.total_working_hours_label }}">

		<div id="divMessageBorder" class="container w3-responsive w3-hide">
			<div class="w3-row w3-col s12 m12 l12 w3-border w3-border-green">
				<br>
				&nbsp;&nbsp;<div id="divMessage" class="w3-text-green"></div>
				<br>
			</div>
			<br>
		</div>

		<div id="divMessageBorder" class="container w3-responsive">
			<div class="w3-row">
				<div class="w3-col s12 m4 l4">
					<span id="datepicker"></span>
				</div>
				<div class="w3-col s12 m8 l8">
					<button type="button" class="w3-button w3-brown" action="reset"><i class="fas fa-sync-alt"></i></button>
				</div>
			</div>
			<br><br><br>
		</div>

		<div class="w3-responsive">
		<table class="timesheet_table w3-table-all w3-hoverable w3-bordered">
			<thead>
				<tr class="w3-brown">
					<th nowrap="nowrap">日</th>
					<th>Start</th>
					<th>End</th>
					<th>Rest hour</th>
					<th>Work hour</th>
					<th>Description</th>
					<th></th>
				</tr>
			</thead>

			<tr class="@{{ model.status_color }}" ng-repeat="model in model_list.arrWorkingDays">
				<td align="right">
					<span ng-bind="model.day"></span>
				</td>
				<td>
					<span ng-bind="model.time_in_label"></span>
				</td>
				<td>
					<span ng-bind="model.time_out_label"></span>
				</td>
				<td>
					<span ng-bind="'01:00'"></span>
				</td>
				<td>
					<span class="@{{ model.hour_color }}" ng-bind="model.work_hour_label"></span>
				</td>
				<td>
					<span ng-bind="model.description"></span>
				</td>
				<td>
				</td>
			</tr>
			<tr>
				<td align="right">
				</td>
				<td>
				</td>
				<td>
				</td>
				<td>
				</td>
				<td><label class="w3-xlarge" ng-bind="model_list.total_working_hours_label"></label>
				</td>
				<td>
				</td>
				<td>
				</td>
			</tr>

			<tfoot>
			<tr>
				<td colspan="7">
					<div class="w3-center">
						<button type="button" action="download" value="@{{model_list.download_url}}" class="w3-button w3-brown w3-xlarge" disabled="disabled">　　<span class="fas fa-cloud-download-alt"></span> ダウンロード　　</button>
					</div>
				</td>
			</tr>
			</tfoot>
		</table>
		</form>
		<br>
		</div>

</div> {{-- <div ng-app="myApp" ng-controller="myCtrl"> --}}

@include('_include.admin_footer', [
	"js"					=> "work_time/month",
	'js_list'				=> true,
	'datepicker'			=> true,
])
