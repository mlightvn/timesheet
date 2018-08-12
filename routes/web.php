<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index');
Route::get('index', 'HomeController@index');

// Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();
Route::auth();


// Route::get('{locale}', function ($locale) {
//     App::setLocale($locale);

// });

Route::get('login', ['as' => 'login', 'uses' => 'Controller@login']);
Route::post('login', 'Controller@authenticate');
Route::any('logout', 'Controller@logout');
// Route::any('register', 'Controller@register');

Route::group(['prefix' => 'dashboard', 'middleware' => ['admin']], function(){
	Route::get('', 'DashboardController@dashboard');
	Route::post('index', 'DashboardController@dashboard');

});

Route::group(['prefix' => 'report', 'middleware' => ['admin']], function(){
	Route::get('time', 'Report\TimeController@index');
	Route::post('time', 'Report\TimeController@register');

	Route::get('day', 'Report\DayController@index');
	Route::get('day_download_{year}-{month}', 'Report\DayController@download');

	Route::get('month', 'Report\MonthController@index');


	Route::group(['prefix' => 'department'], function()
	{
		Route::get('', 'Report\DepartmentController@index');
		Route::get('index', 'Report\DepartmentController@index');

		// Route::get('{department_id}/download/{year}-{month}', 'Report\DepartmentController@reportDownload')->where('department_id', '[0-9]+');

		Route::get('download/{department_id}', 'Report\Controller@downloadByDepartment')->where('department_id', '[0-9]+');

	});

	Route::group(['prefix' => 'project'], function(){
		Route::get('', 'Report\ProjectController@index');
		Route::get('download', 'Report\Controller@downloadProject');

	});
});

Route::group(['prefix' => 'work-time'], function(){
	Route::get('month', 'WorkTime\MonthController@index');
});

Route::group(['prefix' => 'dayoff'], function()
{
	Route::get('', 'Dayoff\Controller@dashboard');

	Route::group(['prefix' => 'application-form'], function()
	{
		Route::get('', 'Dayoff\ApplicationFormController@list');
		Route::get('list', 'Dayoff\ApplicationFormController@list');

		Route::match(["get", "post"], 'add', 'Dayoff\ApplicationFormController@add');
		Route::get('{id}/view', 'Dayoff\ApplicationFormController@view')->where('id', '[0-9]+');

		Route::get('{id}/reject', 'Dayoff\ApplicationFormController@reject')->where('id', '[0-9]+');
		Route::get('{id}/approve', 'Dayoff\ApplicationFormController@approve')->where('id', '[0-9]+');
	});
});

Route::group(['prefix' => 'cashflow', 'middleware' => ['admin']], function()
{
	Route::get('', 'CashFlowController@list');
	Route::get('list', 'CashFlowController@list');

	Route::match(["get", "post"], 'add', 'CashFlowController@add');
	Route::match(["get", "post"], 'edit/{id}', 'CashFlowController@edit')->where('id', '[0-9]+');
	// Route::get('delete/{id}', 'CashFlowController@delete')->where('id', '[0-9]+');
	// Route::get('recover/{id}', 'CashFlowController@recover')->where('id', '[0-9]+');

});

Route::group(['prefix' => 'domain', 'middleware' => ['admin']], function()
{
	Route::get('', 'DomainController@list');
	Route::get('list', 'DomainController@list');

	Route::match(["get", "post"], 'add', 'DomainController@add');
	Route::match(["get", "post"], 'edit/{id}', 'DomainController@edit')->where('id', '[0-9]+');
	// Route::get('delete/{id}', 'DomainController@delete')->where('id', '[0-9]+');
	// Route::get('recover/{id}', 'DomainController@recover')->where('id', '[0-9]+');

	Route::get('edit/{id}/upload', 'DomainController@upload');
});

Route::group(['prefix' => 'api'], function(){
	Route::group(['prefix' => 'promotion'], function(){
		Route::get('', 'Api\PromotionController@list');
		Route::get('list', 'Api\PromotionController@list');
	});

	Route::group(['prefix' => 'price'], function(){
		Route::get('', 'Api\PriceController@list');
		Route::get('list', 'Api\PriceController@list');
	});

});

Route::group(['prefix' => 'customer'], function()
{
	Route::get('', 'CustomerController@list');
	Route::get('list', 'CustomerController@list');

	Route::match(["get", "post"], 'add', 'CustomerController@add');
	Route::match(["get", "post"], 'edit/{user_id}', 'CustomerController@edit')->where('user_id', '[0-9]+');

});

