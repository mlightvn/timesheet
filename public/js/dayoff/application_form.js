$(document).ready(function(){
	/*
	 * Document:
	 *   http://xdsoft.net/jqplugins/datetimepicker/
	 */
	$('[datetimepicker=datetimepicker]').datetimepicker({
			  lang: "en"
			, minDate: 0
			, minTime:0
			, step:30
			, mask:true
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

});
