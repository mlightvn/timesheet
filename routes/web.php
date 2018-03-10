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

Route::get('login', ['as' => 'login', 'uses' => 'Controller@login']);
Route::post('login', 'Controller@authenticate');
Route::any('logout', 'Controller@logout');
// Route::any('register', 'Controller@register');

Route::group(['prefix' => 'report', 'middleware' => ['admin']], function(){
	Route::get('time', 'Report\TimeController@index');
	Route::post('time', 'Report\TimeController@regist');

	Route::get('day', 'Report\DayController@index');
	Route::get('day_download_{year}-{month}', 'Report\DayController@download');

	Route::get('month', 'Report\MonthController@index');


	Route::group(['prefix' => 'session'], function()
	{
		Route::get('', 'Report\SessionController@index');
		Route::get('index', 'Report\SessionController@index');

		Route::get('{session_id}/download/{year}-{month}', 'Report\SessionController@reportDownload')->where('session_id', '[0-9]+');
	});

	Route::get('project', 'Report\ProjectController@index');
	Route::get('project_download_{year}_{month}', 'Report\ProjectController@download');
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
		// Route::get('{id}/reject', 'Dayoff\ApplicationFormController@reject')->where('id', '[0-9]+');
		// Route::get('{id}/approve', 'Dayoff\ApplicationFormController@approve')->where('id', '[0-9]+');
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

Route::group(['prefix' => 'api', 'middleware' => ['admin']], function(){
	Route::group(['prefix' => 'report'], function(){
		Route::get('day', 'Api\Report\DayController@list');
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

		Route::group(['prefix' => 'session'], function(){
			Route::get('', 'Api\User\SessionController@list');
			Route::get('list', 'Api\User\SessionController@list');

		});

	});

	Route::group(['prefix' => 'manage'], function(){
		Route::group(['prefix' => 'user'], function(){
			Route::get('', 'Api\Manage\UserController@list');
			Route::get('list', 'Api\Manage\UserController@list');

			Route::get('{id}/delete' 		, 'Api\Manage\UserController@delete')->where('id', '[0-9]+');
			Route::get('{id}/recover' 		, 'Api\Manage\UserController@recover')->where('id', '[0-9]+');
		});

		Route::group(['prefix' => 'project'], function(){
			Route::get('', 'Api\Manage\ProjectController@list');
			Route::get('list', 'Api\Manage\ProjectController@list');

			Route::get('{id}/delete' 		, 'Api\Manage\ProjectController@delete')->where('id', '[0-9]+');
			Route::get('{id}/recover' 		, 'Api\Manage\ProjectController@recover')->where('id', '[0-9]+');
		});

		Route::group(['prefix' => 'session'], function(){
			Route::get('', 'Api\Manage\SessionController@list');
			Route::get('list', 'Api\Manage\SessionController@list');

			Route::get('{id}/delete' 		, 'Api\Manage\SessionController@delete')->where('id', '[0-9]+');
			Route::get('{id}/recover' 		, 'Api\Manage\SessionController@recover')->where('id', '[0-9]+');
		});

	});

	Route::group(['prefix' => 'application-form'], function(){
		Route::get('', 'Api\ApplicationFormController@list');
		Route::get('list', 'Api\ApplicationFormController@list');
	});

	Route::group(['prefix' => 'application-template'], function(){
		Route::get('', 'Api\ApplicationTemplateController@list');
		Route::get('list', 'Api\ApplicationTemplateController@list');

		Route::get('get/{id}', 'Api\ApplicationTemplateController@get')->where('id', '[0-9]+');

		Route::get('{id}/delete' 		, 'Api\ApplicationTemplateController@delete')->where('id', '[0-9]+');
		Route::get('{id}/recover' 		, 'Api\ApplicationTemplateController@recover')->where('id', '[0-9]+');
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

	Route::group(['prefix' => 'user'], function()
	{
		Route::get('', 'Manage\UserController@list');
		Route::get('list', 'Manage\UserController@list');

		Route::match(["get", "post"], 'add', 'Manage\UserController@add');
		Route::match(["get", "post"], 'edit/{user_id}', 'Manage\UserController@edit')->where('user_id', '[0-9]+');
		Route::get('view/{user_id}', 'Manage\UserController@view')->where('user_id', '[0-9]+');
	});

	Route::group(['prefix' => 'session'], function()
	{
		Route::get('', 'Manage\SessionController@list');
		Route::get('list', 'Manage\SessionController@list');

		Route::match(["get", "post"], 'add', 'Manage\SessionController@add');
		Route::match(["get", "post"], 'edit/{session_id}', 'Manage\SessionController@edit')->where('session_id', '[0-9]+');

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

	Route::group(['prefix' => 'api'], function()
	{
		Route::get('list/{object_type}', 'Master\ApiController@list');
		Route::get('list/{object_type}/{keyword}', 'Master\ApiController@list');
		Route::get('get/{object_type}/{id}', 'Master\ApiController@get')->where('id', '[0-9]+');

		Route::post('add/{object_type}', 'Master\ApiController@add');
		Route::post('edit/{object_type}/{id}', 'Master\ApiController@edit');
	});

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
