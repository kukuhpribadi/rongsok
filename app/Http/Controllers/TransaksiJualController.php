<?php

namespace App\Http\Controllers;

use App\Barang;
use App\TransaksiJual;
use Illuminate\Http\Request;

class TransaksiJualController extends Controller
{
    public function getTransaksiJualId()
    {
        $idJual = TransaksiJual::latest('id')->first();

        if ($idJual === null) {
            $idJual = 'JB' . sprintf("%05s", 1);
        } else {
            $idJual = $idJual->transaksi_jual_id;
            $idJual = explode('JB', $idJual);
            $idJual = 'JB' . sprintf("%05s", $idJual[1] + 1);
        }

        return $idJual;
    }

    public function jual()
    {
        $transaksiId = $this->getTransaksiJualId();
        $barang = Barang::orderBy('nama', 'asc')->get();
        return view('transaksi.jual', compact('barang', 'transaksiId'));
    }
}
