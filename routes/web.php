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

Route::get('/transaksi/beli', 'TransaksiBeliController@beli')->name('transaksiBeli');
Route::post('/transaksi/beli', 'TransaksiBeliController@beliStore')->name('transaksiBeliStore');
Route::get('/transaksi/beli/index', 'TransaksiBeliController@indexTransaksiBeli')->name('indexTransaksiBeli');
Route::get('/transaksi/beli/data', 'TransaksiBeliController@dataTransaksiBeli')->name('dataTransaksiBeli');
Route::post('/transaksi/beli/update', 'TransaksiBeliController@update')->name('transaksiBeliUpdate');
Route::get('/transaksi/beli/delete/{id}', 'TransaksiBeliController@delete')->name('transaksiBeliDelete');

Route::get('/transaksi/jual', 'TransaksiJualController@jual')->name('transaksiJual');
Route::post('/transaksi/jual', 'TransaksiJualController@jualStore')->name('transaksiJualStore');
Route::get('/transaksi/jual/index', 'TransaksiJualController@indexTransaksiJual')->name('indexTransaksiJual');
Route::get('/transaksi/jual/data', 'TransaksiJualController@dataTransaksiJual')->name('dataTransaksiJual');
Route::post('/transaksi/jual/update', 'TransaksiJualController@update')->name('transaksiJualUpdate');
Route::get('/transaksi/jual/delete/{id}', 'TransaksiJualController@delete')->name('transaksiJualDelete');

Route::get('/barang', 'BarangController@index')->name('barangIndex');
Route::get('/barang/data', 'BarangController@dataBarang')->name('dataBarang');
Route::post('/barang', 'BarangController@store')->name('barangStore');
Route::post('/barang/update', 'BarangController@update')->name('barangUpdate');
Route::get('/barang/delete/{id}', 'BarangController@delete')->name('barangDelete');