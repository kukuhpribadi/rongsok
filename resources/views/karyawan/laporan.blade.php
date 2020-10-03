@extends('layout.master')
@section('title', 'Laporan Kinerja Karyawan')
@section('content')
<div class="row">
    <!-- Area Chart -->
    <div class="col">
        <div class="card shadow mb-4">
            {{-- header --}}
            <div class="card-header  py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Laporan Kinerja Karyawan</h6>
                <button class="btn btn-primary btn-sm" id="modal-2" data-toggle="modal" data-target="#modalTambah"><i class="far fa-plus-square"></i> Buat laporan</button>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <table class="table table-bordered table-striped" id="dataTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($laporan as $lprn)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$lprn->range}}</td>
                        <td>
                            <a href="{{route('karyawanLaporanDetail', $lprn->id)}}" class="btn btn-sm btn-icon btn-success"><i class="far fa-eye"></i></a>
                            <a href="#" class="btn btn-sm btn-icon btn-danger" id="buttonDelete"><i class="far fa-trash-alt"></i></a>
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

{{-- modal tambah--}}
<div class="modal fade" tabindex="-1" role="dialog" id="modalTambah">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Buat laporan kinerja</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('karyawanLaporanStore')}}" method="post" id="formTambah">
                @csrf
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="datetimepicker4">Dari</label>
                            <div class="input-group date" id="datetimepicker4start" data-target-input="nearest">
                                <input type="text" name="tanggalStart" class="form-control datetimepicker-input" data-target="#datetimepicker4start"/>
                                <div class="input-group-append" data-target="#datetimepicker4start" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="datetimepicker4">Sampai</label>
                            <div class="input-group date" id="datetimepicker4end" data-target-input="nearest">
                                <input type="text" name="tanggalEnd" class="form-control datetimepicker-input" data-target="#datetimepicker4end"/>
                                <div class="input-group-append" data-target="#datetimepicker4end" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="buttonSimpan">Simpan data</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
$(document).ready(function(){
    $('#dataTable').DataTable({});

    $('#datetimepicker4start, #datetimepicker4end').datetimepicker({
        format: 'L',
        locale: 'id',
        defaultDate: new Date(),
    });

});
</script>    
@endsection