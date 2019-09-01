<?php

use Illuminate\Http\Request;
<<<<<<< HEAD
use Illuminate\Support\Facades\Route;
=======
>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac

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
<<<<<<< HEAD

Route::post('upload-data-lama','OldDataUploader@upload');
=======
>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac
