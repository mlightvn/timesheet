@include('_include.admin_header',
	[
		'id'				=> 'manage_project_task',
	]
)

<div ng-app="myApp" ng-controller="myCtrl">

<div class="w3-row">
	<h1>{{__('screen.task.list')}}</h1>
</div>

@include('_include.api_search', ['keyword'=>$data["keyword"]])

@if(session("message"))
	@include('_include.alert_message', ["message" => (isset($message) ? $message : session("message")), "alert_type" => (isset($alert_type) ? $alert_type : session("alert_type"))])
@endif

<div class="w3-row">
	<button type="button" class="w3-button w3-brown" ng-click="reset()"><span class="fas fa-list-ul"></span></button>&nbsp;
	<a href="{{ $data['url_pattern'] }}/add" class="w3-button w3-brown"><span class="fas fa-plus"></span></a>
	<br><br>

	<form action="{{ $data['url_pattern'] }}/update" method="post">
	{{ csrf_field() }}
	<input type="hidden" id="data_source_url" value="/api{{ $data['url_pattern'] }}">

	<table class="timesheet_table w3-table-all w3-hoverable w3-striped w3-bordered">
		<thead>
		<tr class="w3-brown">
			<th>ID</th>
			<th>{{__('screen.project.project')}}</th>
			<th>{{__('screen.task.task')}}</th>
			<th>{{__('screen.task.my_task')}}</th>
			<th>{{__('message.excel_output_flag')}}</th>
			<th></th>
		</tr>
		</thead>

		<tr class="@{{ model.DELETED_CSS_CLASS }}" ng-repeat="model in model_list">
			<td><span ng-bind="model.project_task_id"></span></td>
			<td>
				<span ng-bind="model.project_name"></span>
				<br>
				<small ng-bind="model.project_description"></small>
			</td>
			<td>
				<a href="{{ $data['url_pattern'] }}/edit/@{{ model.project_task_id }}" ng-bind="model.project_task_name"></a>
				<br>
				<small ng-bind="model.project_task_description"></small>
			</td>
			<td>
				<label class="switch">
					<input type="checkbox" name="project[@{{ model.id }}][user_id]" ng-checked="model.SELF_PROJECT" disabled="disabled">
					<span class="slider round"></span>
				</label>
			</td>
			<td>
				<label class="switch">
					<input type="checkbox" name="project[@{{ model.id }}][excel_flag]" ng-checked="model.excel_flag" disabled="disabled">
					<span class="slider round"></span>
				</label>
			</td>
			<td><a href="{{ $data['url_pattern'] }}/edit/@{{ model.project_task_id }}" class="btn w3-brown btn-xs"><span class="fas fa-pencil-alt"></span></a>
				@if($logged_in_user->role != "Member")
				| <a href="javascript:void(0);" ng-click="delete_recover(model.project_task_id, model.DELETE_FLAG_ACTION)" class="btn @{{model.DELETED_RECOVER_COLOR}} btn-xs"><i class="@{{model.DELETED_RECOVER_ICON}}"></i></a>
				@endif
			</td>
		</tr>
	</table>
	</form>
	<br>

	@include('_include.user_pagination')

</div>

</div> {{-- <div ng-app="myApp" ng-controller="myCtrl"> --}}


@include('_include.admin_footer', [
	'js_list'			=> true,
])
