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
Route::post('/login', 'Auth\LoginController@login');
Route::group(['middleware' => 'auth:api'], function() {
    Route::get('/', 'FrontController@statistik');
    Route::resource('/teachers', 'API\UserController')->except(['create', 'show', 'update']);
    Route::post('/teachers/{id}', 'API\UserController@update')->name('teachers.update');
    Route::resource('/pelanggaran', 'API\PelanggaranController')->except(['create', 'show']);
    Route::post('/pelanggaran/{id}', 'API\PelanggaranController@update')->name('pelanggarans.update');
    Route::resource('/absensi', 'API\AbsensiController')->except(['create', 'show']);
    Route::resource('/mapel', 'API\MapelController')->except(['create', 'show']);
    Route::resource('/kelas', 'API\KelasController')->except(['create', 'show']);
    Route::resource('/barang', 'API\BarangController')->except(['create', 'show']);
    Route::resource('/kompetensi', 'API\KompetensiController')->except(['create','show']);
    Route::put('/jurnal/changestatus/{kode}','API\JurnalController@changeJMstatus');
    Route::resource('/jurnal', 'API\JurnalController')->except(['create', 'show']);
    Route::get('roles', 'API\RolePermissionController@getAllRole')->name('roles');
    Route::get('permissions', 'API\RolePermissionController@getAllPermission')->name('permission');
    Route::post('role-permission', 'API\RolePermissionController@getRolePermission')->name('role_permission');
    Route::post('set-role-permission', 'API\RolePermissionController@setRolePermission')->name('set_role_permission');
    Route::post('set-role-user', 'API\RolePermissionController@setRoleUser')->name('user.set_role');
    Route::get('user-authenticated', 'API\UserController@getUserLogin')->name('user.authenticated');
    Route::get('user-lists', 'API\UserController@userLists')->name('user.index');
    
});

Route::resource('/siswas', 'API\SiswaController')->except(['show']);


