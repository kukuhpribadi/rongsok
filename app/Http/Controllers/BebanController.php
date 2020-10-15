<?php

namespace App\Http\Controllers;

use App\BebanUsaha;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BebanController extends Controller
{
    public function index()
    {
        return view('beban.index');
    }

    public function bebanData()
    {
        $beban = BebanUsaha::query();
        return DataTables::eloquent($beban)
            ->addIndexColumn()
            ->addColumn('aksi', function ($b) {
                return '<a href="#" class="btn btn-sm btn-icon btn-primary" data-id="' . $b->id . '" data-jenis_beban="' . $b->jenis_beban . '" data-harga="' . number_format($b->harga, 0, ',', '.') . '" data-keterangan="' . $b->keterangan . '" data-toggle="modal" data-target="#modalEdit"><i class="far fa-edit"></i></a>
                <a href="' . route("bebanDelete", $b->id) . '" data-jenis_beban="' . $b->jenis_beban . '" class="btn btn-sm btn-icon btn-danger" id="buttonDelete"><i class="far fa-trash-alt"></i></a>';
            })
            ->editColumn('harga', function ($h) {
                return "Rp " . number_format($h->harga, 0, ',', '.');
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'jenis_beban' => 'required',
        ]);

        if (isset($request->harga)) {
            $harga = str_replace('.', '', $request->harga);
        } else {
            $harga = 0;
        }

        BebanUsaha::create([
            'jenis_beban' => $request->jenis_beban,
            'harga' => $harga,
            'keterangan' => $request->keterangan
        ]);
    }

    public function update(Request $request)
    {
        $harga = str_replace('.', '', $request->harga);

        $beban = BebanUsaha::find($request->id);

        $beban->update([
            'jenis_beban' => $request->jenisBeban,
            'harga' => $harga,
            'keterangan' => $request->keterangan
        ]);
    }

    public function delete($id)
    {
        BebanUsaha::find($id)->delete();
    }
}
