<?php

namespace App\Http\Controllers;

use App\Barang;
use App\TransaksiBeli;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TransaksiBeliController extends Controller
{
    public function getTransaksiBeliId()
    {
        $idBeli = TransaksiBeli::latest('id')->first();

        if ($idBeli === null) {
            $idBeli = 'BL' . sprintf("%05s", 1);
        } else {
            $idBeli = $idBeli->transaksi_beli_id;
            $idBeli = explode('BL', $idBeli);
            $idBeli = 'BL' . sprintf("%05s", $idBeli[1] + 1);
        }

        return $idBeli;
    }

    public function beli()
    {
        $transaksiId = $this->getTransaksiBeliId();
        $barang = Barang::orderBy('nama', 'asc')->get();
        return view('transaksi.beli', compact('barang', 'transaksiId'));
    }

    public function beliStore(Request $request)
    {
        $filter = array_filter($request->nama);
        $harga = str_replace('.', '', $request->harga);

        $tanggalInput = explode('/', $request->tanggal_input);
        $tanggalInput = $tanggalInput[2] . '-' . $tanggalInput[1] . '-' . $tanggalInput[0];

        foreach ($filter as $key => $value) {
            TransaksiBeli::create([
                'tanggal_input' => $tanggalInput,
                'barang_id' => $request->nama[$key],
                'transaksi_beli_id' => $request->transaksi_beli_id,
                'harga' => $harga[$key],
                'qty' => $request->qty[$key],
                'keterangan' => $request->keterangan[$key],
            ]);

            $stok = Barang::find($request->nama[$key]);
            $stok->update([
                'stok' => $stok->stok + $request->qty[$key]
            ]);
        }

        return redirect(route('transaksiBeli'))->with('sukses', 'Transaksi berhasil!');
    }

    public function indexTransaksiBeli()
    {
        $barang = Barang::orderBy('nama', 'asc')->get();
        return view('transaksi.indexBeli', compact('barang'));
    }

    public function dataTransaksiBeli()
    {
        function formatTanggal($tanggal)
        {
            $tanggalEdit = explode('-', $tanggal);
            $tanggalEdit = $tanggalEdit[2] . '/' . $tanggalEdit[1] . '/' . $tanggalEdit[0];
            return $tanggalEdit;
        }

        $pembelian = TransaksiBeli::query()->orderBy('created_at', 'desc');
        return DataTables::eloquent($pembelian)
            ->addIndexColumn()
            ->addColumn('aksi', function ($b) {
                return '<a href="#" class="btn btn-sm btn-icon btn-primary" data-id="' . $b->id . '" data-tanggal_input="' . formatTanggal($b->tanggal_input) . '" data-transaksi_beli_id="' . $b->transaksi_beli_id . '" data-barang_id="' . $b->barang_id . '" data-harga="' . number_format($b->harga, 0, ',', '.') . '" data-qty="' . $b->qty . '" data-keterangan="' . $b->keterangan . '" data-toggle="modal" data-target="#modalEdit"><i class="far fa-edit"></i></a>
                <a href="' . route("transaksiBeliDelete", $b->id) . '" class="btn btn-sm btn-icon btn-danger" id="buttonDelete" data-idTransaksi="' . $b->transaksi_beli_id . '" data-nama="' . $b->barang->nama . '"><i class="far fa-trash-alt"></i></a>';
            })
            ->addColumn('total', function ($t) {
                return "Rp " . number_format($t->harga * $t->qty, 0, ',', '.');
            })
            ->editColumn('jenis_barang', function ($jb) {
                return $jb->barang->nama;
            })
            ->editColumn('harga', function ($h) {
                return "Rp " . number_format($h->harga, 0, ',', '.');
            })
            ->editColumn('tanggal', function ($tgl) {
                $time = strtotime($tgl->tanggal_input);
                $newformat = date('d-m-Y', $time);
                return $newformat;
                // return $tgl->created_at->format('d-m-Y');;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    // public function update(Request $request)
    // {
    //     $transaksi = TransaksiBeli::find($request->id);
    //     $harga = str_replace('.', '', $request->harga);
    //     $transaksi->update([
    //         'transaksi_beli_id' => $request->transaksi_beli_id,
    //         'barang_id' => $request->nama,
    //         'harga' => $harga,
    //         'qty' => $request->qty,
    //         'keterangan' => $request->keterangan,
    //     ]);
    // }

    public function update(Request $request)
    {
        $transaksi = TransaksiBeli::find($request->id);

        $tanggalInput = explode('/', $request->tanggal_input);
        $tanggalInput = $tanggalInput[2] . '-' . $tanggalInput[1] . '-' . $tanggalInput[0];
        // dd($tanggalInput);

        $harga = str_replace('.', '', $request->harga);
        $transaksi->update([
            'transaksi_beli_id' => $request->transaksi_beli_id,
            'barang_id' => $request->nama,
            'harga' => $harga,
            'qty' => $request->qty,
            'keterangan' => $request->keterangan,
        ]);

        // update semua tanggal dengan id transaksi yang sama
        $IDTransaksi = TransaksiBeli::where('transaksi_beli_id', $request->transaksi_beli_id)->get();
        foreach ($IDTransaksi as $key => $value) {
            $IDTransaksi[$key]->update([
                'tanggal_input' => $tanggalInput,
            ]);
        }
    }

    public function delete($id)
    {
        TransaksiBeli::find($id)->delete();
    }
}
