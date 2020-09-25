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

Route::get('/', 'DashboardController@index')->name('dashboardIndex');

Route::get('/transaksi/beli', 'TransaksiController@beli')->name('transaksiBeli');

Route::get('/barang', 'BarangController@index')->name('barangIndex');
Route::get('/barang/data', 'BarangController@dataBarang')->name('dataBarang');
Route::post('/barang', 'BarangController@store')->name('barangStore');
Route::post('/barang/update', 'BarangController@update')->name('barangUpdate');
Route::get('/barang/delete/{id}', 'BarangController@delete')->name('barangDelete');
