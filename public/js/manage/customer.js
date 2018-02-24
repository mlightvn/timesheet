$(function() {

	$( "[datepicker=datepicker]" ).datepicker({
			  changeMonth: true
			, changeYear: true

			, monthNames: [ "1","2","3","4","5","6","7","8","9","10","11","12" ]
			, monthNamesShort: [ "1","2","3","4","5","6","7","8","9","10","11","12" ]
			// , dayNames: [ "日曜日","月曜日","火曜日","水曜日","木曜日","金曜日","土曜日" ]
			// , dayNamesShort: [ "日曜","月曜","火曜","水曜","木曜","金曜","土曜" ]
			// , dayNamesMin: [ "日","月","火","水","木","金","土" ]
			// , weekHeader: "週"
			// , showMonthAfterYear: true
			// , yearSuffix: "年"

			, showButtonPanel: true
			// , currentText: "今月"
			, dateFormat: "yy-mm-dd"
		});

});