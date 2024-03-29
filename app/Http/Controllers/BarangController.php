<?php

namespace App\Http\Controllers;

use App\Barang;
use App\TransaksiBeli;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BarangController extends Controller
{
    public function index()
    {
        return view('barang.index');
    }

    public function dataBarang()
    {
        $barang = Barang::query();
        return DataTables::eloquent($barang)
            ->addIndexColumn()
            ->addColumn('aksi', function ($b) {
                return '<a href="#" class="btn btn-sm btn-icon btn-primary" data-id="' . $b->id . '" data-nama="' . $b->nama . '" data-harga="' . number_format($b->harga, 0, ',', '.') . '" data-toggle="modal" data-target="#modalEdit"><i class="far fa-edit"></i></a>
                <a href="' . route("barangDelete", $b->id) . '" class="btn btn-sm btn-icon btn-danger" id="buttonDelete" data-nama="' . $b->nama . '"><i class="far fa-trash-alt"></i></a>';
            })
            ->editColumn('harga', function ($h) {
                return "Rp " . number_format($h->harga, 0, ',', '.');
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function store(Request $request)
    {
        if (isset($request->harga)) {
            $harga = str_replace('.', '', $request->harga);
        } else {
            $harga = null;
        }

        Barang::create([
            'nama' => $request->nama,
            'harga' => $harga
        ]);

        return redirect(route('barangIndex'))->with('sukses', 'Data barang berhasil ditambahkan');
    }

    public function update(Request $request)
    {
        $harga = str_replace('.', '', $request->harga);

        $barang = Barang::find($request->id);

        $barang->update([
            'nama' => $request->nama,
            'harga' => $harga
        ]);
    }

    public function delete($id)
    {
        Barang::find($id)->delete();
    }

    // STOK BARANG
    public function stokBarang()
    {
        return view('barang.stokBarang');
    }

    public function dataStokBarang(Request $request)
    {
        $barang = Barang::query();
        return DataTables::eloquent($barang)
            ->addIndexColumn()
            ->addColumn('aksi', function ($b) {
                return '<a href="#" class="btn btn-sm btn-icon btn-primary" data-id="' . $b->id . '" data-nama="' . $b->nama . '" data-stok="' . $b->stok . '" data-toggle="modal" data-target="#modalEdit"><i class="far fa-edit"></i></a>';
            })
            ->addColumn('masuk', function ($msk) {
                $now = Carbon::now();
                // return url()->full();
                if (request('filter_periode') === "hari") {
                    return $msk->transaksi_beli->where('tanggal_input', $now->format('Y-m-d'))->sum('qty');
                } elseif (request('filter_periode') === "bulan") {
                    return $msk->transaksi_beli->whereBetween('tanggal_input', [$now->firstOfMonth()->format('Y-m-d'), $now->lastOfMonth()->format('Y-m-d')])->sum('qty');
                } elseif (request('filter_periode') === "tahun") {
                    return $msk->transaksi_beli->whereBetween('tanggal_input', [$now->firstOfYear()->format('Y-m-d'), $now->lastOfYear()->format('Y-m-d')])->sum('qty');
                }

                $tanggal = explode('/', request('filter_periode'));
                return $msk->transaksi_beli->whereBetween('tanggal_input', [$tanggal[0], $tanggal[1]])->sum('qty');
            })
            ->addColumn('keluar', function ($klr) {
                $now = Carbon::now();

                if (request('filter_periode') === "hari") {
                    return $klr->transaksi_jual->where('tanggal_input', $now->format('Y-m-d'))->sum('qty');
                } elseif (request('filter_periode') === "bulan") {
                    return $klr->transaksi_jual->whereBetween('tanggal_input', [$now->firstOfMonth()->format('Y-m-d'), $now->lastOfMonth()->format('Y-m-d')])->sum('qty');
                } elseif (request('filter_periode') === "tahun") {
                    return $klr->transaksi_jual->whereBetween('tanggal_input', [$now->firstOfYear()->format('Y-m-d'), $now->lastOfYear()->format('Y-m-d')])->sum('qty');
                }
                $tanggal = explode('/', request('filter_periode'));
                return $klr->transaksi_jual->whereBetween('tanggal_input', [$tanggal[0], $tanggal[1]])->sum('qty');
            })
            ->editColumn('stok', function ($st) {
                if ($st->stok == null) {
                    return 0;
                }
                return $st->stok;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function stokBarangUpdate(Request $request)
    {
        $barang = Barang::find($request->id);

        $barang->update([
            'nama' => $request->nama,
            'stok' => $request->stok
        ]);
    }
}
