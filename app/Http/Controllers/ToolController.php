<?php

namespace App\Http\Controllers;

use App\ExportLaporan;
use App\Exports\PembelianExport;
use App\Exports\PenjualanExport;
use Error;
use Excel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Artisan;

class ToolController extends Controller
{
    public function backup()
    {
        //ENTER THE RELEVANT INFO BELOW
        // $mysqlHostName      = env('DB_HOST');
        // $mysqlUserName      = env('DB_USERNAME');
        // $mysqlPassword      = env('DB_PASSWORD');
        // $DbName             = env('DB_DATABASE');
        // $backup_name        = "mybackup.sql";
        // $tables             = array("users", "absensi", "barang", "beban_usaha", "export_laporan", "failed_jobs", "karyawan", "laporan_karyawan", "migrations", "password_resets", "transaksi_beban", "transaksi_beli", "transaksi_jual"); //here your tables...

        // $mysqldump = exec('which mysqldump');


        // $command = "mysqldump --opt -h $mysqlHostName -u $mysqlUserName -p $mysqlPassword $DbName > $DbName.sql";
        // exec($command);

        // Artisan::call()
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
                return '<a href="' . route('exportDownload', $ex->id) . '" data-id="' . $ex->id . '" class="btn btn-sm btn-icon btn-success" id="buttonDownload"><i class="fas fa-download"></i> Excel</a>
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

    public function exportDelete($id)
    {
        ExportLaporan::find($id)->delete();
    }

    public function exportDownload($id)
    {
        $export = ExportLaporan::find($id);
        if ($export->jenis_laporan == 'Pembelian') {
            try {
                return Excel::download(new PembelianExport($export->range), 'Laporan-Pembelian-' . str_replace('/', '', $export->range) . '.xlsx');
            } catch (Exception $exception) {
                return redirect()->back()->with('gagal', 'Gagal export, data tidak tersedia');
            }
        } elseif ($export->jenis_laporan == 'Penjualan') {
            try {
                return Excel::download(new PenjualanExport($export->range), 'Laporan-Penjualan-' . str_replace('/', '', $export->range) . '.xlsx');
            } catch (Exception $exception) {
                return redirect()->back()->with('gagal', 'Gagal export, data tidak tersedia');
            }
        }
    }
}
