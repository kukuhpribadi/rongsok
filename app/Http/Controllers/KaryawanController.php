<?php

namespace App\Http\Controllers;

use App\Absensi;
use App\Karyawan;
use App\LaporanKaryawan;
use Error;
use Exception;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;
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
        $karyawan = Karyawan::where('status', '=', 1)->get();
        return view('karyawan.absensi', compact('karyawan'));
    }

    public function absensiStore(Request $request)
    {
        $tanggalAbsen = explode('/', $request->tanggal_absen);
        $tanggalAbsen = $tanggalAbsen[2] . '-' . $tanggalAbsen[1] . '-' . $tanggalAbsen[0];
        $dataTanggalDB = Absensi::all();

        $cekTanggal = [];
        foreach ($dataTanggalDB as $key => $value) {
            $cekTanggal[] = $dataTanggalDB[$key]->tanggal_absen;
        }


        if (in_array($tanggalAbsen, $cekTanggal)) {
            throw new Exception("Sudah melakukan absen pada tanggal ini");
        } else {
            $karyawan = $request->idKaryawan;
            $absensi = $request->absensi;
            $keterangan = $request->keterangan;

            foreach ($karyawan as $key => $kr) {
                Absensi::create([
                    'tanggal_absen' => $tanggalAbsen,
                    'karyawan_id' => $kr,
                    'absensi' => $absensi[$key],
                    'keterangan' => $keterangan[$key],
                    'upah' => $absensi[$key] == 1 ? Karyawan::find($kr)->upah : 0
                ]);
            }

            // return redirect(route('karyawanAbsensi'))->with('sukses', 'Absensi berhasil!');
        }
    }

    public function absensiIndex()
    {
        return view('karyawan.absensiIndex');
    }

    public function absensiData()
    {
        $absensi = Absensi::groupBy('tanggal_absen')->orderBy('tanggal_absen', 'desc');
        return DataTables::eloquent($absensi)
            ->addIndexColumn()
            ->addColumn('aksi', function ($p) {
                return '<a href="' . route("absensiEdit", $p->tanggal_absen) . '" class="btn btn-sm btn-icon btn-primary"><i class="far fa-edit"></i></a>
                <a href="' . route("absensiDelete", $p->tanggal_absen) . '" class="btn btn-sm btn-icon btn-danger" data-tanggal_absen="' . \Carbon\Carbon::parse($p->tanggal_absen)->translatedFormat('D, d-m-Y') . '"  id="buttonDelete"><i class="far fa-trash-alt"></i></a>';
            })
            ->addColumn('total_absen', function ($a) {
                $absen = Absensi::where('tanggal_absen', $a->tanggal_absen)->where('absensi', '>', 1)->get();
                return count($absen);
            })
            ->editColumn('tanggal_absen', function ($t) {
                return \Carbon\Carbon::parse($t->tanggal_absen)
                    ->translatedFormat('D, d-m-Y');
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function absensiEdit($tanggal)
    {
        $tanggalEdit = explode('-', $tanggal);
        $tanggalEdit = $tanggalEdit[2] . '/' . $tanggalEdit[1] . '/' . $tanggalEdit[0];
        $data = Absensi::where('tanggal_absen', $tanggal)->get();
        return view('karyawan.absensiEdit', compact('data', 'tanggalEdit', 'tanggal'));
    }

    public function absensiUpdate(Request $request, $tanggal)
    {
        $tanggalAbsen = explode('/', $request->tanggal_absen);
        $tanggalAbsen = $tanggalAbsen[2] . '-' . $tanggalAbsen[1] . '-' . $tanggalAbsen[0];
        $dataTanggalDB = Absensi::all();

        $cekTanggal = [];
        foreach ($dataTanggalDB as $key => $value) {
            $cekTanggal[] = $dataTanggalDB[$key]->tanggal_absen;
        }

        if (in_array($tanggalAbsen, $cekTanggal) && $tanggalAbsen != $tanggal) {
            throw new Exception("Sudah melakukan absen pada tanggal ini");
        } else {
            $absensi = Absensi::where('tanggal_absen', $tanggal)->get();
            foreach ($absensi as $key => $value) {
                $absensi[$key]->update([
                    'tanggal_absen' => $tanggalAbsen,
                    'karyawan_id' => $request->idKaryawan[$key],
                    'absensi' => $request->absensi[$key],
                    'keterangan' => $request->keterangan[$key],
                    'upah' => $request->absensi[$key] == 1 ? Karyawan::find($request->idKaryawan[$key])->upah : 0
                ]);
            }
        }
    }

    public function absensiDelete($tanggal)
    {
        Absensi::where('tanggal_absen', $tanggal)->delete();
    }

    public function karyawanLaporan()
    {
        $laporan = LaporanKaryawan::all();
        return view('karyawan.laporan', compact('laporan'));
    }

    public function karyawanLaporanStore(Request $request)
    {
        $range = LaporanKaryawan::create([
            'range' => $request->tanggalStart . '-' . $request->tanggalEnd
        ]);

        return redirect(route('karyawanLaporan'))->with('sukses', 'Laporan berhasil dibuat!');
    }

    public function karyawanLaporanDetail($id)
    {
        $getTanggal = LaporanKaryawan::find($id);
        $rangeTanggal = $getTanggal->range;
        $getTanggal = explode('-', $getTanggal->range);

        $tanggalStart = explode('/', $getTanggal[0]);
        $tanggalStart = $tanggalStart[2] . '-' . $tanggalStart[1] . '-' . $tanggalStart[0];
        $tanggalEnd = explode('/', $getTanggal[1]);
        $tanggalEnd = $tanggalEnd[2] . '-' . $tanggalEnd[1] . '-' . $tanggalEnd[0];

        $data = Absensi::groupBy('karyawan_id')->whereBetween('tanggal_absen', [$tanggalStart, $tanggalEnd])->get();

        return view('karyawan.laporanDetail', compact('rangeTanggal', 'data'));
    }
}
