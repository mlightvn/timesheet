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

Route::get('/', 'UserController@index');
Route::get('index', 'UserController@index');

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
	Route::get('day_download_{year}_{month}', 'Report\DayController@download');

	Route::get('month', 'Report\MonthController@index');

	Route::get('project', 'Report\ProjectController@index');
	Route::get('project_download_{year}_{month}', 'Report\ProjectController@download');
});

Route::group(['prefix' => 'dayoff'], function()
{
	Route::get('', 'Dayoff\Controller@dashboard');

	Route::group(['prefix' => 'dayoff'], function()
	{
		Route::get('', 'Dayoff\DayoffController@list');
		Route::get('list', 'Dayoff\DayoffController@list');

		Route::match(["get", "post"], 'add', 'Dayoff\DayoffController@add');
		Route::match(["get", "post"], 'edit/{id}', 'Dayoff\DayoffController@edit')->where('id', '[0-9]+');
		Route::get('delete/{id}', 'Dayoff\DayoffController@delete')->where('id', '[0-9]+');
		Route::get('recover/{id}', 'Dayoff\DayoffController@recover')->where('id', '[0-9]+');
	});

	Route::group(['prefix' => 'application-form'], function()
	{
		Route::get('', 'Dayoff\ApplicationFormController@list');
		Route::get('list', 'Dayoff\ApplicationFormController@list');

		Route::match(["get", "post"], 'add', 'Dayoff\ApplicationFormController@add');
		Route::match(["get", "post"], 'edit/{id}', 'Dayoff\ApplicationFormController@edit')->where('id', '[0-9]+');
		Route::get('delete/{id}', 'Dayoff\ApplicationFormController@delete')->where('id', '[0-9]+');
		Route::get('recover/{id}', 'Dayoff\ApplicationFormController@recover')->where('id', '[0-9]+');
	});
});

Route::group(['prefix' => 'domain', 'middleware' => ['admin']], function()
{
	Route::get('', 'DomainController@list');
	Route::get('list', 'DomainController@list');

	Route::match(["get", "post"], 'add', 'DomainController@add');
	Route::match(["get", "post"], 'edit/{id}', 'DomainController@edit')->where('id', '[0-9]+');
	Route::get('delete/{id}', 'DomainController@delete')->where('id', '[0-9]+');
	Route::get('recover/{id}', 'DomainController@recover')->where('id', '[0-9]+');
});

Route::group(['prefix' => 'api', 'middleware' => ['admin']], function(){
	Route::group(['prefix' => 'domain'], function(){
		Route::get('', 'Api\DomainController@list');
		Route::get('list', 'Api\DomainController@list');
	});

	Route::group(['prefix' => 'manage'], function(){
		Route::group(['prefix' => 'user'], function(){
			Route::get('', 'Api\Manage\UserController@list');
			Route::get('list', 'Api\Manage\UserController@list');
		});

		Route::group(['prefix' => 'customer'], function(){
			Route::get('', 'Api\Manage\CustomerController@list');
			Route::get('list', 'Api\Manage\CustomerController@list');
		});

		Route::group(['prefix' => 'project'], function(){
			Route::get('', 'Api\Manage\ProjectController@list');
			Route::get('list', 'Api\Manage\ProjectController@list');
		});

		Route::group(['prefix' => 'session'], function(){
			Route::get('', 'Api\Manage\SessionController@list');
			Route::get('list', 'Api\Manage\SessionController@list');
		});
	});

	Route::group(['prefix' => 'dayoff'], function(){

		Route::group(['prefix' => 'application-form'], function(){
			Route::get('', 'Api\Dayoff\ApplicationFormController@list');
			Route::get('list', 'Api\Dayoff\ApplicationFormController@list');
		});
	});

	Route::group(['prefix' => 'application-template'], function(){
		Route::get('', 'Api\ApplicationTemplateController@list');
		Route::get('list', 'Api\ApplicationTemplateController@list');

		Route::get('get/{id}', 'Api\ApplicationTemplateController@get')->where('id', '[0-9]+');
	});

	Route::group(['prefix' => 'admin'], function(){

		Route::group(['prefix' => 'organization'], function(){
			Route::get('', 'Api\Admin\OrganizationController@list');
			Route::get('list', 'Api\Admin\OrganizationController@list');
		});
	});

});

