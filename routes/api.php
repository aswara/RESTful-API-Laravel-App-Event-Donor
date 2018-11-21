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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([
	'prefix' => 'pmi',
	'middleware' => 'cors'
	], function() {

		Route::resource('event', 'PmiEventController', [
			'except' => ['create', 'edit', 'delete', 'patch']
		]);

		Route::post('daftar', [
			'uses' => 'AuthPmiController@store'
		]);

		Route::post('masuk', [
			'uses' => 'AuthPmiController@signin'
		]);

		Route::get('user', [
			'uses' => 'AuthPmiController@index'
		]);
	});


Route::group([
	'prefix' => 'hero',
	'middleware' => 'cors'
	], function() {

		Route::post('daftar', [
			'uses' => 'AuthHeroController@store'
		]);

		Route::post('masuk', [
			'uses' => 'AuthHeroController@signin'
		]);

		Route::post('event', [
			'uses' => 'PesertaController@store'
		]);

		Route::get('events', [
			'uses' => 'PesertaController@events'
		]);

	});


Route::get('events', [
	'middleware' => 'cors',
	'uses' => 'EventController@index'
]);