$(document).ready(function(){

	$('#selectFileUpload').change(function (evt) {
		files = evt.target.files;
		if (files.length >= 1) {
			FileUpload(files);
		}
	});

});

// ブラウザ上でファイルを展開する挙動を抑止
function onDragOver(event) {
	event.preventDefault();
}

// Drop領域にドロップしたファイル情報を読み取り
function onDrop(event) {
	// ブラウザ上でファイルを展開する挙動を抑止
	event.preventDefault();

	// ドロップされたファイルのfilesプロパティを参照
	var files = event.dataTransfer.files;
	if (files.length >= 1) {
		FileUpload(files);
	}
}

// ファイルアップロード
function FileUpload(files) {
	$(document).ready(function(){
		formData = new FormData();

		$.each(files, function(key, value)
		{
			formData.append('file[' + key + "]", value);
		});

		// formData.append('file', f);

		domain_id 					= $('domain_id').val();
		formData.append('domain_id', domain_id);

	// 	$.ajax({
	// 		type 					: 'POST',
	// 		url 					: '/api/domain/key_file/upload',
	// 		dataType 				: "json",
	// 		contentType 			: false,
	// 		// contentType 			: "application/json; charset=utf-8",
	// 		processData 			: false,
	// 		data 					: formData,
	// 		success 				: function($response) {
	// 			matches = $response["message"].match(/\d*/);

	// 			if(matches != null && matches != ""){
	// console.log("アップロード完了。");
	// 				// $("#message").html('<div class="alert alert-success">アップロード完了。　' + $response["message"] + '件　登録しました。</div>');
	// 			}else{
	// console.log("エラー");
	// console.log($response);
	// 				// $("#message").html('<div class="alert alert-danger">' + $response["message"] + '</div>');
	// 			}
	// 		}
	// 	})
	// 	.fail(function($response) {
	// console.log("エラー");
	// console.log($response);
	// 	})
	// 	;


		$.ajax({
			url						: '/api/domain/key_file/upload-key',
			type					: 'post',
			dataType				: 'json',
			data					: formData,
			contentType 			: false,
			processData 			: false
		})
		.done(function($response) {
			console.log("success");
console.log($response);
		})
		.fail(function($response) {
console.log("fail: エラー");
console.log($response);
		})
		// .always(function() {
		// 	console.log("complete");
		// })
		;

	});

}