Route::group(['prefix' => 'manage', 'middleware' => ['admin']], function()
{
	Route::group(['prefix' => 'project'], function()
	{
		Route::get('', 'Manage\ProjectController@list');
		Route::get('list', 'Manage\ProjectController@list');

		Route::match(["get", "post"], 'add', 'Manage\ProjectController@add');
		Route::match(["get", "post"], 'edit/{id}', 'Manage\ProjectController@edit')->where('id', '[0-9]+');

		Route::post('update', 'Manage\ProjectController@update');
	});

	Route::group(['prefix' => 'project_task'], function()
	{
		Route::get('', 'Manage\ProjectTaskController@list');
		Route::get('list', 'Manage\ProjectTaskController@list');

		Route::match(["get", "post"], 'add', 'Manage\ProjectTaskController@add');
		Route::match(["get", "post"], 'edit/{id}', 'Manage\ProjectTaskController@edit')->where('id', '[0-9]+');

		Route::post('update', 'Manage\ProjectTaskController@update');
	});

	Route::group(['prefix' => 'user'], function()
	{
		Route::get('', 'Manage\UserController@list');
		Route::get('list', 'Manage\UserController@list');

		Route::match(["get", "post"], 'add', 'Manage\UserController@add');
		Route::match(["get", "post"], 'edit/{user_id}', 'Manage\UserController@edit')->where('user_id', '[0-9]+');
		Route::match(["get", "post"], 'user-info/{user_id}', 'Manage\UserController@editUserInfo')->where('user_id', '[0-9]+');
		Route::match(["get", "post"], 'language', 'Manage\UserController@language');
		Route::get('view/{user_id}', 'Manage\UserController@view')->where('user_id', '[0-9]+');
	});

	Route::group(['prefix' => 'department'], function()
	{
		Route::get('', 'Manage\DepartmentController@list');
		Route::get('list', 'Manage\DepartmentController@list');

		Route::match(["get", "post"], 'add', 'Manage\DepartmentController@add');
		Route::match(["get", "post"], 'edit/{department_id}', 'Manage\DepartmentController@edit')->where('department_id', '[0-9]+');

	});

	Route::group(['prefix' => 'application-template'], function()
	{
		Route::get('', 'Manage\ApplicationTemplateController@list');
		Route::get('list', 'Manage\ApplicationTemplateController@list');

		Route::match(["get", "post"], 'add', 'Manage\ApplicationTemplateController@add');
		Route::match(["get", "post"], 'edit/{id}', 'Manage\ApplicationTemplateController@edit')->where('id', '[0-9]+');

	});
});

Route::group(['prefix' => 'master', 'middleware' => ['admin']], function()
{

	Route::get('', 'Master\Controller@dashboard');
	Route::get('index', 'Master\Controller@dashboard');

	Route::group(['prefix' => 'user'], function()
	{

		Route::get('', 'Master\UserController@list');
		Route::get('list', 'Master\UserController@list');

		Route::match(["get", "post"], 'add', 'Master\UserController@add');
		Route::match(["get", "post"], 'edit/{id}', 'Master\UserController@edit')->where('id', '[0-9]+');
	});

	Route::group(['prefix' => 'organization'], function()
	{
		Route::get('', 'Master\OrganizationController@list');
		Route::get('list', 'Master\OrganizationController@list');

		Route::match(["get", "post"], 'add', 'Master\OrganizationController@add');
		Route::match(["get", "post"], 'edit/{id}', 'Master\OrganizationController@edit')->where('id', '[0-9]+');
	});

	Route::group(['prefix' => 'holiday'], function()
	{
		Route::get('', 'Master\HolidayController@list');
		Route::get('list', 'Master\HolidayController@list');

		Route::match(["get", "post"], 'add', 'Master\HolidayController@add');
		Route::match(["get", "post"], 'add', 'Master\HolidayController@add');

		Route::post('update', 'Master\HolidayController@update');
	});

	Route::group(['prefix' => 'price'], function(){
		Route::get('', 'Master\PriceController@list');
		Route::get('list', 'Master\PriceController@list');

		Route::get('{id}/delete' 		, 'Master\PriceController@delete')->where('id', '[0-9]+');
		Route::get('{id}/recover' 		, 'Master\PriceController@recover')->where('id', '[0-9]+');
	});

	Route::group(['prefix' => 'api'], function()
	{
		Route::get('list/{object_type}', 'Master\ApiController@list');
		Route::get('list/{object_type}/{keyword}', 'Master\ApiController@list');
		Route::get('get/{object_type}/{id}', 'Master\ApiController@get')->where('id', '[0-9]+');

		Route::post('add/{object_type}', 'Master\ApiController@add');
		Route::post('edit/{object_type}/{id}', 'Master\ApiController@edit');
	});

});

Route::group(['prefix' => 'bookmark'], function(){
	Route::get('', 'BookmarkController@list');
	Route::get('list', 'BookmarkController@list');

	Route::match(["get", "post"], 'add', 'BookmarkController@add');
	Route::match(["get", "post"], 'edit/{id}', 'BookmarkController@edit');

});

Route::group(['prefix' => 'profile', 'middleware' => ['admin']], function()
{
	Route::group(['prefix' => 'organization'], function()
	{
		Route::match(["get", "post"], 'edit', 'Profile\OrganizationController@edit');
		Route::get('info', 'Profile\OrganizationController@info');
	});
});

Route::group(['prefix' => 'bin', 'middleware' => ['admin']], function()
{

	Route::get('sendMessageToChatwork', 'BinController@sendMessageToChatwork');
	Route::match(['get', 'post'], 'pullSourceCode', 'BinController@pullSourceCode');

});

Route::group(['prefix' => 'price'], function(){
	Route::get('', 'PriceController@list');

});
