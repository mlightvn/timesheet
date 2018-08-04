$(function() {
	$('#picture').change(function($event) {
		let file_name = $(this).val();
		if(file_name == ''){
			return;
		}

		uploadPicture($event);

	});

	function uploadPicture($event) {
		$event.preventDefault();

		let $lblMessage = $('#lblMessage');

		let $files = $event.target.files;
		if ($files && $files.length < 1) {
			// console.log("no file upload.");
			return;
		}else{
			let picture = $('#picture').val();
			if(picture == ""){
				$lblMessage.text('写真を選択してください。');
				$lblMessage.css('color', '#f00');
				return;
			}
		}

		let $form = $('#user_card_form')[0];

		let $formData = new FormData($form);
		let id = $("[name=id]").val();
		let url = '/api/manage/user/picture/' + id;

		let $request = $formData;

		$.ajax({
			url: url,
			type: 'POST',
			dataType: 'json',
			data: $request,
			cache: false,
			contentType: false,
			processData: false
		})
		.done(function($response) {
			// console.log("success");
			// console.log($response);
			if($response.profile_picture){
				let timestamp = Date.now();
				$('[name=profile_picture]').attr('src', $response.profile_picture + "?" + timestamp);
			}

		})
		.fail(function($response) {
			console.log("error");
			console.log($response);

		})
		;

		$('#picture').val('');

	}

});