Route::group(['prefix' => 'manage', 'middleware' => ['admin']], function()
{
	Route::group(['prefix' => 'project'], function()
	{
		Route::get('', 'Manage\ProjectController@list');
		Route::get('list', 'Manage\ProjectController@list');

		Route::match(["get", "post"], 'add', 'Manage\ProjectController@add');
		Route::match(["get", "post"], 'edit/{id}', 'Manage\ProjectController@edit')->where('id', '[0-9]+');
		Route::get('delete/{id}', 'Manage\ProjectController@delete')->where('id', '[0-9]+');

		Route::post('update', 'Manage\ProjectController@update');
		Route::get('recover/{id}', 'Manage\ProjectController@recover')->where('id', '[0-9]+');
	});

	Route::group(['prefix' => 'user'], function()
	{
		Route::get('', 'Manage\UserController@list');
		Route::get('list', 'Manage\UserController@list');

		Route::match(["get", "post"], 'add', 'Manage\UserController@add');
		Route::match(["get", "post"], 'edit/{user_id}', 'Manage\UserController@edit')->where('user_id', '[0-9]+');
		Route::get('delete/{user_id}', 'Manage\UserController@delete')->where('user_id', '[0-9]+');
		Route::get('recover/{user_id}', 'Manage\UserController@recover')->where('user_id', '[0-9]+');
	});

	Route::group(['prefix' => 'customer'], function()
	{
		Route::get('', 'Manage\CustomerController@list');
		Route::get('list', 'Manage\CustomerController@list');

		Route::match(["get", "post"], 'add', 'Manage\CustomerController@add');
		Route::match(["get", "post"], 'edit/{user_id}', 'Manage\CustomerController@edit')->where('user_id', '[0-9]+');
		Route::get('delete/{user_id}', 'Manage\CustomerController@delete')->where('user_id', '[0-9]+');
		Route::get('recover/{user_id}', 'Manage\CustomerController@recover')->where('user_id', '[0-9]+');
	});

	Route::group(['prefix' => 'session'], function()
	{
		Route::get('', 'Manage\SessionController@list');
		Route::get('list', 'Manage\SessionController@list');

		Route::match(["get", "post"], 'add', 'Manage\SessionController@add');
		Route::match(["get", "post"], 'edit/{session_id}', 'Manage\SessionController@edit')->where('session_id', '[0-9]+');
		Route::get('delete/{session_id}', 'Manage\SessionController@delete')->where('session_id', '[0-9]+');
		Route::get('recover/{session_id}', 'Manage\SessionController@recover')->where('session_id', '[0-9]+');
	});

	// Route::group(['prefix' => 'application-form'], function()
	// {
	// 	Route::get('', 'Manage\ApplicationFormController@list');
	// 	Route::get('list', 'Manage\ApplicationFormController@list');

	// 	Route::match(["get", "post"], 'edit/{id}', 'Manage\ApplicationFormController@edit')->where('id', '[0-9]+');
	// });

	Route::group(['prefix' => 'application-template'], function()
	{
		Route::get('', 'Manage\ApplicationTemplateController@list');
		Route::get('list', 'Manage\ApplicationTemplateController@list');

		Route::match(["get", "post"], 'add', 'Manage\ApplicationTemplateController@add');
		Route::match(["get", "post"], 'edit/{id}', 'Manage\ApplicationTemplateController@edit')->where('id', '[0-9]+');
	});
});

Route::group(['prefix' => 'admin', 'middleware' => ['admin']], function()
{
	// Route::auth();

	Route::get('', 'Admin\Controller@dashboard');
	Route::get('index', 'Admin\Controller@dashboard');

	Route::group(['prefix' => 'organization'], function()
	{
		Route::get('', 'Admin\OrganizationController@list');
		Route::get('list', 'Admin\OrganizationController@list');

		Route::match(["get", "post"], 'add', 'Admin\OrganizationController@add');
		Route::match(["get", "post"], 'edit/{id}', 'Admin\OrganizationController@edit')->where('id', '[0-9]+');
		Route::get('delete/{id}', 'Admin\OrganizationController@delete')->where('id', '[0-9]+');
		Route::get('recover/{id}', 'Admin\OrganizationController@recover')->where('id', '[0-9]+');
	});

	Route::group(['prefix' => 'holiday'], function()
	{
		Route::get('', 'Admin\HolidayController@list');
		Route::get('list', 'Admin\HolidayController@list');

		Route::match(["get", "post"], 'add', 'Admin\HolidayController@add');
		Route::match(["get", "post"], 'add', 'Admin\HolidayController@add');
		// Route::get('delete/{date}', 'Admin\HolidayController@delete');

		Route::post('update', 'Admin\HolidayController@update');
	});

	Route::group(['prefix' => 'api'], function()
	{
		Route::get('list/{object_type}', 'Admin\ApiController@list');
		Route::get('list/{object_type}/{keyword}', 'Admin\ApiController@list');
		Route::get('get/{object_type}/{id}', 'Admin\ApiController@get')->where('id', '[0-9]+');

		Route::post('add/{object_type}', 'Admin\ApiController@add');
		Route::post('edit/{object_type}/{id}', 'Admin\ApiController@edit');
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
