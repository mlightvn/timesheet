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
