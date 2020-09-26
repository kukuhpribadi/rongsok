<?php

namespace App\Http\Controllers;

use App\Barang;
use App\TransaksiBeli;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function beli()
    {
        $barang = Barang::orderBy('nama', 'asc')->get();
        return view('transaksi.beli', compact('barang'));
    }

    public function beliStore(Request $request)
    {
        $filter = array_filter($request->nama);
        $harga = str_replace('.', '', $request->harga);

        foreach ($filter as $key => $value) {
            TransaksiBeli::create([
                'barang_id' => $request->nama[$key],
                'harga' => $harga[$key],
                'qty' => $request->qty[$key],
                'keterangan' => $request->keterangan[$key],
            ]);
        }

        return redirect(route('transaksiBeli'))->with('sukses', 'Transaksi berhasil!');
    }
}
