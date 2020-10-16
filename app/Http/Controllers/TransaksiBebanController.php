<?php

namespace App\Http\Controllers;

use App\BebanUsaha;
use App\TransaksiBeban;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TransaksiBebanController extends Controller
{
    public function bebanBayar()
    {
        $beban = BebanUsaha::all();
        return view('beban.bayar', compact('beban'));
    }



    public function bebanBayarData()
    {
        function formatTanggal($tanggal)
        {
            $tanggalEdit = explode('-', $tanggal);
            $tanggalEdit = $tanggalEdit[2] . '/' . $tanggalEdit[1] . '/' . $tanggalEdit[0];
            return $tanggalEdit;
        }

        $beban = TransaksiBeban::query()->orderBy('tanggal_pembayaran', 'desc');
        return DataTables::eloquent($beban)
            ->addIndexColumn()
            ->addColumn('aksi', function ($b) {
                return '<a href="#" class="btn btn-sm btn-icon btn-primary" data-toggle="modal" data-id="' . $b->id . '" data-beban_usaha_id="' . $b->beban_usaha_id . '" data-harga="' . number_format($b->harga, 0, ',', '.') . '" data-no_nota="' . $b->no_nota . '" data-tanggal_pembayaran="' . formatTanggal($b->tanggal_pembayaran) . '" data-keterangan="' . $b->keterangan . '" data-target="#modalEdit"><i class="far fa-edit"></i></a>
                <a href="' . route('bebanBayarDelete', $b->id) . '" data-jenis_beban="' . $b->beban_usaha->jenis_beban . '" data-tanggal_pembayaran="' . \Carbon\Carbon::parse($b->tanggal_pembayaran)->translatedFormat('D, d-m-Y') . '" class="btn btn-sm btn-icon btn-danger" id="buttonDelete"><i class="far fa-trash-alt"></i></a>';
            })
            ->editColumn('jenis_beban', function ($b) {
                return $b->beban_usaha->jenis_beban;
            })
            ->editColumn('harga', function ($h) {
                return "Rp " . number_format($h->harga, 0, ',', '.');
            })
            ->editColumn('tanggal_pembayaran', function ($t) {
                return \Carbon\Carbon::parse($t->tanggal_pembayaran)
                    ->translatedFormat('D, d-m-Y');
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function bebanBayarStore(Request $request)
    {
        if (isset($request->harga)) {
            $harga = str_replace('.', '', $request->harga);
        } else {
            $harga = null;
        }
        $tanggalPembayaran = explode('/', $request->tanggal_pembayaran);
        $tanggalPembayaran = $tanggalPembayaran[2] . '-' . $tanggalPembayaran[1] . '-' . $tanggalPembayaran[0];

        TransaksiBeban::create([
            'beban_usaha_id' => $request->jenis_beban,
            'harga' => $harga,
            'no_nota' => $request->no_nota,
            'tanggal_pembayaran' => $tanggalPembayaran,
            'keterangan' => $request->keterangan
        ]);
    }

    public function bebanBayarUpdate(Request $request)
    {
        $transaksiBeban = TransaksiBeban::find($request->id);

        if (isset($request->harga)) {
            $harga = str_replace('.', '', $request->harga);
        } else {
            $harga = null;
        }
        $tanggalPembayaran = explode('/', $request->tanggal_pembayaran);
        $tanggalPembayaran = $tanggalPembayaran[2] . '-' . $tanggalPembayaran[1] . '-' . $tanggalPembayaran[0];

        $transaksiBeban->update([
            'beban_usaha_id' => $request->jenis_beban,
            'harga' => $harga,
            'no_nota' => $request->no_nota,
            'tanggal_pembayaran' => $tanggalPembayaran,
            'keterangan' => $request->keterangan
        ]);
    }

    public function bebanBayarDelete($id)
    {
        TransaksiBeban::find($id)->delete();
    }
}
