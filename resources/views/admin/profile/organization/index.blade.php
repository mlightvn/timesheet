@include('_include.admin_header',
	[
		'id'				=> 'admin_profile_organization',
	]
)

<div class="w3-row">
	<h1>企業一覧</h1>
</div>

@include('_include.admin_search', ['keyword'=>$data["keyword"]])

@if(isset($message) || session("message"))
	@include('_include.alert_message', ["message" => (isset($message) ? $message : session("message")), "alert_type" => (isset($alert_type) ? $alert_type : session("alert_type"))])
@endif

<div class="w3-row">
	<button class="w3-button w3-brown" ng-click="reset()"><span class="fas fa-list-ul"></span></button>&nbsp;
	@if ( $logged_in_user->role == "Owner" )
	<a href="{{ $data['url_pattern'] }}/add" class="w3-button w3-brown"><span class="fas fa-plus"></span></a>
	@endif
	<br><br>
	<table class="timesheet_table w3-table-all w3-hoverable w3-striped w3-bordered">
		<thead>
		<tr class="w3-brown">
			<th>ID</th>
			<th>企業名</th>
			<th>Website</th>
			<th></th>
		</tr>
		</thead>
		@foreach($model_list as $key => $model)
		<tr class="{{ ($model->is_deleted == 1) ? 'w3-gray' : '' }}">
			<td>{{ $model->id }}</td>
			<td>
				<a href="{{ $data['url_pattern'] }}/edit/{{ $model->id }}"><span class="glyphicon glyphicon-pencil"></span> {{ $model->name }}</a>
			</td>
			<td><a href="{{ $model->website }}" target="_blank">{{ $model->website }}</a></td>
			<td>
			@if (($logged_in_user->role == "Owner") || ($logged_in_user->id == $model->id) )
				<a href="{{ $data['url_pattern'] }}/edit/{{ $model->id }}"><span class="glyphicon glyphicon-pencil"></span></a>
			@endif
			@if ( $logged_in_user->role == "Owner" )
				@if ( $model->role != "Owner" )
					@if ($model->is_deleted)
				| <a href="{{ $data['url_pattern'] }}/recover/{{ $model->id }}"><span class="fas fa-recycle w3-text-green"></span></a>
					@else
				| <a href="{{ $data['url_pattern'] }}/delete/{{ $model->id }}"><span class="fas fa-trash-alt w3-text-red"></span></a>
					@endif
				@endif
			@endif
			</td>
		</tr>
		@endforeach
	</table>
	<br>

	@if(count($model_list) == 0)
	データが存在していません。
	<br>
	@endif

	@include('_include.admin_pagination', ['list'=>$model_list, 'keyword'=>$data["keyword"]])
	<br>
</div>

@include('_include.admin_footer')
