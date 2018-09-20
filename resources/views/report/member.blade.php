@include('_include.admin_header',
	[
		'id'					=> 'report_member',
		'title'					=> 'Member table',
		'css'					=> 'report/day',
		'datepicker'			=> true,
	]
)

<div ng-app="myApp" ng-controller="myCtrl">

		<form action="{{ $data['url_pattern'] }}" method="post">
			{{ csrf_field() }}

			<input type="hidden" id="data_source_url" value="/api{{ $data['url_pattern'] }}?department_id={{request()->department_id}}">

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

		<ul class="nav nav-tabs nav-justified">
			<li class="nav-item">
				<a class="nav-link @{{ (model.id == model_list.department_id) ? 'active' : '' }}" ng-href="member">{{__('screen.common.all')}}</a>
			</li>
			<li class="nav-item" ng-repeat="model in model_list.departmentList">
				<a class="nav-link @{{ (model.id == model_list.department_id) ? 'active' : '' }}" ng-href="?department_id=@{{model.id}}" ng-bind="model.name" ng-keydown="loadData()"></a>
			</li>
		</ul>

		<div class="w3-responsive" style="overflow: auto;">
		<table class="table w3-hoverable table-bordered">
			<thead>
				<tr class="w3-brown">
					<th nowrap="nowrap" width="100px">{{__('screen.report.day.day')}}</th>
					<th width="50px"></th>
					<th nowrap="nowrap">{{__('screen.common.description')}}</th>
					<th ng-repeat="user in model_list.userList" nowrap="nowrap"><a ng-href="time?user_id=@{{user.id}}" ng-bind="user.name" class="text-white"></a></th>
				</tr>
			</thead>

			<tr class="@{{ model.status_color }}" ng-repeat="model in model_list.arrWorkingDays">
				<td align="right">
					<span ng-bind="model.day"></span>
				</td>
				<td>
					<span class="@{{ model.day_icon }}"></span>
				</td>
				<td>
					<span ng-bind="model.holiday_label"></span>
				</td>
				<td ng-repeat="timeInfo in model.timeList"><a ng-href="@{{timeInfo.detail_page_url}}" ng-bind="timeInfo.hour_label" ng-class="timeInfo.time_status"></a></td>
			</tr>

			<tr>
				<td colspan="3">
				</td>
				<td nowrap="nowrap" ng-repeat="timeInfo in model_list.lastRow"><span ng-bind="timeInfo.hour_label" class="font-weight-bold"></span></td>
			</tr>

{{--
			<tfoot>
			<tr>
				<td colspan="4">
					<div class="w3-center">
						<button type="button" action="download" value="@{{model_list.download_url}}" class="w3-button w3-brown w3-xlarge">　　<span class="fas fa-cloud-download-alt"></span> {{__('message.download')}}　　</button>
					</div>
				</td>
			</tr>
			</tfoot>
--}}

		</table>
		</form>
		<br>
		</div>

</div> {{-- <div ng-app="myApp" ng-controller="myCtrl"> --}}

@include('_include.admin_footer', [
	"js"					=> "report/member",
	'js_list'				=> true,
	'datepicker'			=> true,
])
