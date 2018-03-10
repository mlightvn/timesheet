@include('_include.admin_header',
	[
		'id'				=> 'domain_list',
	]
)

<div ng-app="myApp" ng-controller="myCtrl">

<div class="w3-row">
	<h1>ドメイン</h1>
	<br>
</div>

<div class="w3-row">
	<a href="{{ $data['url_pattern'] }}" class="w3-button w3-brown"><span class="fas fa-list-ul"></span></a>&nbsp;
	<a href="{{ $data['url_pattern'] }}/add" class="w3-button w3-brown"><span class="fas fa-plus"></span></a>
	<br><br>
</div>

<div class="w3-row">

	@if(isset($model))
	<div class="w3-bar w3-light-gray">
		<a class="w3-bar-item w3-button" href="{{ $data['url_pattern'] }}/edit/{{ $model->id }}">Domain</a>
		<a class="w3-bar-item w3-button" href="{{ $data['url_pattern'] }}/edit/{{ $model->id }}/upload">Key file</a>
	</div>
	@endif

	<br>
	<div id="divAlertBox" class="alert w3-hide">
		<span class="closebtn">&times;</span>
		<div id="divMessage"></div>
	</div>
	<br>

	<form method="post" enctype="multipart/form-data">
		{{ csrf_field() }}
		{!! Form::hidden('domain_id', $model->id) !!}
		{!! Form::hidden('organization_id', $model->organization_id) !!}

		<input type="hidden" id="data_source_url" value="/api/domain/key_file/list?domain_id={{$model->id}}">
		<input type="hidden" id="data_source_url_delete" value="/api/domain/key_file">

		<div class="col-xs-4">

			<div class="panel panel-default panel-body" ondragover="onDragOver(event)" ondrop="onDrop(event)">
				<div class="droparea col-xs-12 text-center">
					<i class="fas fa-cloud-upload-alt fa-cloud-upload-org-silver fa-4x"></i>
					<div class="progress progress-striped fileUploadBar active">
						<div class="progress-bar" style="width: 0%"></div>
					</div>
					<label class="control-label label-text-silver fileUploadLabel">ここに添付ファイルを
						<br/>ドロップしてください</label>
					<button type="button" class="btn btn-block fileUploadBtn" onclick="$('#selectFileUpload').click();"><i class="fas fa-folder-open fa-fw"></i> CSVファイル選択</button>
				</div>
				<!--<form name="selectFileUpload">-->
					<input type="file" id="selectFileUpload" name="selectFileUpload[]" style="display:none;" multiple="multiple">
				<!--</form>-->
			</div>

		</div>
	</form>

	<table class="timesheet_table w3-table-all w3-hoverable w3-striped w3-bordered">
		<tr class="w3-brown">
			<th>#</th>
			<th>Filename</th>
			<th></th>
		</tr>
		<tr ng-repeat="model in model_list">
			<td><span ng-bind="model.id"></span></td>
			<td>
				<a href="/storage/domain/@{{model.organization_id}}/@{{model.domain_id}}/@{{model.name}}" ng-bind="model.name" download="download"></a>
			</td>
			<td><a href="javascript:void(0);" ng-click="delete(model.id)"><i class="fas fa-trash-alt w3-text-red"></i></a></td>
		</tr>
	</table>

</div>

</div> {{-- <div ng-app="myApp" ng-controller="myCtrl"> --}}

@include('_include.admin_footer', [
	'js'					=> 'domain_key_file',
	'js_list'				=> true,
])
