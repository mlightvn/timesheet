$(function() {
	$('.datepicker').datepicker( {
		  changeYear: true
		, showButtonPanel: true
		, inline: true
		, dateFormat: 'yy'
	})
	// .datepicker("option", "onChangeMonthYear", function (year, month) {
	// 		year_month = year + "-" + (month < 10 ? ("0" + month) : month);
	// 		$argument = {page:1,year_month:year_month};
	// 		// angular.element($('[ng-app="myApp"][ng-controller="myCtrl"]')).scope().get($argument);
	// 	})
	;
});