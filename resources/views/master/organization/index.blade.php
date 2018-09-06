@include('_include.master.header',
	[
		'id'				=> 'master_organization',
	]
)

<div ng-app="myApp" ng-controller="myCtrl">

<div class="w3-row">
	<h1>{{__('screen.master.organization.list')}}</h1>
</div>

@include('_include.api_search', ['keyword'=>$data["keyword"]])

@if(isset($message) || session("message"))
	@include('_include.alert_message', ["message" => (isset($message) ? $message : session("message")), "alert_type" => (isset($alert_type) ? $alert_type : session("alert_type"))])
@endif

<br>
<div id="divAlertBox" class="alert w3-hide">
	<span class="closebtn">&times;</span>
	<div id="divMessage"></div>
</div>
<br>

<div class="w3-row">
	<button class="w3-button w3-brown" ng-click="reset()"><span class="fas fa-list-ul"></span></button>&nbsp;
	<a href="{{ $data['url_pattern'] }}/add" class="w3-button w3-brown"><span class="fas fa-plus"></span></a>
	<br><br>

	<input type="hidden" id="data_source_url" value="/api{{ $data['url_pattern'] }}">

	<table class="w3-table-all w3-hoverable w3-striped w3-bordered">
		<thead>
		<tr class="w3-brown">
			<th>#</th>
			<th>{{__('screen.master.organization.name')}}</th>
			<th>Member limitation</th>
			<th>Website</th>
			<th></th>
		</tr>
		</thead>

		<tr class="@{{ model.DELETED_CSS_CLASS }}" ng-repeat="model in model_list">
			<td>@{{ model.id }}</td>
			<td>
				<a href="{{ $data['url_pattern'] }}/edit/@{{ model.id }}"><span class="fas fa-pencil-alt"></span> @{{ model.name }}</a>
			</td>
			<td>@{{ model.member_limitation }}</td>
			<td><a href="@{{ model.website }}" target="_blank">@{{ model.website }}</a></td>
			<td>
				<a href="{{ $data['url_pattern'] }}/edit/@{{ model.id }}" class="btn w3-brown btn-xs"><span class="fas fa-pencil-alt"></span></a>

				| <a href="javascript:void(0);" ng-click="delete_recover(model.id, model.DELETE_FLAG_ACTION)" class="btn @{{model.DELETED_RECOVER_COLOR}} btn-xs"><i class="@{{model.DELETED_RECOVER_ICON}}"></i></a>
			</td>
		</tr>

	</table>
	<br>

	@include('_include.user_pagination')
	<br>
</div>

</div> {{-- <div ng-app="myApp" ng-controller="myCtrl"> --}}

@include('_include.master.footer', [
	'js_list'	=> true,
])
