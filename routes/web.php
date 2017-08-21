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

Route::group(['prefix' => 'admin', 'middleware' => ['admin']], function()
{
	Route::auth();

	Route::get('login', 'AdminController@login');
	Route::post('login', 'AdminController@authenticate');
	Route::any('logout', 'AdminController@logout');

	Route::get('', 'AdminController@index');
	Route::get('index', 'AdminController@index');

	Route::group(['prefix' => 'report'], function(){
		Route::get('time', 'AdminTimeReportController@index');
		Route::post('time', 'AdminTimeReportController@regist');

		Route::get('day', 'AdminDayReportController@index');
		Route::get('day_download_{year}_{month}', 'AdminDayReportController@download');

		Route::get('month', 'AdminMonthReportController@index');

		Route::get('task', 'AdminTaskReportController@index');
		Route::get('task_download_{year}_{month}', 'AdminTaskReportController@download');
	});

	Route::group(['prefix' => 'task'], function()
	{
		Route::get('', 'AdminTaskController@index');
		Route::get('index', 'AdminTaskController@index');

		Route::match(["get", "post"], 'add', 'AdminTaskController@add');
		Route::match(["get", "post"], 'edit/{task_id}', 'AdminTaskController@edit')->where('task_id', '[0-9]+');
		Route::get('delete/{task_id}', 'AdminTaskController@delete')->where('task_id', '[0-9]+');

		Route::post('update', 'AdminTaskController@update');
		Route::get('recover/{task_id}', 'AdminTaskController@recover')->where('task_id', '[0-9]+');
	});

	Route::group(['prefix' => 'user'], function()
	{
		Route::get('', 'AdminUserController@index');
		Route::get('index', 'AdminUserController@index');

		Route::match(["get", "post"], 'add', 'AdminUserController@add');
		Route::match(["get", "post"], 'edit/{user_id}', 'AdminUserController@edit')->where('user_id', '[0-9]+');
		Route::get('delete/{user_id}', 'AdminUserController@delete')->where('user_id', '[0-9]+');
		Route::get('recover/{user_id}', 'AdminUserController@recover')->where('user_id', '[0-9]+');
	});

	Route::group(['prefix' => 'session'], function()
	{
		Route::get('', 'AdminSessionController@index');
		Route::get('index', 'AdminSessionController@index');

		Route::match(["get", "post"], 'add', 'AdminSessionController@add');
		Route::match(["get", "post"], 'edit/{session_id}', 'AdminSessionController@edit')->where('session_id', '[0-9]+');
		Route::get('delete/{session_id}', 'AdminSessionController@delete')->where('session_id', '[0-9]+');
		Route::get('recover/{session_id}', 'AdminSessionController@recover')->where('session_id', '[0-9]+');
	});

	Route::group(['prefix' => 'holiday'], function()
	{
		Route::get('', 'AdminHolidayController@index');
		Route::get('index', 'AdminHolidayController@index');

		Route::match(["get", "post"], 'add', 'AdminHolidayController@add');
		Route::match(["get", "post"], 'add', 'AdminHolidayController@add');
		// Route::get('delete/{date}', 'AdminHolidayController@delete');

		Route::post('update', 'AdminHolidayController@update');
	});

	Route::group(['prefix' => 'api'], function()
	{
		Route::get('list/{object_type}', 'AdminApiController@list');
		Route::get('list/{object_type}/{keyword}', 'AdminApiController@list');
		Route::get('get/{object_type}/{id}', 'AdminApiController@get')->where('id', '[0-9]+');

		Route::post('add/{object_type}', 'AdminApiController@add');
		Route::post('edit/{object_type}/{id}', 'AdminApiController@edit');
	});

});

Route::group(['prefix' => 'bin'], function()
{

	Route::get('sendMessageToChatwork', 'BinController@sendMessageToChatwork');
	Route::match(['get', 'post'], 'pullSourceCode', 'BinController@pullSourceCode');

});
