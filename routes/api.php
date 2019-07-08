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

Route::get('ms-area','MsAreaController@index');
Route::post('ms-area/add','MsAreaController@add');

Route::get('ms-user','MsUserController@index');
Route::post('ms-user/add','MsUserController@add');
Route::post('ms-user/edit','MsUserController@edit');
Route::post('ms-user/login','MsUserController@loginAndroid');

Route::post('ms-leasing/add','MasterLeasing@add');

Route::post('ms-userarea/add','MsUserAreaController@add');
Route::post('ms-userarea/check','MsUserAreaController@checkArea');

Route::post('spk/search','AndroidSearchSpk@search');
