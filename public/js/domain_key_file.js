$(document).ready(function(){

	// $('.fileUploadBtn').click(function(event) {
	// 	FileUpload(event);
	// });

	$('#selectFileUpload').change(function ($event) {
		FileUpload($event);
	});

// 	$('[action=delete]').click(function(event) {
// console.log("action delete");
// return;
// 		value = $(this).attr("value");
// 		url = '/api/domain/key_file/delete/' + value;

// 		$.ajax({
// 			url: url,
// 			type: 'GET',
// 			dataType: 'json',
// 			data: {id: value}
// 		})
// 		.done(function($response) {
// 			console.log("success");
// console.log($response);

// 			$scope = angular.element($('[ng-app="myApp"][ng-controller="myCtrl"]')).scope();
// 			$scope.get();
// 		})
// 		.fail(function() {
// 			console.log("error");
// 		})
// 		// .always(function() {
// 		// 	console.log("complete");
// 		// });

// 	});

});

// function deleteData(argument) {
// 	$(document).ready(function(){
// 		$scope = angular.element($('[ng-app="myApp"][ng-controller="myCtrl"]')).scope();
// 		$scope.delete = function (argument) {
// 			if(!$argument["id"]){
// 				$argument["id"] 				= id;
// 			}else{
// console.log("no id to delete.");
// 				return;
// 			}

// 			url = '/api/domain/key_file/delete/' + id;

// 			config = {
// 				params: $argument,
// 				method : 'GET',
// 				headers : {'Accept' : 'application/json'}
// 			};

// 			$.ajax({
// 				url: url,
// 				type: 'GET',
// 				dataType: 'json',
// 				data: {id: value}
// 			})
// 			.done(function($response) {
// 				console.log("success");
// console.log($response);

// 				$scope = angular.element($('[ng-app="myApp"][ng-controller="myCtrl"]')).scope();
// 				$scope.get();
// 			})

// 		};

// 	});

// }

// deleteData();

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

			$scope = angular.element($('[ng-app="myApp"][ng-controller="myCtrl"]')).scope();
			$scope.get();

		})
		.fail(function($response) {
			console.log("fail: エラー");
// console.log($response);
		})
		;

	});

}
