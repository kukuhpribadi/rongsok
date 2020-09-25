<?php

namespace App\Http\Controllers;

use App\Barang;
use Illuminate\Http\Request;
use DataTables;

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
}
