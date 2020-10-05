@extends('layout.master')
@section('title', 'Detail Laporan Kinerja Karyawan')
@section('content')
<div class="row">
    <!-- Area Chart -->
    <div class="col">
        <div class="card shadow mb-4">
            {{-- header --}}
            <form action="{{route('karyawanLaporanUpdate', $id)}}" method="post">
                @csrf
            <div class="card-header  py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Detail Laporan Kinerja Karyawan {{$rangeTanggal}}</h6>
                <div>
                    @if ($status == 0)
                    <button type="submit" class="btn btn-primary btn-sm"><i class="far fa-plus-square"></i> Bayar upah</button>
                    @else
                    <button type="submit" class="btn btn-danger btn-sm"><i class="far fa-window-close"></i> Batalkan pembayaran</button>
                    @endif
                </div>
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
                        <td>
                            {{$dt->where('karyawan_id', $dt->karyawan->id)->where('absensi', 1)->whereBetween('tanggal_absen', [$tanggalStart, $tanggalEnd])->count()}}
                        </td>
                        <td>
                            {{$dt->where('karyawan_id', $dt->karyawan->id)->where('absensi', 2)->whereBetween('tanggal_absen', [$tanggalStart, $tanggalEnd])->count()}}
                        </td>
                        <td>
                            {{$dt->where('karyawan_id', $dt->karyawan->id)->where('absensi', 3)->whereBetween('tanggal_absen', [$tanggalStart, $tanggalEnd])->count()}}
                        </td>
                        <td>
                            Rp. {{number_format($dt->where('karyawan_id', $dt->karyawan->id)->where('absensi', 1)->whereBetween('tanggal_absen', [$tanggalStart, $tanggalEnd])->sum('upah'),0, ',', '.')}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="6" class="text-center font-weight-bold">TOTAL</td>
                        <td id="grandTotal">Rp. {{number_format($grandTotal->sum('upah'),0, ',', '.')}}</td>
                        <input type="hidden" name="grandTotal" value="{{$grandTotal->sum('upah')}}">
                        {{-- <input type="hidden" name="status" value="{{$grandTotal->sum('upah')}}"> --}}
                    </tr>
                </tfoot>
                </table>  
            </div>
        </form>
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