<?php

namespace App\Http\Controllers;

use App\Karyawan;
use App\LaporanKaryawan;
use App\TransaksiBeli;
use App\TransaksiJual;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $upahKaryawan = LaporanKaryawan::all()->sum('total');
        $pengeluaran = TransaksiBeli::all()->sum(function ($row) {
            return $row->harga * $row->qty;
        });
        $pengeluaran = number_format($pengeluaran + $upahKaryawan, 0, ',', '.');

        $pendapatan = TransaksiJual::all()->sum(function ($row) {
            return $row->harga * $row->qty;
        });
        $pendapatan = number_format($pendapatan, 0, ',', '.');

        $jmlTransaksiBeli = TransaksiBeli::groupBy('transaksi_beli_id')->get()->count();
        $jmlTransaksiJual = TransaksiJual::groupBy('transaksi_jual_id')->get()->count();

        $jmlKaryawan = Karyawan::where('status', 1)->get()->count();

        return view('dashboard.index', compact('pengeluaran', 'pendapatan', 'jmlTransaksiBeli', 'jmlTransaksiJual', 'jmlKaryawan'));
    }

    public function getDataTahunIni()
    {
        $now = Carbon::now();

        // upah karyawan
        $upahKaryawan = LaporanKaryawan::whereYear('created_at', $now->year)->get();
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

        return view('dashboard.index', compact('pengeluaran', 'pendapatan', 'jmlTransaksiBeli', 'jmlTransaksiJual', 'jmlKaryawan', 'namaButton'));
    }

    public function getDataBulanIni()
    {
        $now = Carbon::now();

        // upah karyawan
        $upahKaryawan = LaporanKaryawan::whereYear('created_at', $now->year)->whereMonth('created_at', $now->month)->get();
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

        return view('dashboard.index', compact('pengeluaran', 'pendapatan', 'jmlTransaksiBeli', 'jmlTransaksiJual', 'jmlKaryawan', 'namaButton'));
    }

    public function getDataHariIni()
    {
        $now = Carbon::now();

        // upah karyawan
        $upahKaryawan = LaporanKaryawan::whereDate('created_at', $now->today())->get();
        $upahKaryawan = $upahKaryawan->sum('total');

        // pengeluaran
        $pengeluaran = TransaksiBeli::whereDate('created_at', $now->today())->get();
        $pengeluaran = $pengeluaran->sum(function ($row) {
            return $row->harga * $row->qty;
        });
        $pengeluaran = number_format($pengeluaran + $upahKaryawan, 0, ',', '.');

        // pendapatan
        $pendapatan = TransaksiJual::whereDate('created_at', $now->today())->get();
        $pendapatan = $pendapatan->sum(function ($row) {
            return $row->harga * $row->qty;
        });
        $pendapatan = number_format($pendapatan, 0, ',', '.');

        // jml transaksi
        $jmlTransaksiBeli = TransaksiBeli::whereDate('created_at', $now->today())->groupBy('transaksi_beli_id')->get()->count();
        $jmlTransaksiJual = TransaksiJual::whereDate('created_at', $now->today())->groupBy('transaksi_jual_id')->get()->count();

        //jml karyawan
        $jmlKaryawan = Karyawan::where('status', 1)->get()->count();

        // nama button
        $namaButton = 'Hari ini';

        return view('dashboard.index', compact('pengeluaran', 'pendapatan', 'jmlTransaksiBeli', 'jmlTransaksiJual', 'jmlKaryawan', 'namaButton'));
    }

    public function getDataMingguIni()
    {

        $now = Carbon::now();
        $startOfWeek = $now->startOfWeek()->format('Y-m-d H:i');
        $endOfWeek = $now->endOfWeek()->format('Y-m-d H:i');

        // upah karyawan
        $upahKaryawan = LaporanKaryawan::whereBetween('created_at', [$startOfWeek, $endOfWeek])->get();
        $upahKaryawan = $upahKaryawan->sum('total');

        // pengeluaran
        $pengeluaran = TransaksiBeli::whereBetween('created_at', [$startOfWeek, $endOfWeek])->get();
        $pengeluaran = $pengeluaran->sum(function ($row) {
            return $row->harga * $row->qty;
        });
        $pengeluaran = number_format($pengeluaran + $upahKaryawan, 0, ',', '.');

        // pendapatan
        $pendapatan = TransaksiJual::whereBetween('created_at', [$startOfWeek, $endOfWeek])->get();
        $pendapatan = $pendapatan->sum(function ($row) {
            return $row->harga * $row->qty;
        });
        $pendapatan = number_format($pendapatan, 0, ',', '.');

        // jml transaksi
        $jmlTransaksiBeli = TransaksiBeli::whereBetween('created_at', [$startOfWeek, $endOfWeek])->groupBy('transaksi_beli_id')->get()->count();
        $jmlTransaksiJual = TransaksiJual::whereBetween('created_at', [$startOfWeek, $endOfWeek])->groupBy('transaksi_jual_id')->get()->count();

        //jml karyawan
        $jmlKaryawan = Karyawan::where('status', 1)->get()->count();

        // nama button
        $namaButton = 'Minggu ini';

        return view('dashboard.index', compact('pengeluaran', 'pendapatan', 'jmlTransaksiBeli', 'jmlTransaksiJual', 'jmlKaryawan', 'namaButton'));
    }
}
