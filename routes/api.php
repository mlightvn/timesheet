<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
	return $request->user();
});


// Route::group(['prefix' => 'api', 'middleware' => ['admin']], function(){
// 	Route::group(['prefix' => 'domain'], function(){
// 		Route::get('', 'Ajax\DomainController@index');
// 		Route::get('index', 'Ajax\DomainController@index');
// 	});
// });


Route::group(['prefix' => '', 'middleware' => ['admin']], function(){
	Route::group(['prefix' => 'work'], function(){
		Route::any('check-in', 'Api\Controller@workCheckIn');
		Route::any('check-out', 'Api\Controller@workCheckOut');
	});

	Route::group(['prefix' => 'report'], function(){
		Route::get('day', 'Api\Report\DayController@list');
	});

	Route::group(['prefix' => 'work-time'], function(){
		Route::get('month', 'Api\WorkTime\MonthController@list');
	});

	Route::group(['prefix' => 'cashflow'], function(){
		Route::get('', 'Api\CashFlowController@list');
		Route::get('list', 'Api\CashFlowController@list');

	});

	Route::group(['prefix' => 'domain'], function(){
		Route::get('', 'Api\DomainController@list');
		Route::get('list', 'Api\DomainController@list');

		Route::get('{id}/delete' 		, 'Api\DomainController@delete')->where('id', '[0-9]+');
		Route::get('{id}/recover' 		, 'Api\DomainController@recover')->where('id', '[0-9]+');

		Route::group(['prefix' => 'key_file'], function(){
			Route::get('' 					, 'Api\DomainKeyFileController@list');
			Route::get('list' 				, 'Api\DomainKeyFileController@list');

			Route::post('upload' 			, 'Api\DomainKeyFileController@upload');
			Route::get('{id}/delete' 		, 'Api\DomainKeyFileController@delete')->where('id', '[0-9]+');
		});
	});

	Route::group(['prefix' => 'customer'], function(){
		Route::get('', 'Api\CustomerController@list');
		Route::get('list', 'Api\CustomerController@list');

		Route::get('{id}/delete' 		, 'Api\CustomerController@delete')->where('id', '[0-9]+');
		Route::get('{id}/recover' 		, 'Api\CustomerController@recover')->where('id', '[0-9]+');
	});

	Route::group(['prefix' => 'user'], function(){
		Route::group(['prefix' => 'user'], function(){
			Route::get('', 'Api\User\UserController@list');
			Route::get('list', 'Api\User\UserController@list');
		});

		Route::group(['prefix' => 'project'], function(){
			Route::get('', 'Api\User\ProjectController@list');
			Route::get('list', 'Api\User\ProjectController@list');

		});

		Route::group(['prefix' => 'department'], function(){
			Route::get('', 'Api\User\DepartmentController@list');
			Route::get('list', 'Api\User\DepartmentController@list');

		});

	});

	Route::group(['prefix' => 'manage'], function(){
		Route::group(['prefix' => 'user'], function(){
			Route::get('', 'Api\Manage\UserController@list');
			Route::get('list', 'Api\Manage\UserController@list');

			Route::get('{id}/delete' 		, 'Api\Manage\UserController@delete')->where('id', '[0-9]+');
			Route::get('{id}/recover' 		, 'Api\Manage\UserController@recover')->where('id', '[0-9]+');

			Route::any('picture/{user_id}'	, 'Api\Manage\UserController@uploadPicture')->where('id', '[0-9]+');

		});

		Route::group(['prefix' => 'project'], function(){
			Route::get('', 'Api\Manage\ProjectController@list');
			Route::get('list', 'Api\Manage\ProjectController@list');

			Route::get('{id}/delete' 		, 'Api\Manage\ProjectController@delete')->where('id', '[0-9]+');
			Route::get('{id}/recover' 		, 'Api\Manage\ProjectController@recover')->where('id', '[0-9]+');
		});

		Route::group(['prefix' => 'project_task'], function(){
			Route::get('', 'Api\Manage\ProjectTaskController@list');
			Route::get('list', 'Api\Manage\ProjectTaskController@list');

			Route::get('{id}/delete' 		, 'Api\Manage\ProjectTaskController@delete')->where('id', '[0-9]+');
			Route::get('{id}/recover' 		, 'Api\Manage\ProjectTaskController@recover')->where('id', '[0-9]+');

			Route::post('{id}/my-task' 		, 'Api\Manage\ProjectTaskController@myTask')->where('id', '[0-9]+');
			Route::post('{id}/excel-flag' 	, 'Api\Manage\ProjectTaskController@excelFlag')->where('id', '[0-9]+');
		});

		Route::group(['prefix' => 'department'], function(){
			Route::get('', 'Api\Manage\DepartmentController@list');
			Route::get('list', 'Api\Manage\DepartmentController@list');

			Route::get('{id}/delete' 		, 'Api\Manage\DepartmentController@delete')->where('id', '[0-9]+');
			Route::get('{id}/recover' 		, 'Api\Manage\DepartmentController@recover')->where('id', '[0-9]+');
		});

		Route::group(['prefix' => 'application-template'], function(){
			Route::get('', 'Api\ApplicationTemplateController@list');
			Route::get('list', 'Api\ApplicationTemplateController@list');

			Route::get('get/{id}', 'Api\ApplicationTemplateController@get')->where('id', '[0-9]+');

			Route::get('{id}/delete' 		, 'Api\ApplicationTemplateController@delete')->where('id', '[0-9]+');
			Route::get('{id}/recover' 		, 'Api\ApplicationTemplateController@recover')->where('id', '[0-9]+');
		});

	});

	Route::group(['prefix' => 'dayoff'], function(){
		Route::group(['prefix' => 'application-form'], function(){
			Route::get('', 'Api\ApplicationFormController@list');
			Route::get('list', 'Api\ApplicationFormController@list');
		});
	});

	Route::group(['prefix' => 'master'], function(){

		Route::group(['prefix' => 'user'], function(){
			Route::get('', 'Api\Master\UserController@list');
			Route::get('list', 'Api\Master\UserController@list');

			Route::get('{id}/delete' 		, 'Api\Master\UserController@delete')->where('id', '[0-9]+');
			Route::get('{id}/recover' 		, 'Api\Master\UserController@recover')->where('id', '[0-9]+');
		});

		Route::group(['prefix' => 'organization'], function(){
			Route::get('', 'Api\Master\OrganizationController@list');
			Route::get('list', 'Api\Master\OrganizationController@list');

			Route::get('{id}/delete' 		, 'Api\Master\OrganizationController@delete')->where('id', '[0-9]+');
			Route::get('{id}/recover' 		, 'Api\Master\OrganizationController@recover')->where('id', '[0-9]+');
		});

		Route::group(['prefix' => 'price'], function(){
			Route::get('', 'Api\Master\PriceController@list');
			Route::get('list', 'Api\Master\PriceController@list');

			Route::get('{id}/delete' 		, 'Api\Master\PriceController@delete')->where('id', '[0-9]+');
			Route::get('{id}/recover' 		, 'Api\Master\PriceController@recover')->where('id', '[0-9]+');
		});

	});

	Route::group(['prefix' => 'bookmark'], function(){
		Route::get('', 'Api\BookmarkController@list');
		Route::get('list', 'Api\BookmarkController@list');

		Route::get('{id}/delete' 		, 'Api\BookmarkController@delete')->where('id', '[0-9]+');
		Route::get('{id}/recover' 		, 'Api\BookmarkController@recover')->where('id', '[0-9]+');
	});

});
