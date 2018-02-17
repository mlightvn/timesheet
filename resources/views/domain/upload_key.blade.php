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
	<a href="{{ $data['url_pattern'] }}" class="w3-button w3-brown"><span class="glyphicon glyphicon-list"></span></a>&nbsp;
	<a href="{{ $data['url_pattern'] }}/add" class="w3-button w3-brown"><span class="glyphicon glyphicon-plus"></span></a>
	<br><br>
</div>

<div class="w3-row">
	@if(isset($message) || session("message"))
		@include('_include.alert_message', ["message" => (isset($message) ? $message : session("message"))])
	@endif

	<form action="{{ $data['url_pattern'] }}/upload" method="post" enctype="multipart/form-data">
	{{ csrf_field() }}

		<div class="col-xs-4">

			<div class="panel panel-default panel-body" ondragover="onDragOver(event)" ondrop="onDrop(event)">
				<div class="droparea col-xs-12 text-center">
					<i class="fa fa-cloud-upload fa-cloud-upload-org-silver fa-4x"></i>
					<div class="progress progress-striped fileUploadBar active">
						<div class="progress-bar" style="width: 0%"></div>
					</div>
					<label class="control-label label-text-silver fileUploadLabel">ここに添付ファイルを
						<br/>ドロップしてください</label>
					<button type="button" class="btn btn-block fileUploadBtn" onclick="$('#selectFileUpload').click();"><i class="fa fa-folder-open fa-fw"></i> CSVファイル選択</button>
				</div>
				<!--<form name="selectFileUpload">-->
					<input type="file" id="selectFileUpload" style="display:none;" onchange="alert(document.getElementByID("selectFileUpload").value);">
				<!--</form>-->
			</div>

		</div>
	</form>

	<table class="timesheet_table w3-table-all w3-hoverable w3-striped w3-bordered">
		<tr class="w3-brown">
			<th>#</th>
			<th>ファイル名</th>
			<th>削除</th>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td><a href="javascript:void(0);"><i class="fa fa-trash"></i></a></td>
		</tr>
	</table>

</div>

</div> {{-- <div ng-app="myApp" ng-controller="myCtrl"> --}}

@include('_include.admin_footer')
