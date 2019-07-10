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

Route::get('/dashboard/system/menu','SystemMenu@index');
Route::get('/dashboard/system/menu/list','SystemMenu@list');
Route::get('/dashboard/system/menu/list/group','SystemMenu@group');
Route::post('/dashboard/system/menu/add','SystemMenu@add');
Route::post('/dashboard/system/menu/edit','SystemMenu@edit');

Route::get('/dashboard/system/group-menu','SystemGroupMenu@index');
Route::get('/dashboard/system/group-menu/list','SystemGroupMenu@list');
Route::post('/dashboard/system/group-menu/add','SystemGroupMenu@add');
Route::post('/dashboard/system/group-menu/edit','SystemGroupMenu@edit');

Route::get('/dashboard/master/user','MasterUser@index');
Route::get('/dashboard/master/user/list','MasterUser@list');
Route::post('/dashboard/master/user/new','MasterUser@new');
Route::post('/dashboard/master/user/edit','MasterUser@edit');
Route::post('/dashboard/master/user/disable','MasterUser@disable');

Route::get('/dashboard/master/area','MasterArea@index');
Route::get('/dashboard/master/area/list','MasterArea@list');
Route::post('/dashboard/master/area/add','MasterArea@add');
Route::post('/dashboard/master/area/edit','MasterArea@edit');

Route::get('/dashboard/master/leasing','MasterLeasing@index');
Route::get('/dashboard/master/leasing/list','MasterLeasing@list');
Route::post('/dashboard/master/leasing/add','MasterLeasing@add');
Route::post('/dashboard/master/leasing/edit','MasterLeasing@edit');
Route::post('/dashboard/master/leasing/delete','MasterLeasing@delete');

Route::get('/dashboard/penjualan/baru','PenjualanBaru@index');
Route::get('/dashboard/penjualan/baru/list','PenjualanBaru@list');
Route::get('/dashboard/penjualan/baru/leasing','PenjualanBaru@leasing');
Route::get('/dashboard/penjualan/baru/kota','PenjualanBaru@kota');
Route::post('/dashboard/penjualan/baru/kecamatan','PenjualanBaru@kecamatan');
Route::post('/dashboard/penjualan/baru/add','PenjualanBaru@add');


