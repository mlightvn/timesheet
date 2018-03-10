$(document).ready(function(){

	$('#check-in').click(function($argument) {
		$argument.preventDefault();

		// $form = $('form[method="post"]')[0];
		// $formData = new FormData($form);

		url = '/api/work/check-in';

		$.ajax({
			url 					: url,
			type 					: 'POST',
			dataType 				: 'json',
			// data					: $formData,
			contentType 			: false,
			processData 			: false,
			cache 					: false
		})
		.done(function($response) {
			if($response["status"] == 0){
				console.log("success");

				curDate = new Date();
				time_s = curDate.getHours() + ":" + curDate.getMinutes();
				$('#workTimeIn').text(time_s);
				$('#check-in').hide();
			}else{
				console.log($response["message"]);
			}
		})
		.fail(function($response) {
			console.log("error");
			console.log($response);
		})
		;

	});

	$('#check-out').click(function($argument) {
		// $form = $('form[method="post"]')[0];
		// $formData = new FormData($form);

		url = '/api/work/check-out';

		$.ajax({
			url 					: url,
			type 					: 'POST',
			dataType 				: 'json',
			// data: $formData,
			contentType 			: false,
			processData 			: false,
			cache 					: false
		})
		.done(function($response) {
			if($response["status"] == 0){
				console.log("success");

				curDate = new Date();
				time_s = curDate.getHours() + ":" + curDate.getMinutes();
				$('#workTimeOut').text(time_s);
				$('#check-out').hide();
			}else{
				console.log($response["message"]);
			}
		})
		.fail(function($response) {
			console.log("error");
			console.log($response);
		})
		;

	});
});
