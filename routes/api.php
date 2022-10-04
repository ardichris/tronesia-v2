<?php

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


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
Route::post('/livetracking', 'API\LiveTrackingController@requestLiveTracking');
Route::put('/livetracking', 'API\LiveTrackingController@updateLiveTracking');
Route::group(['middleware' => 'auth:api'], function() {
    Route::get('/', 'FrontController@statistik');
    Route::resource('/teachers', 'API\UserController')->except(['create', 'show', 'update']);
    Route::post('/teachers/{id}', 'API\UserController@update')->name('teachers.update');
    Route::resource('/pelanggaran', 'API\PelanggaranController')->except(['create', 'show']);
    Route::post('/pelanggaran/{id}', 'API\PelanggaranController@update')->name('pelanggarans.update');
    Route::resource('/mapel', 'API\MapelController')->except(['create', 'show']);
    Route::resource('/kelas', 'API\KelasController')->except(['create', 'show']);
    Route::put('/kelas/addanggota','API\KelasController@tambahAnggota');
    Route::get('/kelas/anggotakelas/{kode}','API\KelasController@getAnggota');
    Route::resource('/masterpelanggaran', 'API\MasterPelanggaranController')->except(['create', 'show']);
    Route::resource('/barang', 'API\BarangController')->except(['create', 'show']);
    Route::resource('/pemakaianbarang', 'API\PemakaianBarangController')->except(['create', 'show']);
    Route::get('/pemakaianbarang/list/{kode}','API\PemakaianBarangController@listPemakaian');
    Route::put('/pemakaianbarang/changestatus/{kode}','API\PemakaianBarangController@changeStatus');
    Route::resource('/barangmasuk', 'API\BarangMasukController')->except(['create', 'show']);
    Route::get('/barangmasuk/list/{kode}','API\BarangMasukController@listBarangmasuk');
    Route::resource('/kompetensi', 'API\KompetensiController')->except(['create','show']);
    Route::resource('/seragam', 'API\SeragamController')->except(['create', 'show']);
    Route::put('/jurnal/changestatus/{kode}','API\JurnalController@changeJMstatus');
    Route::get('/jurnal/rekap','API\JurnalController@rekap');
    Route::get('/jurnal/roster','API\JurnalController@roster');
    Route::get('/presensi/rekap', 'API\PresensiController@rekap');
    Route::resource('/jurnal', 'API\JurnalController')->except(['create', 'show']);
    Route::get('roles', 'API\RolePermissionController@getAllRole')->name('roles');
    Route::resource('/absensi', 'API\AbsensiController')->except(['create', 'show']);
    Route::get('permissions', 'API\RolePermissionController@getAllPermission')->name('permission');
    Route::post('role-permission', 'API\RolePermissionController@getRolePermission')->name('role_permission');
    Route::post('set-role-permission', 'API\RolePermissionController@setRolePermission')->name('set_role_permission');
    Route::post('set-role-user', 'API\RolePermissionController@setRoleUser')->name('user.set_role');
    Route::get('user-authenticated', 'API\UserController@getUserLogin')->name('user.authenticated');
    Route::get('user-lists', 'API\UserController@userLists')->name('user.index');
    Route::resource('/siswas', 'API\SiswaController')->except(['show']);
    Route::get('/siswas/rekap', 'API\SiswaController@siswaAktif');
    Route::resource('/laporsarpras', 'API\LaporSarprasController');
    Route::put('/laporsarpras/changestatus/{kode}','API\LaporSarprasController@changeStatus');
    Route::resource('/kitirsiswa', 'API\KitirSiswaController');
    Route::put('/kitirsiswa/changestatus/{kode}','API\KitirSiswaController@changeStatus');
    Route::resource('/presensi', 'API\PresensiController');
    Route::resource('/pengumuman', 'API\PengumumanController')->except(['create', 'show']);
    Route::resource('/unit', 'API\UnitController')->except(['create', 'show']);
    Route::resource('/jammengajar', 'API\JamMengajarController');
    Route::resource('/jadwalpelajaran','API\JadwalPelajaranController');
    Route::resource('/nilaisiswa', 'API\NilaiSiswaController');
    Route::post('/nilaisiswa/nilaiki12', 'API\NilaiSiswaController@nilaiki12');
    Route::get('exportsiswa', 'API\SiswaController@exportSiswa');
    Route::resource('/rapor', 'API\RaporController');
    Route::resource('/raporakhir', 'API\RaporAkhirController');
    Route::post('/raporakhir/import', 'API\RaporAkhirController@import');
    Route::post('/siswa/import', 'API\SiswaController@import');
    Route::resource('/siswaptm', 'API\SiswaPtmController');
    Route::post('/siswaptm/absenmasuk', 'API\SiswaPtmController@absenmasuk');
    Route::delete('/siswaptm/absenmasuk/{kode}', 'API\SiswaPtmController@hapusAbsen');
    Route::put('/siswaptm/dijemput/{kode}', 'API\SiswaPtmController@dijemput');
    Route::put('/siswaptm/suhupulang/{kode}', 'API\SiswaPtmController@suhupulang');
    Route::resource('/raporakhir', 'API\RaporAkhirController');
    Route::resource('/raporpetra', 'API\RaporPetraController');
    Route::get('/laporan/rapor_sisipan', 'API\RaporAkhirController@raporSisipanPDF');
    Route::get('/raporsisipan/view', 'API\RaporAkhirController@raporSisipanView');
    Route::put('/raporsisipan/{kode}', 'API\RaporAkhirController@raporSisipanStore');
    Route::get('/siswa/export/qrcode', 'API\SiswaController@exportQRCode')->name('qrcode.pdf');
    Route::get('exportrapor', 'API\RaporAkhirController@exportRapor');
    Route::get('/pelanggaran/total', 'API\PelanggaranController@total');
    Route::put('/absensi/changestatus/{kode}','API\AbsensiController@changeStatus');
    Route::get('/laporan/kesiswaan/absensi','API\LaporanController@absensi');
    Route::resource('notification', 'API\NotificationController')->except(['create', 'destroy']);
    Route::resource('settingsisipan', 'API\SisipanFieldController');





});



