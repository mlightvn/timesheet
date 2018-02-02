$(document).ready(function(){
	/*
	 * Document:
	 *   http://xdsoft.net/jqplugins/datetimepicker/
	 */
	$('[datetimepicker=datetimepicker]').datetimepicker({
			  lang: "en"
			, minDate: 0
			// , minTime: 0
			, step: 30
			, mask: true
			, format: "Y-m-d H:i"
			// , defaultDate:new Date()
			// , defaultTime:"01:00"

			// , onSelectDate: function (dateText, $element) {
			// 		date = $element.val();
			// 		addTimeSheet(date);
			// 	}
			// , onSelectTime: function (dateText, $element) {
			// 		date = $element.val();
			// 		addTimeSheet(date);
			// 	}
	});

	$('#application-template').change(function(event) {
		application_template_id = this.value;

		$.ajax({
			url: '/api/application-template/get/' + application_template_id,
			type: 'GET',
			dataType: 'json',
			data: {},
		})
		.done(function($response) {
			// console.log("success");
			$('#description').val($response['description']);
		})
		.fail(function($response) {
			console.log("error");
			console.log($response);
		})
		.always(function() {
			// console.log("complete");
		});
		
	});

});
