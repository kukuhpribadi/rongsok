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

class DashboardController extends Controller
{
    public function getDataTahunIni()
    {
        $now = Carbon::now();

        // upah karyawan
        $upahKaryawan = LaporanKaryawan::whereYear('updated_at', $now->year)->get();
        $upahKaryawan = $upahKaryawan->sum('total');

        // pengeluaran
        $pengeluaran = TransaksiBeli::whereYear('created_at', $now->year)->get();
        $pengeluaran = $pengeluaran->sum(function ($row) {
            return $row->harga * $row->qty;
        });
        $pengeluaran = number_format($pengeluaran + $upahKaryawan, 0, ',', '.');

        // pendapatan
        $pendapatan = TransaksiJual::whereYear('created_at', $now->year)->get();
        $pendapatan = $pendapatan->sum(function ($row) {
            return $row->harga * $row->qty;
        });
        $pendapatan = number_format($pendapatan, 0, ',', '.');

        // jml transaksi
        $jmlTransaksiBeli = TransaksiBeli::whereYear('created_at', $now->year)->groupBy('transaksi_beli_id')->get()->count();
        $jmlTransaksiJual = TransaksiJual::whereYear('created_at', $now->year)->groupBy('transaksi_jual_id')->get()->count();

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
            $transaksiBeli = TransaksiBeli::whereYear('created_at', $now->year)->whereMonth('created_at', $i)->get();
            $pengeluaranUpah = LaporanKaryawan::whereYear('updated_at', $now->year)->whereMonth('updated_at', $i)->get();
            $jmlTransaksiBeliPerBulan[] = $transaksiBeli->sum(function ($row) {
                return $row->harga * $row->qty;
            }) + $pengeluaranUpah->sum('total');

            //penjualan atau pendapatan
            $transaksiJual = TransaksiJual::whereYear('created_at', $now->year)->whereMonth('created_at', $i)->get();
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
        $pengeluaran = TransaksiBeli::whereYear('created_at', $now->year)->whereMonth('created_at', $now->month)->get();
        $pengeluaran = $pengeluaran->sum(function ($row) {
            return $row->harga * $row->qty;
        });
        $pengeluaran = number_format($pengeluaran + $upahKaryawan, 0, ',', '.');

        // pendapatan
        $pendapatan = TransaksiJual::whereYear('created_at', $now->year)->whereMonth('created_at', $now->month)->get();
        $pendapatan = $pendapatan->sum(function ($row) {
            return $row->harga * $row->qty;
        });
        $pendapatan = number_format($pendapatan, 0, ',', '.');

        // jml transaksi
        $jmlTransaksiBeli = TransaksiBeli::whereYear('created_at', $now->year)->whereMonth('created_at', $now->month)->groupBy('transaksi_beli_id')->get()->count();
        $jmlTransaksiJual = TransaksiJual::whereYear('created_at', $now->year)->whereMonth('created_at', $now->month)->groupBy('transaksi_jual_id')->get()->count();

        //jml karyawan
        $jmlKaryawan = Karyawan::where('status', 1)->get()->count();

        // nama button
        $namaButton = 'Bulan ini';

        // chart
        for ($i = 1; $i <= $now->day; $i++) {
            $jmlHari[] = $i;

            // pengeluaran atau pembelian
            $transaksiBeli = TransaksiBeli::whereYear('created_at', $now->year)->whereMonth('created_at', $now->month)->whereDay('created_at', $i)->get();
            $pengeluaranUpah = LaporanKaryawan::whereYear('updated_at', $now->year)->whereMonth('updated_at', $now->month)->whereDay('updated_at', $i)->get();
            $jmlTransaksiBeliPerHari[] = $transaksiBeli->sum(function ($row) {
                return $row->harga * $row->qty;
            }) + $pengeluaranUpah->sum('total');

            //penjualan atau pendapatan
            $transaksiJual = TransaksiJual::whereYear('created_at', $now->year)->whereMonth('created_at', $now->month)->whereDay('created_at', $i)->get();
            $jmlTransaksiJualPerHari[] = $transaksiJual->sum(function ($row) {
                return $row->harga * $row->qty;
            });
        }

        // $jmlHari = json_encode($jmlHari);

        // harga beli barang
        $hargaBeli = Barang::orderBy('harga', 'desc')->get();

        return view('dashboard.index', compact('pengeluaran', 'pendapatan', 'jmlTransaksiBeli', 'jmlTransaksiJual', 'jmlKaryawan', 'namaButton', 'jmlHari', 'jmlTransaksiBeliPerHari', 'hargaBeli', 'jmlTransaksiJualPerHari'));
    }
}
