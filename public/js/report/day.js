$(function() {
	$('#datepicker').datepicker( {
		changeMonth: true
		, changeYear: true
		, inline: true

		// , dateFormat: 'yy-mm'
		, monthNames: [ "1月","2月","3月","4月","5月","6月","7月","8月","9月","10月","11月","12月" ]
		, monthNamesShort: [ "1月","2月","3月","4月","5月","6月","7月","8月","9月","10月","11月","12月" ]
		, dayNames: [ "日曜日","月曜日","火曜日","水曜日","木曜日","金曜日","土曜日" ]
		, dayNamesShort: [ "日曜","月曜","火曜","水曜","木曜","金曜","土曜" ]
		, dayNamesMin: [ "日","月","火","水","木","金","土" ]
		, weekHeader: "週"
		, showMonthAfterYear: true
		, yearSuffix: "年"
	})
	.datepicker("option", {
		"dateFormat": "yy-mm-dd"
	}) // YYYY/MM/DD をセット
	.datepicker("setDate", $('#sRequestDate').val())
	.datepicker("option", "onChangeMonthYear", function (year, month) {
			year_month = year + "-" + (month < 10 ? ("0" + month) : month);
			$argument = {page:1,year_month:year_month};
			angular.element($('[ng-app="myApp"][ng-controller="myCtrl"]')).scope().get($argument);
		})
	;

	$('[action="reset"]').click(function(event) {
		$('#datepicker').datepicker('setDate', null);

		$current_date = new Date();
		year = $current_date.getFullYear();
		month = $current_date.getMonth();

		year_month = year + "-" + (month < 10 ? ("0" + month) : month);
		$argument = {page:1,year_month:year_month};
		angular.element($('[ng-app="myApp"][ng-controller="myCtrl"]')).scope().get($argument);
	});

});