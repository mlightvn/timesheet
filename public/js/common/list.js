function loadData($argument) {

	app = angular.module('myApp', []);
	app.controller('myCtrl', function($scope, $http) {
		$scope.get = function ($argument) {
			$(document).ready(function(){
				keyword 					= $('#keyword').val();
				data_source_url 			= $('#data_source_url').val();

				if(!$argument){
					$argument 							= {};
				}
				if(!$argument["keyword"]){
					$argument["keyword"] 				= keyword;
				}
				if(!$argument["data_source_url"]){
					$argument["data_source_url"] 		= data_source_url;
				}

				// $argument = {data_source_url: data_source_url, keyword: keyword, page: page};

				url = $argument["data_source_url"];
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

							$scope.last_page   = $response.data.last_page;
							$scope.current_page  = $response.data.current_page;

							// Pagination Range
							pages = [];

							for(i=1;i<=$response.data.last_page;i++) {
								pages.push(i);
							}

							$scope.range = pages; 

						}, function ($response) { // エラー発生
							// $scope.myWelcome = $response.statusText;
console.log($response);
						}
					);

				pagination(app, $argument);

			});
		};

		$scope.loadData = function(page, keyword){
			$argument = {page: page, keyword: keyword};
			$scope.get($argument);

		};

		$scope.reset = function(event){
			$(document).ready(function(){
				$('form[role=search]').trigger('reset');
				$argument = {page: 1};
				$scope.get($argument);
			});
		};

		$scope.get($argument);

	});

	pagination(app, $argument);
}

function pagination(app, $argument) {
	keyword 			= ($argument && $argument["keyword"]) ? $argument["keyword"] : null;

	// https://docs.angularjs.org/guide/directive
	app.directive('listPagination', function(){
			template = 
					'<div ng-show="last_page > 1">'
					+ 	'<ul class="pagination">'
					+ 		'<li ng-show="1 < current_page"><a href="javascript:void(0)" ng-click="loadData(1, ' + keyword + ')">&laquo;</a></li>'
					+ 		'<li ng-show="1 < current_page"><a href="javascript:void(0)" ng-click="loadData(current_page-1, ' + keyword + ')">&lsaquo;</a></li>'
					+ 		'<li ng-repeat="i in range" ng-class="{active : current_page == i}">'
					+ 		'<a href="javascript:void(0)" ng-click="loadData(i, ' + keyword + ')">{{i}}</a>'
					+ 		'</li>'
					+ 		'<li ng-show="current_page < last_page"><a href="javascript:void(0)" ng-click="loadData(current_page+1, ' + keyword + ')">&rsaquo;</a></li>'
					+ 		'<li ng-show="current_page < last_page"><a href="javascript:void(0)" ng-click="loadData(last_page, ' + keyword + ')">&raquo;</a></li>'
					+ 	'</ul>'
					+ '</div>'
					;
		return {
			restrict: 'E',
			template: template
			};
	});
}

loadData();
