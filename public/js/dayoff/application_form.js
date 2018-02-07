$(document).ready(function(){

	start_date = moment().add(1, 'days');
	end_date = moment().add(1, 'days');

	/*
	 * Document:
	 *   http://xdsoft.net/jqplugins/datetimepicker/
	 *   http://www.daterangepicker.com/
	 */
	$('[daterangepicker=daterangepicker]').daterangepicker({
			  lang: "en"

			// , startDate: start_date
			// , endDate: end_date
			, minDate: 0

			, showDropdowns: true
			// , step: 30
			// , mask: true
			, timepicker: false
			// , timePickerIncrement: 5
			, locale: {
				// format: 'YYYY-MM-DD HH:mm'
				format: 'YYYY-MM-DD'
			}
	});

	// $('input[daterangepicker=daterangepicker]').on('apply.daterangepicker', function(ev, picker) {
	// });

	// $('input[daterangepicker=daterangepicker]').on('cancel.daterangepicker', function(ev, picker) {
	// });




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
