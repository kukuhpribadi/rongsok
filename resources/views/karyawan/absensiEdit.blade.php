@extends('layout.master')
@section('title', 'Absensi Edit')
@section('content')
<div class="row">
    <div class="col">
        <div class="card shadow mb-4">
            {{-- header --}}
            <div class="card-header  py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Absensi Edit</h6>
            </div>
            {{-- body --}}
            <div class="card-body">
                <form action="{{route('absensiUpdate', $tanggal)}}" method="post" id="formTambah">
                @csrf
                    <div class="row">
                        <div class="form-group col-3">
                            <label for="datetimepicker4">Pilih Tanggal</label>
                            <div class="input-group date" id="datetimepicker4" data-target-input="nearest">
                                <input type="text" name="tanggal_absen" class="form-control datetimepicker-input" data-target="#datetimepicker4" value="{{$tanggalEdit}}"/>
                                <div class="input-group-append" data-target="#datetimepicker4" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped" id="dataTable">
                        <tr>
                            <th>No</th>
                            <th>ID Karyawan</th>
                            <th>Nama</th>
                            <th>Role</th>
                            <th>Absensi</th>
                            <th>Keterangan</th>
                        </tr>
                        @foreach ($data as $dt)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td><input type="hidden" name="idKaryawan[]" value="{{$dt->karyawan->id}}">{{$dt->karyawan->id_karyawan}}</td>
                            <td>{{$dt->karyawan->nama}}</td>
                            <td>{{$dt->karyawan->roleKaryawan()}}</td>
                            <td>
                                <select class="form-control" name="absensi[]">
                                  <option value="1" {{$dt->absensi == 1 ? 'selected' : ''}}>HADIR</option>
                                  <option value="2" {{$dt->absensi == 2 ? 'selected' : ''}}>TDK HADIR</option>
                                  <option value="3" {{$dt->absensi == 3 ? 'selected' : ''}}>LIBUR</option>
                                </select>
                            </td>
                            <td>
                                <input type="text" name="keterangan[]" class="form-control" autocomplete="off" value="{{$dt->keterangan}}">
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    <button type="submit" class="btn btn-primary btn-block" id="updateData">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
$(document).ready(function(){
    $('#datetimepicker4').datetimepicker({
        format: 'L',
        locale: 'id',
        defaultDate: new Date(),
    });

    

});
</script>    
@endsection