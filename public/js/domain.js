function loadData($argument) {

	var app = angular.module('myApp', []);
	app.controller('myCtrl', function($scope, $http) {
		$scope.get = function ($argument) {
			url = "/api/domain", 
			config = {
				params: $argument,
				method : 'GET',
				headers : {'Accept' : 'application/json'}
			};

			// https://docs.angularjs.org/api/ng/service/$http#usage
			$http.get(url , config)
				.then(
					function(response) { // 成功
						$scope.model_list = response.data.data;
// console.log(response.data);

					}, function (response) { // エラー発生
						// $scope.myWelcome = response.statusText;
console.log($response);
					}
				);

		};

		$scope.loadData = function(){
			$(document).ready(function(){
				keyword = $('#keyword').val();

				$argument = {keyword: keyword};
				$scope.get($argument);
			});

		};

		$scope.get($argument);

	});
}

loadData();
