<?php

namespace App\Http\Controllers;

use App\Barang;
use App\Karyawan;
use App\LaporanKaryawan;
use App\TransaksiBeli;
use App\TransaksiJual;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Charts\DashboardChart;
use App\TransaksiBeban;

class DashboardController extends Controller
{
    public function getDataTahunIni()
    {
        $now = Carbon::now();

        // upah karyawan
        $upahKaryawan = LaporanKaryawan::whereYear('updated_at', $now->year)->get();
        $upahKaryawan = $upahKaryawan->sum('total');

        // pengeluaran
        $pengeluaran = TransaksiBeli::whereYear('tanggal_input', $now->year)->get();
        $pengeluaran = $pengeluaran->sum(function ($row) {
            return $row->harga * $row->qty;
        });

        // beban usaha
        $bebanUsaha = TransaksiBeban::whereYear('tanggal_pembayaran', $now->year)->get();
        $bebanUsaha =  $bebanUsaha->sum('harga');

        // pengeluaran per tahun
        $pengeluaran = number_format($pengeluaran + $upahKaryawan + $bebanUsaha, 0, ',', '.');

        // pendapatan
        $pendapatan = TransaksiJual::whereYear('tanggal_input', $now->year)->get();
        $pendapatan = $pendapatan->sum(function ($row) {
            return $row->harga * $row->qty;
        });
        $pendapatan = number_format($pendapatan, 0, ',', '.');

        // jml transaksi
        $jmlTransaksiBeli = TransaksiBeli::whereYear('tanggal_input', $now->year)->groupBy('barang_id')->get();
        $jmlTransaksiJual = TransaksiJual::whereYear('tanggal_input', $now->year)->groupBy('transaksi_jual_id')->get()->count();

        //jml karyawan
        $jmlKaryawan = Karyawan::where('status', 1)->get()->count();

        // nama button
        $namaButton = 'Tahun ini';

        // harga beli barang
        $hargaBeli = Barang::orderBy('harga', 'desc')->get();

        // chart
        for ($i = 1; $i <= $now->month; $i++) {
            $jmlBulan[] = $i;

            // pengeluaran atau pembelian
            $transaksiBeli = TransaksiBeli::whereYear('tanggal_input', $now->year)->whereMonth('tanggal_input', $i)->get();
            $pengeluaranUpah = LaporanKaryawan::whereYear('updated_at', $now->year)->whereMonth('updated_at', $i)->get();
            $pengeluaranBeban = TransaksiBeban::whereYear('tanggal_pembayaran', $now->year)->whereMonth('tanggal_pembayaran', $i)->get();
            $jmlTransaksiBeliPerBulan[] = $transaksiBeli->sum(function ($row) {
                return $row->harga * $row->qty;
            }) + $pengeluaranUpah->sum('total') + $pengeluaranBeban->sum('harga');

            //penjualan atau pendapatan
            $transaksiJual = TransaksiJual::whereYear('tanggal_input', $now->year)->whereMonth('tanggal_input', $i)->get();
            $jmlTransaksiJualPerBulan[] = $transaksiJual->sum(function ($row) {
                return $row->harga * $row->qty;
            });
        }

        return view('dashboard.index', compact('pengeluaran', 'pendapatan', 'jmlTransaksiBeli', 'jmlTransaksiJual', 'jmlKaryawan', 'namaButton', 'jmlBulan', 'jmlTransaksiBeliPerBulan', 'hargaBeli', 'jmlTransaksiJualPerBulan'));
    }

    public function getDataBulanIni()
    {
        $now = Carbon::now();

        // upah karyawan
        $upahKaryawan = LaporanKaryawan::whereYear('updated_at', $now->year)->whereMonth('updated_at', $now->month)->get();
        $upahKaryawan = $upahKaryawan->sum('total');

        // pengeluaran
        $pengeluaran = TransaksiBeli::whereYear('tanggal_input', $now->year)->whereMonth('tanggal_input', $now->month)->get();
        $pengeluaran = $pengeluaran->sum(function ($row) {
            return $row->harga * $row->qty;
        });

        // beban usaha
        $bebanUsaha = TransaksiBeban::whereYear('tanggal_pembayaran', $now->year)->whereMonth('tanggal_pembayaran', $now->month)->get();
        $bebanUsaha =  $bebanUsaha->sum('harga');

        // pengeluaran perbulan
        $pengeluaran = number_format($pengeluaran + $upahKaryawan + $bebanUsaha, 0, ',', '.');

        // pendapatan
        $pendapatan = TransaksiJual::whereYear('tanggal_input', $now->year)->whereMonth('tanggal_input', $now->month)->get();
        $pendapatan = $pendapatan->sum(function ($row) {
            return $row->harga * $row->qty;
        });
        $pendapatan = number_format($pendapatan, 0, ',', '.');

        // jml transaksi
        $jmlTransaksiBeli = TransaksiBeli::whereYear('tanggal_input', $now->year)->whereMonth('tanggal_input', $now->month)->groupBy('barang_id')->get();

        $jmlTransaksiJual = TransaksiJual::whereYear('tanggal_input', $now->year)->whereMonth('tanggal_input', $now->month)->groupBy('transaksi_jual_id')->get()->count();

        //jml karyawan
        $jmlKaryawan = Karyawan::where('status', 1)->get()->count();

        // nama button
        $namaButton = 'Bulan ini';

        // chart
        for ($i = 1; $i <= $now->day; $i++) {
            $jmlHari[] = $i;

            // pengeluaran atau pembelian
            $transaksiBeli = TransaksiBeli::whereYear('tanggal_input', $now->year)->whereMonth('tanggal_input', $now->month)->whereDay('tanggal_input', $i)->get();
            $pengeluaranUpah = LaporanKaryawan::whereYear('updated_at', $now->year)->whereMonth('updated_at', $now->month)->whereDay('updated_at', $i)->get();
            $pengeluaranBeban = TransaksiBeban::whereYear('tanggal_pembayaran', $now->year)->whereMonth('tanggal_pembayaran', $now->month)->whereDay('tanggal_pembayaran', $i)->get();
            $jmlTransaksiBeliPerHari[] = $transaksiBeli->sum(function ($row) {
                return $row->harga * $row->qty;
            }) + $pengeluaranUpah->sum('total') + $pengeluaranBeban->sum('harga');

            //penjualan atau pendapatan
            $transaksiJual = TransaksiJual::whereYear('tanggal_input', $now->year)->whereMonth('tanggal_input', $now->month)->whereDay('tanggal_input', $i)->get();
            $jmlTransaksiJualPerHari[] = $transaksiJual->sum(function ($row) {
                return $row->harga * $row->qty;
            });
        }

        // harga beli barang
        $hargaBeli = Barang::orderBy('harga', 'desc')->get();

        return view('dashboard.index', compact('pengeluaran', 'pendapatan', 'jmlTransaksiBeli', 'jmlTransaksiJual', 'jmlKaryawan', 'namaButton', 'jmlHari', 'jmlTransaksiBeliPerHari', 'hargaBeli', 'jmlTransaksiJualPerHari'));
    }
}
