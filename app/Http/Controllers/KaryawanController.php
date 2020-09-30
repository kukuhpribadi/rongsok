<?php

namespace App\Http\Controllers;

use App\Karyawan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KaryawanController extends Controller
{
    public function getKaryawanId()
    {
        $idKaryawan = Karyawan::latest('id')->first();

        if ($idKaryawan === null) {
            $idKaryawan = 'KR' . sprintf("%05s", 1);
        } else {
            $idKaryawan = $idKaryawan->id_karyawan;
            $idKaryawan = explode('KR', $idKaryawan);
            $idKaryawan = 'KR' . sprintf("%05s", $idKaryawan[1] + 1);
        }

        return $idKaryawan;
    }

    public function index()
    {
        $idKaryawan = $this->getKaryawanId();
        return view('karyawan.index', compact('idKaryawan'));
    }

    public function dataKaryawan()
    {
        $karyawan = Karyawan::query();
        return DataTables::eloquent($karyawan)
            ->addIndexColumn()
            ->addColumn('aksi', function ($kr) {
                return '<a href="#" class="btn btn-sm btn-icon btn-primary" data-id="' . $kr->id . '" data-id_karyawan="' . $kr->id_karyawan . '" data-no_telp="' . $kr->no_telp . '" data-nama="' . $kr->nama . '" data-alamat="' . $kr->alamat . '" data-role="' . $kr->role . '" data-status="' . $kr->status . '" data-upah="' . number_format($kr->upah, 0, ',', '.') . '" data-toggle="modal" data-target="#modalEdit"><i class="far fa-edit"></i></a>
                <a href="' . route("karyawanDelete", $kr->id) . '" class="btn btn-sm btn-icon btn-danger" id="buttonDelete" data-id_karyawan="' . $kr->id_karyawan . '" data-nama="' . $kr->nama . '"><i class="far fa-trash-alt"></i></a>';
            })
            ->editColumn('role', function ($rl) {
                if ($rl->role == 1) {
                    return 'Admin';
                } elseif ($rl->role == 2) {
                    return 'Sopir';
                } else {
                    return 'Kuli';
                }
            })
            ->editColumn('status', function ($st) {
                if ($st->status == 1) {
                    return '<span class="badge badge-success">Aktif</span>';
                }
                return '<span class="badge badge-danger">Tidak Aktif</span>';
            })
            ->editColumn('tanggal', function ($tgl) {
                return $tgl->created_at->format('d-m-Y');
            })
            ->editColumn('upah', function ($upah) {
                return "Rp " . number_format($upah->upah, 0, ',', '.');
            })
            ->rawColumns(['aksi', 'status'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $upah = str_replace('.', '', $request->upah);
        $karyawan = Karyawan::create([
            'id_karyawan' => $request->id_karyawan,
            'nama' => $request->nama,
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
            'role' => $request->role,
            'status' => $request->status,
            'upah' => $upah,
        ]);
        return redirect(route('karyawanIndex'))->with('sukses', 'Data karyawan berhasil ditambahkan!');
    }

    public function update(Request $request)
    {
        $karyawan = Karyawan::find($request->id);
        $upah = str_replace('.', '', $request->upah);
        $karyawan->update([
            'id_karyawan' => $request->id_karyawan,
            'nama' => $request->nama,
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
            'role' => $request->role,
            'status' => $request->status,
            'upah' => $upah,
        ]);
    }

    public function delete($id)
    {
        Karyawan::find($id)->delete();
    }

    public function absensi()
    {
        $karyawan = Karyawan::all();
        return view('karyawan.absensi', compact('karyawan'));
    }
}
