<?php

namespace App\Http\Controllers;

use App\Karyawan;
use App\TransaksiBeli;
use App\TransaksiJual;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $pengeluaran = TransaksiBeli::all()->sum(function ($row) {
            return $row->harga * $row->qty;
        });
        $pengeluaran = number_format($pengeluaran, 0, ',', '.');

        $pendapatan = TransaksiJual::all()->sum(function ($row) {
            return $row->harga * $row->qty;
        });
        $pendapatan = number_format($pendapatan, 0, ',', '.');

        $jmlTransaksiBeli = TransaksiBeli::groupBy('transaksi_beli_id')->get()->count();
        $jmlTransaksiJual = TransaksiJual::groupBy('transaksi_jual_id')->get()->count();

        $jmlKaryawan = Karyawan::where('status', 1)->get()->count();

        return view('dashboard.index', compact('pengeluaran', 'pendapatan', 'jmlTransaksiBeli', 'jmlTransaksiJual', 'jmlKaryawan'));
    }
}
