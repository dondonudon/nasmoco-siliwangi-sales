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
//    return view('welcome');
    return redirect('dashboard/login');
});

Route::get('/dashboard/register', 'Dashboard@register')->name('dashboard_register');
Route::post('/dashboard/register/submit', 'Dashboard@registerSubmit')->name('dashboard_register_submit');

Route::get('/dashboard/login', 'Dashboard@login')->name('dashboard_login');
Route::post('/dashboard/login/check','Dashboard@loginCheck');
Route::get('/dashboard/session/flush','Dashboard@sessionFLush');

Route::get('/dashboard','Dashboard@index')->name('dashboard_overview');

Route::get('/dashboard/system/menu','SystemMenu@index')->name('system_menu');
Route::get('/dashboard/system/menu/list','SystemMenu@list');
Route::get('/dashboard/system/menu/list/group','SystemMenu@group');
Route::post('/dashboard/system/menu/add','SystemMenu@add');
Route::post('/dashboard/system/menu/edit','SystemMenu@edit');

Route::get('/dashboard/system/group-menu','SystemGroupMenu@index')->name('system_menu_group');
Route::get('/dashboard/system/group-menu/list','SystemGroupMenu@list');
Route::post('/dashboard/system/group-menu/add','SystemGroupMenu@add');
Route::post('/dashboard/system/group-menu/edit','SystemGroupMenu@edit');

Route::get('/dashboard/master/user','MasterUser@index')->name('master_user');
Route::get('/dashboard/master/user/list','MasterUser@list');
Route::post('/dashboard/master/user/new','MasterUser@new');
Route::post('/dashboard/master/user/edit','MasterUser@edit');
Route::post('/dashboard/master/user/disable','MasterUser@disable');
Route::post('/dashboard/master/user/permission','MasterUser@permission');

Route::get('/dashboard/master/profile','MasterProfile@index')->name('master_profile');
Route::post('/dashboard/master/profile/detail','MasterProfile@detail');
Route::post('/dashboard/master/profile/edit','MasterProfile@edit');

Route::get('/dashboard/master/area','MasterArea@index')->name('master_area');
Route::get('/dashboard/master/area/list','MasterArea@list');
Route::post('/dashboard/master/area/add','MasterArea@add');
Route::post('/dashboard/master/area/edit','MasterArea@edit');

Route::get('/dashboard/master/leasing','MasterLeasing@index')->name('master_leasing');
Route::get('/dashboard/master/leasing/list','MasterLeasing@list');
Route::post('/dashboard/master/leasing/add','MasterLeasing@add');
Route::post('/dashboard/master/leasing/edit','MasterLeasing@edit');
Route::post('/dashboard/master/leasing/delete','MasterLeasing@delete');

Route::get('/dashboard/penjualan/baru','PenjualanBaru@index')->name('penjualan_baru');
Route::get('/dashboard/penjualan/baru/list','PenjualanBaru@list');
Route::get('/dashboard/penjualan/baru/leasing','PenjualanBaru@leasing');
Route::get('/dashboard/penjualan/baru/kota','PenjualanBaru@kota');
Route::post('/dashboard/penjualan/baru/kecamatan','PenjualanBaru@kecamatan');
Route::post('/dashboard/penjualan/baru/add','PenjualanBaru@add');

Route::get('/dashboard/penjualan/summary','PenjualanSummary@index')->name('penjualan_summary');
Route::post('/dashboard/penjualan/summary/list','PenjualanSummary@getPenjualan');
Route::get('/dashboard/penjualan/summary/{start}/{end}/{status}','PenjualanSummary@fullscreen')->name('penjualan_full');
Route::post('/dashboard/penjualan/summary/spk/detail','PenjualanSummary@getDetailSPK');
Route::post('/dashboard/penjualan/summary/spk/difference','PenjualanSummary@getDifference');
