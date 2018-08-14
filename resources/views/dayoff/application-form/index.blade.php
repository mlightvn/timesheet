@include('_include.user_header',
	[
		'id'				=> 'dayoff_application',
	]
)

<div ng-app="myApp" ng-controller="myCtrl">

<div class="w3-row">
	<h1>{{__('message.menu.day_off.application_form')}}</h1>
</div>

@include('_include.api_search', ['keyword'=>$data["keyword"]])

@if(session("message"))
	@include('_include.alert_message')
@endif

<div class="w3-row">
	<button class="w3-button w3-brown" ng-click="reset()"><span class="fas fa-list-ul"></span></button>&nbsp;
	<a href="{{ $data['url_pattern'] }}/add" class="w3-button w3-brown"><span class="fas fa-plus"></span></a>
	<br><br>

	{{ csrf_field() }}

	<input type="hidden" id="data_source_url" value="/api{{ $data['url_pattern'] }}">

	<table class="timesheet_table w3-table-all w3-hoverable w3-striped w3-bordered">
		<thead>
		<tr class="w3-brown">
			<th>ID</th>
			<th>Application</th>
			<th>{{__('message.status.status')}}</th>
			<th>{{__('message.applied_member')}}</th>
			<th>{{__('message.allowed_member')}}</th>
			<th></th>
		</tr>
		</thead>
		<tr ng-repeat="model in model_list">
			<td>
				<span ng-bind="model.id"></span>
			</td>
			<td>
				<a href="{{ $data['url_pattern'] }}/@{{ model.id }}/view"><i class="fas fa-eye"></i> <span ng-bind="model.name"></span></a>
			</td>
			<td class="@{{ model.STATUS_COLOR }}">
				<span ng-bind="model.STATUS_LABEL"></span>
			</td>
			<td>
				<span ng-bind="model.APPLIED_USER_NAME"></span>
			</td>
			<td>
				<span ng-bind="model.APPROVED_USER_NAME"></span>
			</td>
			<td>
				<a href="{{ $data['url_pattern'] }}/@{{ model.id }}/view"><i class="fas fa-eye"></i></a>
			</td>
		</tr>

	</table>
	<br>

	@include('_include.user_pagination')

</div>

</div> {{-- <div ng-app="myApp" ng-controller="myCtrl"> --}}

@include('_include.user_footer', [
		'id'				=> 'dayoff_application',
		'js_list'			=> true,
])
