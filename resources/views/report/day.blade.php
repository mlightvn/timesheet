@include('_include.admin_header',
	[
		'id'					=> 'report_day',
		'title'					=> 'Day table',
		'css'					=> 'report/day',
		'datepicker'			=> true,
	]
)

<div ng-app="myApp" ng-controller="myCtrl">

		<form action="{{ $data['url_pattern'] }}" method="post">
			{{ csrf_field() }}

			<input type="hidden" id="data_source_url" value="/api{{ $data['url_pattern'] }}">

			<input type="hidden" name="user_id" value="{{ $data['user_id'] }}">
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
					<th nowrap="nowrap" width="100px">{{__('screen.report.day.day')}}</th>
					<th width="50px"></th>
					<th width="100px">{{__('screen.report.day.time')}}</th>
					<th>{{__('screen.common.description')}}</th>
					<th></th>
				</tr>
			</thead>

			<tr class="@{{ model.status_color }}" ng-repeat="model in model_list.arrWorkingDays">
				<td align="right">
					<a href="@{{ model.TIME_PAGE_URL }}" title="@{{ model.name }}"><span class="fas fa-info-circle"></span> <span ng-bind="model.day"></span></a>
				</td>
				<td>
					<span class="@{{ model.day_icon }}"></span>
				</td>
				<td>
					<span class="@{{ model.hour_color }}" ng-bind="model.hour_label"></span>
				</td>
				<td>
					<span ng-bind="model.application_title"></span>
				</td>
				<td>
				</td>
			</tr>
			<tr>
				<td colspan="2">
				</td>
				<td colspan="3"><label class="w3-xlarge" ng-bind="model_list.total_working_hours_label"></label>
				</td>
			</tr>

			<tfoot>
			<tr>
				<td colspan="4">
					<div class="w3-center">
						<button type="button" action="download" value="@{{model_list.download_url}}" class="w3-button w3-brown w3-xlarge">　　<span class="fas fa-cloud-download-alt"></span> {{__('message.download')}}　　</button>
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
	"js"					=> "report/day",
	'js_list'				=> true,
	'datepicker'			=> true,
])
