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

Route::get('/', function () {
    return view('welcome');
});*/
Route::get('/laporan/cetak_pdf', 'API\JurnalController@rekapJurnalPDF')->name('jurnal.pdf');
Route::get('/laporan/raporsisipan', 'API\RaporSisipanController@raporSisipanPDF')->name('sisipan.pdf');
Route::post('/livetracking', 'API\LiveTrackingController@requestLiveTracking');
Route::get('/{any}', 'FrontController@index')->where('any', '.*');
