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

Route::get('/login', 'AuthController@login')->name('login');
Route::post('/postlogin', 'AuthController@postlogin')->name('postlogin');
Route::get('/logout', 'AuthController@logout')->name('logout');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'DashboardController@getDataBulanIni')->name('getDataBulanIni');
    Route::get('/data/tahun', 'DashboardController@getDataTahunIni')->name('getDataTahunIni');
    Route::get('/data/bulan', 'DashboardController@getDataBulanIni')->name('getDataBulanIni');

    Route::get('/transaksi/beli', 'TransaksiBeliController@beli')->name('transaksiBeli');
    Route::post('/transaksi/beli', 'TransaksiBeliController@beliStore')->name('transaksiBeliStore');
    Route::get('/transaksi/beli/index', 'TransaksiBeliController@indexTransaksiBeli')->name('indexTransaksiBeli');
    Route::get('/transaksi/beli/data', 'TransaksiBeliController@dataTransaksiBeli')->name('dataTransaksiBeli');
    Route::post('/transaksi/beli/update', 'TransaksiBeliController@update')->name('transaksiBeliUpdate');
    Route::delete('/transaksi/beli/delete/{id}', 'TransaksiBeliController@delete')->name('transaksiBeliDelete');

    Route::get('/transaksi/jual', 'TransaksiJualController@jual')->name('transaksiJual');
    Route::post('/transaksi/jual', 'TransaksiJualController@jualStore')->name('transaksiJualStore');
    Route::get('/transaksi/jual/index', 'TransaksiJualController@indexTransaksiJual')->name('indexTransaksiJual');
    Route::get('/transaksi/jual/data', 'TransaksiJualController@dataTransaksiJual')->name('dataTransaksiJual');
    Route::post('/transaksi/jual/update', 'TransaksiJualController@update')->name('transaksiJualUpdate');
    Route::delete('/transaksi/jual/delete/{id}', 'TransaksiJualController@delete')->name('transaksiJualDelete');

    Route::get('/barang', 'BarangController@index')->name('barangIndex');
    Route::get('/barang/data', 'BarangController@dataBarang')->name('dataBarang');
    Route::post('/barang', 'BarangController@store')->name('barangStore');
    Route::post('/barang/update', 'BarangController@update')->name('barangUpdate');
    Route::delete('/barang/delete/{id}', 'BarangController@delete')->name('barangDelete');

    // stok barang
    Route::get('/barang/stokbarang', 'BarangController@stokBarang')->name('stokBarang');
    Route::get('/barang/datastokbarang', 'BarangController@dataStokBarang')->name('dataStokBarang');


    Route::get('/karyawan', 'KaryawanController@index')->name('karyawanIndex');
    Route::get('/karyawan/data', 'KaryawanController@dataKaryawan')->name('dataKaryawan');
    Route::post('/karyawan', 'KaryawanController@store')->name('karyawanStore');
    Route::post('/karyawan/update', 'KaryawanController@update')->name('karyawanUpdate');
    Route::delete('/karyawan/delete/{id}', 'KaryawanController@delete')->name('karyawanDelete');
    Route::get('/karyawan/absensi', 'KaryawanController@absensi')->name('karyawanAbsensi');
    Route::post('/karyawan/absensi', 'KaryawanController@absensiStore')->name('karyawanAbsensiStore');
    Route::get('/karyawan/absensi/index', 'KaryawanController@absensiIndex')->name('absensiIndex');
    Route::get('/karyawan/absensi/data', 'KaryawanController@absensiData')->name('absensiData');
    Route::get('/karyawan/absensi/edit/{tanggal}', 'KaryawanController@absensiEdit')->name('absensiEdit');
    Route::post('/karyawan/absensi/update/{tanggal}', 'KaryawanController@absensiUpdate')->name('absensiUpdate');
    Route::delete('/karyawan/absensi/absensi/{tanggal}', 'KaryawanController@absensiDelete')->name('absensiDelete');
    Route::get('/karyawan/laporan', 'KaryawanController@karyawanLaporan')->name('karyawanLaporan');
    Route::post('/karyawan/laporan', 'KaryawanController@karyawanLaporanStore')->name('karyawanLaporanStore');
    Route::get('/karyawan/laporan/{id}', 'KaryawanController@karyawanLaporanDetail')->name('karyawanLaporanDetail');
    Route::delete('/karyawan/laporan/delete/{id}', 'KaryawanController@karyawanLaporanDelete')->name('karyawanLaporanDelete');
    Route::post('/karyawan/laporan/update/{id}', 'KaryawanController@karyawanLaporanUpdate')->name('karyawanLaporanUpdate');

    Route::get('/beban-usaha', 'BebanController@index')->name('bebanIndex');
    Route::get('/beban-usaha/data', 'BebanController@bebanData')->name('bebanData');
    Route::post('/beban-usaha', 'BebanController@store')->name('bebanStore');
    Route::post('/beban-usaha/update', 'BebanController@update')->name('bebanUpdate');
    Route::delete('/beban-usaha/delete/{id}', 'BebanController@delete')->name('bebanDelete');

    Route::get('/beban-usaha/bayar', 'TransaksiBebanController@bebanBayar')->name('bebanBayar');
    Route::get('/beban-usaha/bayar/data', 'TransaksiBebanController@bebanBayarData')->name('bebanBayarData');
    Route::post('/beban-usaha/bayar', 'TransaksiBebanController@bebanBayarStore')->name('bebanBayarStore');
    Route::post('/beban-usaha/bayar/update', 'TransaksiBebanController@bebanBayarUpdate')->name('bebanBayarUpdate');
    Route::delete('/beban-usaha/bayar/delete/{id}', 'TransaksiBebanController@bebanBayarDelete')->name('bebanBayarDelete');

    // Backup & Printout
    Route::get('/tool/backup', 'ToolController@backup')->name('backup');
    Route::get('/tool/export', 'ToolController@exportIndex')->name('exportIndex');
    Route::get('/tool/export/data', 'ToolController@exportData')->name('exportData');
    Route::post('/tool/export', 'ToolController@exportStore')->name('exportStore');
    Route::delete('/tool/export/delete/{id}', 'ToolController@exportDelete')->name('exportDelete');
    Route::get('/tool/export/download/{id}', 'ToolController@exportDownload')->name('exportDownload');
});
