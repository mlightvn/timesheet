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

Route::group(['prefix' => 'report'], function(){
	Route::get('time', 'Report\TimeController@index');
	Route::post('time', 'Report\TimeController@regist');

	Route::get('day', 'Report\DayController@index');
	Route::get('day_download_{year}_{month}', 'Report\DayController@download');

	Route::get('month', 'Report\MonthController@index');

	Route::get('task', 'Report\TaskController@index');
	Route::get('task_download_{year}_{month}', 'Report\TaskController@download');
});

Route::group(['prefix' => 'domain'], function()
{
	Route::get('', 'DomainController@index');
	Route::get('index', 'DomainController@index');

	Route::match(["get", "post"], 'add', 'DomainController@add');
	Route::match(["get", "post"], 'edit/{id}', 'DomainController@edit')->where('id', '[0-9]+');
	Route::get('delete/{id}', 'DomainController@delete')->where('id', '[0-9]+');
	Route::get('recover/{id}', 'DomainController@recover')->where('id', '[0-9]+');
});

Route::group(['prefix' => 'api', 'middleware' => ['admin']], function(){
	Route::group(['prefix' => 'domain'], function(){
		Route::get('', 'Api\DomainController@index');
		Route::get('index', 'Api\DomainController@index');
	});
});

Route::group(['prefix' => 'admin', 'middleware' => ['admin']], function()
{
	// Route::auth();

	Route::get('', 'Admin\Controller@dashboard');
	Route::get('index', 'Admin\Controller@dashboard');

	Route::group(['prefix' => 'task'], function()
	{
		Route::get('', 'Admin\TaskController@index');
		Route::get('index', 'Admin\TaskController@index');

		Route::match(["get", "post"], 'add', 'Admin\TaskController@add');
		Route::match(["get", "post"], 'edit/{task_id}', 'Admin\TaskController@edit')->where('task_id', '[0-9]+');
		Route::get('delete/{task_id}', 'Admin\TaskController@delete')->where('task_id', '[0-9]+');

		Route::post('update', 'Admin\TaskController@update');
		Route::get('recover/{task_id}', 'Admin\TaskController@recover')->where('task_id', '[0-9]+');
	});

	Route::group(['prefix' => 'organization'], function()
	{
		Route::get('', 'Admin\OrganizationController@index');
		Route::get('index', 'Admin\OrganizationController@index');

		Route::match(["get", "post"], 'add', 'Admin\OrganizationController@add');
		Route::match(["get", "post"], 'edit/{id}', 'Admin\OrganizationController@edit')->where('id', '[0-9]+');
		Route::get('delete/{id}', 'Admin\OrganizationController@delete')->where('id', '[0-9]+');
		Route::get('recover/{id}', 'Admin\OrganizationController@recover')->where('id', '[0-9]+');
	});

	Route::group(['prefix' => 'user'], function()
	{
		Route::get('', 'Admin\UserController@index');
		Route::get('index', 'Admin\UserController@index');

		Route::match(["get", "post"], 'add', 'Admin\UserController@add');
		Route::match(["get", "post"], 'edit/{user_id}', 'Admin\UserController@edit')->where('user_id', '[0-9]+');
		Route::get('delete/{user_id}', 'Admin\UserController@delete')->where('user_id', '[0-9]+');
		Route::get('recover/{user_id}', 'Admin\UserController@recover')->where('user_id', '[0-9]+');
	});

	Route::group(['prefix' => 'session'], function()
	{
		Route::get('', 'Admin\SessionController@index');
		Route::get('index', 'Admin\SessionController@index');

		Route::match(["get", "post"], 'add', 'Admin\SessionController@add');
		Route::match(["get", "post"], 'edit/{session_id}', 'Admin\SessionController@edit')->where('session_id', '[0-9]+');
		Route::get('delete/{session_id}', 'Admin\SessionController@delete')->where('session_id', '[0-9]+');
		Route::get('recover/{session_id}', 'Admin\SessionController@recover')->where('session_id', '[0-9]+');
	});

	Route::group(['prefix' => 'holiday'], function()
	{
		Route::get('', 'Admin\HolidayController@index');
		Route::get('index', 'Admin\HolidayController@index');

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

	Route::group(['prefix' => 'dayoff'], function()
	{
		Route::get('', 'Admin\DayoffController@index');
		Route::get('index', 'Admin\DayoffController@index');

		Route::match(["get", "post"], 'add', 'Admin\DayoffController@add');
		Route::match(["get", "post"], 'edit/{id}', 'Admin\DayoffController@edit')->where('id', '[0-9]+');
		Route::get('delete/{id}', 'Admin\DayoffController@delete')->where('id', '[0-9]+');
		Route::get('recover/{id}', 'Admin\DayoffController@recover')->where('id', '[0-9]+');
	});

	Route::group(['prefix' => 'profile'], function()
	{
		Route::group(['prefix' => 'organization'], function()
		{
			Route::match(["get", "post"], 'edit', 'Admin\Profile\OrganizationController@edit');
			Route::get('info', 'Admin\Profile\OrganizationController@info');
		});
	});

});

Route::group(['prefix' => 'bin'], function()
{

	Route::get('sendMessageToChatwork', 'BinController@sendMessageToChatwork');
	Route::match(['get', 'post'], 'pullSourceCode', 'BinController@pullSourceCode');

});
