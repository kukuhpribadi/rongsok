@extends('layout.master')
@section('title', 'Absensi Karyawan')
@section('content')
<div class="row">
    <div class="col">
        <div class="card shadow mb-4">
            {{-- header --}}
            <div class="card-header  py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Absensi Karyawan</h6>
            </div>
            {{-- body --}}
            <div class="card-body">
                <form action="#" method="post">
                @csrf
                    <table class="table table-striped" id="dataTable">
                        <tr>
                            <th>No</th>
                            <th>ID Karyawan</th>
                            <th>Nama</th>
                            <th>Role</th>
                            <th>Absensi</th>
                            <th>Keterangan</th>
                        </tr>
                        @foreach ($karyawan as $kr)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$kr->id_karyawan}}</td>
                            <td>{{$kr->nama}}</td>
                            <td>{{$kr->roleKaryawan()}}</td>
                            <td>
                                <select class="form-control" name="absensi[]">
                                  <option value="1">HADIR</option>
                                  <option value="2">TDK HADIR</option>
                                  <option value="3">LIBUR</option>
                                </select>
                            </td>
                            <td>
                                <input type="text" name="keterangan[]" class="form-control" autocomplete="off">
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    <button type="submit" class="btn btn-primary btn-block">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection