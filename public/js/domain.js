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
					function($response) { // 成功
						$scope.model_list = $response.data.data;
// console.log($response.data);

						$scope.last_page   = $response.last_page;
						$scope.current_page  = $response.current_page;

						// Pagination Range
						pages = [];

						for(i=1;i<=$response.last_page;i++) {          
							pages.push(i);
						}

						$scope.range = pages; 

					}, function ($response) { // エラー発生
						// $scope.myWelcome = $response.statusText;
console.log($response);
					}
				);

			pagination($argument);

		};

		$scope.loadData = function(page){
			$(document).ready(function(){
				keyword = $('#keyword').val();

				$argument = {keyword: keyword, page: page};
				$scope.get($argument);
			});

		};

		$scope.get($argument);

	});
}

loadData();
// pagination();

function pagination($argument) {
	var app = angular.module('myApp', []);

	app.directive('list-pagination', function(){
		return{
			restrict: 'E',
			template: '<ul class="pagination">'+
				'<li ng-show="current_page != 1"><a href="javascript:void(0)" ng-click="loadData(1)">&laquo;</a></li>'+
				'<li ng-show="current_page != 1"><a href="javascript:void(0)" ng-click="loadData(current_page-1)">&lsaquo; Prev</a></li>'+
				'<li ng-repeat="i in range" ng-class="{active : current_page == i}">'+
				'<a href="javascript:void(0)" ng-click="loadData(i)">{{i}}</a>'+
				'</li>'+
				'<li ng-show="current_page != last_page"><a href="javascript:void(0)" ng-click="loadData(current_page+1)">Next &rsaquo;</a></li>'+
				'<li ng-show="current_page != last_page"><a href="javascript:void(0)" ng-click="loadData(last_page)">&raquo;</a></li>'+
				'</ul>'
			};
	});
}