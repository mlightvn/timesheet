@include('_include.admin_header',
	[
		'id'				=> 'manage_user',
	]
)

<div ng-app="myApp" ng-controller="myCtrl">

<div class="w3-row">
	<h1>{{__('message.user.list')}}</h1>
</div>

@include('_include.api_search', ['keyword'=>$data["keyword"]])

@if(isset($message) || session("message"))
	@include('_include.alert_message', ["message" => (isset($message) ? $message : session("message")), "alert_type" => (isset($alert_type) ? $alert_type : session("alert_type"))])
@endif

<div class="w3-row">
	<button type="button" class="w3-button w3-brown" ng-click="reset()"><span class="fas fa-list-ul"></span></button>&nbsp;
	@if ( in_array($logged_in_user->role, array("Owner", "Manager")) )
	<a href="{{ $data['url_pattern'] }}/add" class="w3-button w3-brown"><span class="fas fa-plus"></span></a>
	@endif
	<br><br>

	<input type="hidden" id="data_source_url" value="/api{{ $data['url_pattern'] }}">

	<table class="timesheet_table w3-table-all w3-hoverable w3-striped w3-bordered">
		<thead>
		<tr class="w3-brown">
			<th>ID</th>
			<th>{{__('message.user.name')}}</th>
			<th>{{__('message.department')}}</th>
			<th>email</th>
			@if ( in_array($logged_in_user->role, array("Owner", "Manager")) )
			<th>Dayoff</th>
			<th>レポート</th>
			@endif
			<th></th>
		</tr>
		</thead>
		<tr class="@{{ model.DELETED_CSS_CLASS }}" ng-repeat="model in model_list">
			<td><span ng-bind="model.id"></span></td>
			<td>
				<img ng-if="model.profile_picture != null" ng-src="@{{ '/upload/user/' + model.profile_picture}}" alt="" width="30px" >
				<span class="@{{ model.ICON_CLASS }}"></span>
				&nbsp;

				@if ( $logged_in_user->role == "Owner" )
					<a href="{{ $data['url_pattern'] }}/user-info/@{{ model.id }}"><span class="fas fa-pencil-alt"></span> <span ng-bind="model.name"></span></a>
				@elseif( in_array($logged_in_user->role, array("Manager")) )
					<span ng-if="model.id == '{{ $logged_in_user->id }}'">
						<a href="{{ $data['url_pattern'] }}/user-info/@{{ model.id }}"><span class="fas fa-pencil-alt"></span> <span ng-bind="model.name"></span></a>
					</span>

					<span ng-if="model.id != '{{ $logged_in_user->id }}'">
						@if ( in_array($logged_in_user->role, array("Owner", "Manager")) )
						<a href="{{ $data['url_pattern'] }}/user-info/@{{ model.id }}"><span class="fas fa-pencil-alt"></span> <span ng-bind="model.name"></span></a>
						@else
							<span ng-bind="model.name"></span>
						@endif
					</span>
				@else
					<a href="{{ $data['url_pattern'] }}/view/@{{ model.id }}"><span class="fas fa-eye"></span> <span ng-bind="model.name"></span></a>
				@endif

			</td>
			<td><span ng-bind="model.session_name"></span></td>
			<td><a href="mailto:@{{ model.email }}"><span class="fas fa-envelope"></span> <span ng-bind="model.email"></span></a></td>
			@if ( in_array($logged_in_user->role, array("Owner", "Manager")) )
			<td><span ng-bind="model.dayoff"></span></td>
			<td><a href="/report/project?user_id=@{{ model.id }}"><span class="fas fa-table" aria-hidden="true"></span> プロジェクトのレポート</a></td>
			@endif
			<td>

				@if ( $logged_in_user->role == "Owner" )
					<a href="{{ $data['url_pattern'] }}/edit/@{{ model.id }}" class="btn w3-brown btn-xs"><span class="fas fa-pencil-alt"></span></a>
				@elseif( in_array($logged_in_user->role, array("Manager")) )
					<span ng-if="model.id == '{{ $logged_in_user->id }}'">
						<a href="{{ $data['url_pattern'] }}/edit/@{{ model.id }}" class="btn w3-brown btn-xs"><span class="fas fa-pencil-alt"></span></a>
					</span>

					<span ng-if="model.id != '{{ $logged_in_user->id }}'">
						@if ( in_array($logged_in_user->role, array("Owner", "Manager")) )
						<a href="{{ $data['url_pattern'] }}/edit/@{{ model.id }}" class="btn w3-brown btn-xs"><span class="fas fa-pencil-alt"></span></a>
						@else
						<span class="fas fa-pencil-alt"></span>
						@endif
					</span>
				@endif

				@if ( in_array($logged_in_user->role, array("Owner", "Manager")) )
					<span ng-if="model.id != 1">
					| <a href="javascript:void(0);" ng-click="delete_recover(model.id, model.DELETE_FLAG_ACTION)" class="btn @{{model.DELETED_RECOVER_COLOR}} btn-xs"><i class="@{{model.DELETED_RECOVER_ICON}}"></i></a>
					</span>

				@endif
			</td>
		</tr>
	</table>
	<br>

	@include('_include.user_pagination')
	<br>

</div>

</div> {{-- <div ng-app="myApp" ng-controller="myCtrl"> --}}

@include('_include.admin_footer', [
	'js_list'	=> true,
])
