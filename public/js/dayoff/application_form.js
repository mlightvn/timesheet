$(document).ready(function(){

	$date_list_a = {};

	/*
	 * Document:
	 *   http://xdsoft.net/jqplugins/datetimepicker/
	 *   http://www.daterangepicker.com/
	 *   https://jqueryui.com/datepicker/#inline
	 */
	$('[datepicker=datepicker]').datepicker({
			  minDate: 0
			, dateFormat: 'yy-mm-dd'

			, onSelect: function (dateText, inst) {
				$date_list_a[dateText] = 1;
				date_list_o = $('#date_list');

				date_list_s = "";
				$.each($date_list_a, function(index, value) {
					if(date_list_s == ""){
						date_list_s = index;
					}else{
						date_list_s += "\n" + index;
					}
				});

				date_list_o.val(date_list_s);
			}
	});

	$('[action=clear]').click(function(event) {
		object_name = $(this).val();
		$('#' + object_name).val('');
	});

	$('#application-template').change(function(event) {
		application_template_id = this.value;

		$.ajax({
			url: '/api/manage/application-template/get/' + application_template_id,
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
