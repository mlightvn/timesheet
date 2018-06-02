@include('_include.user_header',
	[
		'id'				=> 'domain_list',
	]
)

<div ng-app="myApp" ng-controller="myCtrl">

<div class="w3-row">
	<h1>ドメイン一覧</h1>
</div>

@include('_include.api_search', ['keyword'=>$data["keyword"]])

@if(session("message"))
	@include('_include.alert_message', ["message" => (isset($message) ? $message : session("message")), "alert_type" => (isset($alert_type) ? $alert_type : session("alert_type"))])
@endif

<div class="w3-row">
	<button class="w3-button w3-brown" ng-click="reset()"><span class="fas fa-list-ul"></span></button>&nbsp;
	<a href="{{ $data['url_pattern'] }}/add" class="w3-button w3-brown"><span class="fas fa-plus"></span></a>
	<br><br>

	<div class="w3-bar w3-light-gray">
		<a class="w3-bar-item w3-button" href="{{ $data['url_pattern'] }}">All</a>
		<a class="w3-bar-item w3-button" href="{{ $data['url_pattern'] }}?development_flag=1">Production</a>
		<a class="w3-bar-item w3-button" href="{{ $data['url_pattern'] }}?development_flag=2">Staging</a>
		<a class="w3-bar-item w3-button" href="{{ $data['url_pattern'] }}?development_flag=3">Development</a>
		<a class="w3-bar-item w3-button" href="{{ $data['url_pattern'] }}?development_flag=4">Others</a>
	</div>

	<form action="{{ $data['url_pattern'] }}/update" method="post">
	{{ csrf_field() }}
	<input type="hidden" id="data_source_url" value="/api{{ $data['url_pattern'] }}{{(isset($data['development_flag']) ? ('?development_flag=' . $data['development_flag']) : '')}}">
	<table class="timesheet_table w3-table-all w3-hoverable w3-striped w3-bordered">
		<thead>
		<tr class="w3-brown">
			<th>ID</th>
			<th>環境</th>
			<th>ドメイン名</th>
			<th>SSHとDB接続</th>
			<th></th>
		</tr>
		</thead>
		<tr class="@{{ model.DELETED_CSS_CLASS }}" ng-repeat="model in model_list">
			<td>
				<span ng-bind="model.id"></span>
			</td>
			<td>
				<a href="?development_flag=@{{ model.development_flag }}"><i class="fas fa-search"></i> <span ng-bind="model.development_flag_label"></span></a></td>
			<td>
				@if(in_array($logged_in_user->permission_flag, array("Member")))
				<a href="{{ $data['url_pattern'] }}/view/@{{ model.id }}"><i class="fas fa-eye"></i> <span ng-bind="model.name"></span>（★開発中★）</a>
				@else
				<a href="{{ $data['url_pattern'] }}/edit/@{{ model.id }}"><i class="fas fa-pencil-alt"></i> <span ng-bind="model.name"></span></a>
				@endif
				<br><br>
				サイト： <a href="@{{ model.url }}" target="_blank"><span ng-bind="model.url"></span></a><br>
				管理： <a href="@{{ model.admin_url }}" target="_blank"><span ng-bind="model.admin_url"></span></a>
			</td>
			<td>
				SSH： <span ng-bind="model.ssh_access_command"></span>
				<br>
				DB： <span ng-bind="model.db_access_command"></span>
				<br>
				Respository： <a href="@{{ model.repository_url }}" target="_blank"><span ng-bind="model.repository_url"></span></a>
			</td>
			<td>
				@if(in_array($logged_in_user->permission_flag, array("Member")))
				<a href="{{ $data['url_pattern'] }}/view/@{{ model.id }}" class="btn w3-brown btn-xs"><i class="fas fa-eye"></i></a>
				@else
				<a href="{{ $data['url_pattern'] }}/edit/@{{ model.id }}" class="btn w3-brown btn-xs"><i class="fas fa-pencil-alt"></i></a>
				| <a href="javascript:void(0);" ng-click="delete_recover(model.id, model.DELETE_FLAG_ACTION)" class="btn @{{model.DELETED_RECOVER_COLOR}} btn-xs"><i class="@{{model.DELETED_RECOVER_ICON}}"></i></a>
				@endif
		</tr>

	</table>
	</form>
	<br>

	@include('_include.user_pagination')

</div>

</div> {{-- <div ng-app="myApp" ng-controller="myCtrl"> --}}

@include('_include.user_footer', [
		'id'				=> 'domain',
		'js_list'			=> true,
])
