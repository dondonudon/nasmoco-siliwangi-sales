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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard/login', 'Dashboard@loginCheck');
Route::post('/dashboard/login/check','Dashboard@login');
Route::get('/dashboard','Dashboard@index');

Route::get('/dashboard/master/user','MasterUser@index');
Route::get('/dashboard/master/user/list','MasterUser@list');
Route::post('/dashboard/master/user/new','MasterUser@new');
Route::post('/dashboard/master/user/edit','MasterUser@edit');
Route::post('/dashboard/master/user/disable','MasterUser@disable');

Route::get('/dashboard/master/area','MasterArea@index');
Route::get('/dashboard/master/area/list','MasterArea@list');

Route::get('/dashboard/master/leasing','MasterLeasing@index');
Route::get('/dashboard/master/leasing/list','MasterLeasing@list');

Route::get('/dashboard/penjualan/baru','PenjualanBaru@index');


