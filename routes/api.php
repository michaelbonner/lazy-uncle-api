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

Route::namespace('Api')->prefix('user')->group(function () {
	Route::post('/', [
		'uses' => 'UserController@store',
		'as' => 'api.user.store'
	]);
});

Route::group([
	'prefix' => 'auth',
	'namespace' => 'Api',
], function () {
	Route::post('login', [
		'as' => 'api.auth.login',
		'uses' => 'UserController@login',
	]);
	Route::post('logout', [
		'as' => 'api.auth.logout',
		'uses' => 'AuthController@logout',
	]);
	Route::post('refresh', [
		'as' => 'api.auth.refresh',
		'uses' => 'AuthController@refresh',
	]);
	Route::post('me', [
		'as' => 'api.auth.me',
		'uses' => 'AuthController@me',
	]);
});

Route::group([
	'prefix' => 'person',
	'namespace' => 'Api',
	'middleware' => 'auth:api',
], function () {
	Route::post('/', [
		'as' => 'api.person.store',
		'uses' => 'PersonController@store',
	]);
	Route::get('/', [
		'as' => 'api.person.index',
		'uses' => 'PersonController@index',
	]);
	Route::get('/{id}', [
		'as' => 'api.person.show',
		'uses' => 'PersonController@show',
	]);
	Route::patch('/{id}', [
		'as' => 'api.person.update',
		'uses' => 'PersonController@update',
	]);
	Route::delete('/{id}', [
		'as' => 'api.person.destroy',
		'uses' => 'PersonController@destroy',
	]);
});
