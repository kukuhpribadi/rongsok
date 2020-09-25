<?php

namespace App\Http\Controllers;

use App\Barang;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function beli()
    {
        $barang = Barang::orderBy('nama', 'asc')->get();
        return view('transaksi.beli', compact('barang'));
    }
}
