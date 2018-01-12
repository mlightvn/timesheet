@include('_include.admin_header',
	[
		'id'				=> 'task_list',
	]
)

<div ng-app="myApp" ng-controller="myCtrl">

<div class="w3-row">
	<h1>プロジェクト一覧</h1>
	<br>
</div>

@include('_include.admin_search', ['keyword'=>$data["keyword"]])

@if(session("message"))
	@include('_include.alert_message', ["message" => (isset($message) ? $message : session("message")), "alert_type" => (isset($alert_type) ? $alert_type : session("alert_type"))])
@endif

<div class="w3-row">
	<a href="{{ $data['url_pattern'] }}" class="w3-button w3-brown"><span class="glyphicon glyphicon-list"></span></a>&nbsp;
	<a href="{{ $data['url_pattern'] }}/add" class="w3-button w3-brown"><span class="glyphicon glyphicon-plus"></span></a>
	<br><br>

	<form action="{{ $data['url_pattern'] }}/update" method="post">
	{{ csrf_field() }}
	<input type="hidden" id="data_source_url" value="/api/manage/project">

	<table class="timesheet_table w3-table-all w3-hoverable w3-striped w3-bordered">
		<thead>
		<tr class="w3-brown">
			<th>ID</th>
			@if ( in_array($logged_in_user->permission_flag, array("Administrator")) )
			<th>企業名</th>
			@endif
			<th>休憩のフラグ</th>
			<th>プロジェクト</th>
			<th>自分のプロジェクト</th>
			<th></th>
		</tr>
		</thead>

		<tr class="" ng-repeat="model in model_list">
			<td>@{{ model.id }}</td>
			@if ( in_array($logged_in_user->permission_flag, array("Administrator")) )
			<td>@{{ model.organization_name }}</td>
			@endif
			<td>
				<label class="switch">
					<input type="checkbox" name="task[@{{ model.id }}][is_off_task]" value="1" @{{ ((model.is_off_task) ? 'checked="checked"' : '') }} {{ ($logged_in_user->permission_flag == "Member") ? 'disabled="disabled' : '' }}>
					<span class="slider round"></span>
				</label>
			</td>
			<td><a href="{{ $data['url_pattern'] }}/edit/@{{ model.id }}">@{{ model.name }}</a></td>
			<td>
				<label class="switch">
					<input type="checkbox" name="task[@{{ model.id }}][user_id]" @{{ ((model.id) ? 'checked="checked"' : '') }}>
					<span class="slider round"></span>
				</label>
			</td>
			<td><a href="{{ $data['url_pattern'] }}/edit/@{{ model.id }}"><span class="glyphicon glyphicon-pencil"></span></a>
				@if (in_array($logged_in_user->permission_flag, array("Administrator", "Manager")))
				<span ng-if="model.is_deleted == true">
					| <a href="{{ $data['url_pattern'] }}/recover/@{{ model.id }}"><span class="fa fa-recycle w3-text-green"></span></a>
				</span>
				<span ng-if="model.is_deleted == false">
					| <a href="{{ $data['url_pattern'] }}/delete/@{{ model.id }}"><span class="fa fa-trash w3-text-red"></span></a>
				</span>
				@endif
			</td>
		</tr>

		<tfoot>
		<tr>
			<td colspan="5">
				<div class="w3-center">
					<button type="submit" class="w3-button w3-brown w3-xlarge">　　<span class="fa fa-pencil"></span> 登録　　</button>
				</div>
			</td>
		</tr>
		</tfoot>
	</table>
	</form>
	<br>

	<div ng-if="model_list.total == 0">
		データが存在していません。
	</div>
	<br>

	<div class="w3-row">
		<div class="w3-col s12 m12 l12 w3-center">
			<list-pagination></list-pagination>
		</div>
	</div>
	<br>

</div>

</div> {{-- <div ng-app="myApp" ng-controller="myCtrl"> --}}


@include('_include.admin_footer', [
	'js_list'			=> true,
	'js'				=> 'manage/project',
])
