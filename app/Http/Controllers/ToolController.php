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

class ToolController extends Controller
{
    public function backup()
    {
        //ENTER THE RELEVANT INFO BELOW
        $mysqlHostName      = env('DB_HOST');
        $mysqlUserName      = env('DB_USERNAME');
        $mysqlPassword      = env('DB_PASSWORD');
        $DbName             = env('DB_DATABASE');
        $backup_name        = "mybackup.sql";
        $tables             = array("users", "absensi", "barang", "beban_usaha", "export_laporan", "failed_jobs", "karyawan", "laporan_karyawan", "migrations", "password_resets", "transaksi_beban", "transaksi_beli", "transaksi_jual"); //here your tables...

        $connect = new \PDO("mysql:host=$mysqlHostName;dbname=$DbName;charset=utf8", "$mysqlUserName", "$mysqlPassword", array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        $get_all_table_query = "SHOW TABLES";
        $statement = $connect->prepare($get_all_table_query);
        $statement->execute();
        $result = $statement->fetchAll();


        $output = '';
        foreach ($tables as $table) {
            $show_table_query = "SHOW CREATE TABLE " . $table . "";
            $statement = $connect->prepare($show_table_query);
            $statement->execute();
            $show_table_result = $statement->fetchAll();

            foreach ($show_table_result as $show_table_row) {
                $output .= "\n\n" . $show_table_row["Create Table"] . ";\n\n";
            }
            $select_query = "SELECT * FROM " . $table . "";
            $statement = $connect->prepare($select_query);
            $statement->execute();
            $total_row = $statement->rowCount();

            for ($count = 0; $count < $total_row; $count++) {
                $single_result = $statement->fetch(\PDO::FETCH_ASSOC);
                $table_column_array = array_keys($single_result);
                $table_value_array = array_values($single_result);
                $output .= "\nINSERT INTO $table (";
                $output .= "" . implode(", ", $table_column_array) . ") VALUES (";
                $output .= "'" . implode("','", $table_value_array) . "');\n";
            }
        }
        $file_name = 'database_backup_on_' . date('y-m-d') . '.sql';
        $file_handle = fopen($file_name, 'w+');
        fwrite($file_handle, $output);
        fclose($file_handle);
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($file_name));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file_name));
        ob_clean();
        flush();
        readfile($file_name);
        unlink($file_name);
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
