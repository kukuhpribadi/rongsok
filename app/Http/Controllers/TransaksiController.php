<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function beli()
    {
        return view('transaksi.beli');
    }
}
