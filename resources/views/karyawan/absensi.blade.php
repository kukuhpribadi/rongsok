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
                <form action="{{route('karyawanAbsensiStore')}}" method="post" id="formTambah">
                @csrf
                    <div class="row">
                        <div class="form-group col-3">
                            <label for="datetimepicker4">Pilih Tanggal</label>
                            <div class="input-group date" id="datetimepicker4" data-target-input="nearest">
                                <input type="text" name="tanggal_absen" class="form-control datetimepicker-input" data-target="#datetimepicker4"/>
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
                        @foreach ($karyawan as $kr)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td><input type="hidden" name="idKaryawan[]" value="{{$kr->id}}">{{$kr->id_karyawan}}</td>
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
                    <button type="submit" class="btn btn-primary btn-block" id="simpanData">Submit</button>
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

    $('#simpanData').on('click', function (e){
        e.preventDefault();
        let data = $('#formTambah').serialize();
        $.ajax({
            url: "{{route('karyawanAbsensiStore')}}",
            method: 'post',
            data: data,
            success: function(res) {
                Swal.fire('Sukses!','Absensi berhasil ditambahkan','success');
                location.replace("{{route('absensiIndex')}}");
            },
            error: function(data) {
                let pesan = data.responseJSON.message;
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: pesan,
                })
            }
        })

    });

});
</script>    
@endsection