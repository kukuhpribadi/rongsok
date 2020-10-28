<?php

namespace App\Http\Controllers;

use App\Barang;
use App\TransaksiJual;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

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

    public function jualStore(Request $request)
    {
        $filter = array_filter($request->nama);
        $harga = str_replace('.', '', $request->harga);

        $tanggalInput = explode('/', $request->tanggal_input);
        $tanggalInput = $tanggalInput[2] . '-' . $tanggalInput[1] . '-' . $tanggalInput[0];

        foreach ($filter as $key => $value) {
            TransaksiJual::create([
                'tanggal_input' => $tanggalInput,
                'barang_id' => $request->nama[$key],
                'transaksi_jual_id' => $request->transaksi_jual_id,
                'harga' => $harga[$key],
                'qty' => $request->qty[$key],
                'keterangan' => $request->keterangan[$key],
            ]);

            $stok = Barang::find($request->nama[$key]);
            $stok->update([
                'stok' => $stok->stok - $request->qty[$key]
            ]);
        }

        return redirect(route('transaksiJual'))->with('sukses', 'Transaksi berhasil!');
    }

    public function indexTransaksiJual()
    {
        $barang = Barang::orderBy('nama', 'asc')->get();
        return view('transaksi.indexJual', compact('barang'));
    }

    public function dataTransaksiJual()
    {
        function formatTanggal($tanggal)
        {
            $tanggalEdit = explode('-', $tanggal);
            $tanggalEdit = $tanggalEdit[2] . '/' . $tanggalEdit[1] . '/' . $tanggalEdit[0];
            return $tanggalEdit;
        }

        $penjualan = TransaksiJual::query()->orderBy('created_at', 'desc');
        return DataTables::eloquent($penjualan)
            ->addIndexColumn()
            ->addColumn('aksi', function ($b) {
                return '<a href="#" class="btn btn-sm btn-icon btn-primary" data-id="' . $b->id . '" data-tanggal_input="' . formatTanggal($b->tanggal_input) . '" data-transaksi_jual_id="' . $b->transaksi_jual_id . '" data-barang_id="' . $b->barang_id . '" data-harga="' . number_format($b->harga, 0, ',', '.') . '" data-qty="' . $b->qty . '" data-keterangan="' . $b->keterangan . '" data-toggle="modal" data-target="#modalEdit"><i class="far fa-edit"></i></a>
                <a href="' . route("transaksiJualDelete", $b->id) . '" class="btn btn-sm btn-icon btn-danger" id="buttonDelete" data-idTransaksi="' . $b->transaksi_jual_id . '" data-nama="' . $b->barang->nama . '"><i class="far fa-trash-alt"></i></a>';
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
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function update(Request $request)
    {
        $transaksi = TransaksiJual::find($request->id);

        $tanggalInput = explode('/', $request->tanggal_input);
        $tanggalInput = $tanggalInput[2] . '-' . $tanggalInput[1] . '-' . $tanggalInput[0];

        $harga = str_replace('.', '', $request->harga);
        $transaksi->update([
            'transaksi_jual_id' => $request->transaksi_jual_id,
            'barang_id' => $request->nama,
            'harga' => $harga,
            'qty' => $request->qty,
            'keterangan' => $request->keterangan,
        ]);

        // update semua tanggal dengan id transaksi yang sama
        $IDTransaksi = TransaksiJual::where('transaksi_jual_id', $request->transaksi_jual_id)->get();
        foreach ($IDTransaksi as $key => $value) {
            $IDTransaksi[$key]->update([
                'tanggal_input' => $tanggalInput,
            ]);
        }
    }

    public function delete($id)
    {
        TransaksiJual::find($id)->delete();
    }
}
