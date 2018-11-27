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

Route::post('login',    'API\PassportController@login');
//Route::post('register', 'API\PassportController@register');

Route::group(['middleware' => 'auth:api'], function(){
    Route::post('get-details', 'API\PassportController@getDetails');
});

Route::get('address', function () {
    return response()->json(['address' => '15431 SW 14th St', 'city'=>'Davie', 'state' => 'CA', 'zip'=>'33326']);
});

/* so how do I know they are loged in or have a good token   */
Route::group(['middleware' => ['auth:api']], function () {
    Route::post('/v1/products/create',                       'RequestController@create');
    Route::post('/v1/serial_numbers/{sku}/reserve',          'RequestController@reserve');
    Route::post('/v1/serial_numbers/{sku}/{serial_number}/release', 'RequestController@release');
    Route::get( '/v1/serial_numbers/{sku}/{serial_number}/status',  'RequestController@status');
});