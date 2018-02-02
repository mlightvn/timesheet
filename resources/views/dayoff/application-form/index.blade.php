@include('_include.user_header',
	[
		'id'				=> 'dayoff_application',
	]
)

<div ng-app="myApp" ng-controller="myCtrl">

<div class="w3-row">
	<h1>各種申請一覧</h1>
	<br>
</div>

@include('_include.api_search', ['keyword'=>$data["keyword"]])

@if(session("message"))
	@include('_include.alert_message', ["message" => (isset($message) ? $message : session("message")), "alert_type" => (isset($alert_type) ? $alert_type : session("alert_type"))])
@endif

<div class="w3-row">
	<a href="{{ $data['url_pattern'] }}" class="w3-button w3-brown"><span class="glyphicon glyphicon-list"></span></a>&nbsp;
	<a href="{{ $data['url_pattern'] }}/add" class="w3-button w3-brown"><span class="glyphicon glyphicon-plus"></span></a>
	<br><br>

	{{ csrf_field() }}

	<input type="hidden" id="data_source_url" value="/api/application-form">

	<table class="timesheet_table w3-table-all w3-hoverable w3-striped w3-bordered">
		<thead>
		<tr class="w3-brown">
			<th>ID</th>
			<th>タイトル</th>
			<th>状態</th>
			<th>登録者</th>
			<th>承認者</th>
			<th></th>
		</tr>
		</thead>
		<tr class="" ng-repeat="model in model_list">
			<td>
				@{{ model.id }}
			</td>
			<td>
				<a href="{{ $data['url_pattern'] }}/view/@{{ model.id }}"><i class="fa fa-pencil"></i> @{{ model.name }}</a>
			</td>
			<td>
				@{{ model.STATUS_LABEL }}
			</td>
			<td>
				@{{ model.APPLIED_USER_NAME }}
			</td>
			<td>
				@{{ model.APPROVED_USER_NAME }}
			</td>
			<td>
				<a href="{{ $data['url_pattern'] }}/view/@{{ model.id }}"><i class="fa fa-pencil"></i></a>
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
