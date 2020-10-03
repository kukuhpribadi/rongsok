@extends('layout.master')
@section('title', 'Detail Laporan Kinerja Karyawan')
@section('content')
<div class="row">
    <!-- Area Chart -->
    <div class="col">
        <div class="card shadow mb-4">
            {{-- header --}}
            <div class="card-header  py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Detail Laporan Kinerja Karyawan {{$rangeTanggal}}</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <table class="table table-bordered table-striped" id="dataTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID Karyawan</th>
                        <th>Nama</th>
                        <th>Kehadiran</th>
                        <th>Tidak Hadir</th>
                        <th>Libur</th>
                        <th>Total Upah</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $dt)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$dt->karyawan->id_karyawan}}</td>
                        <td>{{$dt->karyawan->nama}}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            Rp. {{number_format($dt->where('karyawan_id', $dt->karyawan->id)->where('absensi', 1)->sum('upah'),0, ',', '.')}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                </tfoot>
                </table>  
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
$(document).ready(function(){
});
</script>    
@endsection