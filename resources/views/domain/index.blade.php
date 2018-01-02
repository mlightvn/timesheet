@include('_include.user_header',
	[
		'id'				=> 'domain_list',
	]
)

<div ng-app="myApp" ng-controller="myCtrl">

<div class="w3-row">
	<h1>ドメイン一覧</h1>
	<br>
</div>

<div class="w3-row">
	<div class="w3-col s12 m12 l12">

		<form method="GET" action="{{ $data['url_pattern'] }}" accept-charset="UTF-8" role="search">

			<div class="form-group form-inline">
				<label class="control-label" for="keyword">キーワード：</label>

				<div class="input-group">
					<input placeholder="キーワード" class="form-control" id="keyword" name="keyword" type="text" ng-keypress="loadData()">

					<span class="input-group-btn">
						<button type="button" class="btn w3-brown" ng-click="loadData()"><span class="glyphicon glyphicon-search"></span></button>
					</span>
				</div>
				<button type="reset" class="btn w3-brown"><span class="glyphicon glyphicon-refresh"></span></button>
			</div>

		</form>
	</div>
</div>

@if(session("message"))
	@include('_include.alert_message', ["message" => (isset($message) ? $message : session("message")), "alert_type" => (isset($alert_type) ? $alert_type : session("alert_type"))])
@endif

<div class="w3-row">
	<a href="{{ $data['url_pattern'] }}" class="w3-button w3-brown"><span class="glyphicon glyphicon-list"></span></a>&nbsp;
	<a href="{{ $data['url_pattern'] }}/add" class="w3-button w3-brown"><span class="glyphicon glyphicon-plus"></span></a>
	<br><br>

	<form action="{{ $data['url_pattern'] }}/update" method="post">
	{{ csrf_field() }}
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
		<tr class="" ng-repeat="model in model_list">
			<td>
				@{{ model.id }}
			</td>
			<td>
				<a href="?development_flag=@{{ model.development_flag }}"><i class="fa fa-search"></i> @{{ model.development_flag_label }}</a></td>
			<td>
				<a href="{{ $data['url_pattern'] }}/edit/@{{ model.id }}"><i class="fa fa-pencil"></i> @{{ model.name }}</a><br><br>
				サイト： <a href="@{{ model.url }}">@{{ model.url }}</a><br>
				管理： <a href="@{{ model.admin_url }}">@{{ model.admin_url }}</a>
			</td>
			<td>
				SSH： @{{ model.ssh_access_command }}
				<br>
				DB： @{{ model.db_access_command }}
			</td>
			<td>
				<a href="{{ $data['url_pattern'] }}/edit/@{{ model.id }}"><i class="fa fa-pencil"></i></a>
				@if(in_array($logged_in_user->permission_flag, array("Administrator", "Manager")))
					<span ng-if="model.is_deleted == 1">
				| <a href="{{ $data['url_pattern'] }}/recover/@{{ model.id }}"><i class="fa fa-recycle w3-text-green"></i></a>
					</span>
					<span ng-if="model.is_deleted == 0">
				| <a href="{{ $data['url_pattern'] }}/delete/@{{ model.id }}"><i class="fa fa-trash w3-text-red"></i></a>
					</span>
				@endif
			</td>
		</tr>

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

@include('_include.user_footer', [
		'id'				=> 'domain',
		'js'				=> 'domain',
])
