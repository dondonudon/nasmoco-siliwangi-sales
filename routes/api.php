<?php

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;

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

Route::post('ms-user/login','MsUserController@loginAndroid');

Route::post('ms-userarea/check','MsUserAreaController@checkArea');

Route::post('spk/search','AndroidSPK@search');
Route::post('spk/area','AndroidSPK@getTrn');
Route::post('spk/save','AndroidSPK@comment');
Route::post('spk/update/target','AndroidSPK@updateTarget');

Route::post('upload-data-lama','OldDataUploader@upload');
