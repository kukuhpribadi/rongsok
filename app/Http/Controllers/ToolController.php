<?php

namespace App\Http\Controllers;

use App\ExportLaporan;
use App\Exports\PenjualanExport;
use Excel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class ToolController extends Controller
{
    public function backup()
    {
        return view('tool.backup');
    }

    public function exportIndex()
    {
        return view('tool.export');
    }

    public function exportData()
    {
        $export = ExportLaporan::query()->orderBy('created_at', 'desc');
        return DataTables::eloquent($export)
            ->addIndexColumn()
            ->addColumn('aksi', function ($ex) {
                return '<a href="' . route('exportDownload', $ex->id) . '" class="btn btn-sm btn-icon btn-primary" id="downloadButton"><i class="fas fa-download"></i></a>
                <a href="' . route('exportDelete', $ex->id) . '" data-range="' . $ex->range . '" data-jenis_laporan="' . $ex->jenis_laporan . '" class="btn btn-sm btn-icon btn-danger" id="buttonDelete"><i class="far fa-trash-alt"></i></a>';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function exportStore(Request $request)
    {
        ExportLaporan::create([
            'range' => $request->tanggalStart . '-' . $request->tanggalEnd,
            'jenis_laporan' => $request->jenis_laporan
        ]);
    }

    public function exportDownload($id)
    {
        $export = ExportLaporan::find($id);

        if ($export->jenis_laporan == 'Pembelian') {
            return 'export pembelian';
        } elseif ($export->jenis_laporan == 'Penjualan') {
            return $this->exportPenjualan($export->range);
        }
    }

    public function exportPenjualan($tanggal)
    {
        return Excel::download(new PenjualanExport($tanggal), 'Laporan-Penjualan-' . str_replace('/', '', $tanggal) . '.xlsx');
    }
}
