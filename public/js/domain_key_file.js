$(document).ready(function(){

	$('#selectFileUpload').change(function ($event) {
		FileUpload($event);
	});

});

// ブラウザ上でファイルを展開する挙動を抑止
function onDragOver($event) {
	$event.preventDefault();
}

// Drop領域にドロップしたファイル情報を読み取り
function onDrop($event) {
	FileUpload($event);
}

// ファイルアップロード
function FileUpload($event) {
	$(document).ready(function(){
		// ブラウザ上でファイルを展開する挙動を抑止
		$event.preventDefault();

		// ドロップされたファイルのfilesプロパティを参照
		$files = $event.target.files;
		if ($files.length < 1) {
			console.log("no file upload.");
			return;
		}

		form = $('form[enctype="multipart/form-data"]')[0];
		$formData = new FormData(form);

		$.each($files, function(key, $file)
		{
			$formData.append('file[' + key + ']', $file);
		});

		domain_id 					= $('[name=domain_id]').val();
		$formData.append('domain_id', domain_id);

		organization_id 			= $('[name=organization_id]').val();
		$formData.append('organization_id', organization_id);

		// _token 						= $('[name="_token"]').val();
		_token 						= $('meta[name="token"]').attr('value');

		url							= '/api/domain/key_file/upload';
		$post_data = {
			// url						: url,
			type					: 'POST',
			dataType				: 'json',
			data					: $formData,
			contentType 			: false,
			processData 			: false,
			headers: {
				"Authorization" 	: _token,
				'X-CSRF-TOKEN' 		: _token
			},
		};

		$.ajax(url
			, $post_data
		)
		.done(function($response, status) {
			console.log("done function");
// console.log($response);

			$('#divAlertBox').removeClass('w3-hide');
			$('#divAlertBox').removeClass('w3-green');
			// $('#divAlertBox').removeClass('w3-red');
			$('#divAlertBox').addClass($response["color_class"]);
			$('#divMessage').text($response["message"]);

		})
		.fail(function($response) {
			console.log("fail: エラー");
// console.log($response);
		})
		;

		// reload data
		$scope = angular.element($('[ng-app="myApp"][ng-controller="myCtrl"]')).scope();
		$scope.get();

		// $event.target.value = '';
		$('#selectFileUpload').val(null);

	});

}
