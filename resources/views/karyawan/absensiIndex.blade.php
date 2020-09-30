@extends('layout.master')
@section('title', 'Data Absen Karyawan')
@section('content')
<div class="row">
    <!-- Area Chart -->
    <div class="col">
        <div class="card shadow mb-4">
            {{-- header --}}
            <div class="card-header  py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Data Absen Karyawan</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <table class="table table-bordered table-striped" id="dataTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Absen</th>
                        <th>Total Absen</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
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
  // datatable
  $('#dataTable').DataTable({
    responsive: true,
    serverSide: false,
    ajax: '{{route('absensiData')}}',
    columns: [{
            data: 'DT_RowIndex', 
            name: 'id'
        }, {
            data: 'tanggal_absen', 
            name: 'tanggal_absen'
        }, {
            data: 'total_absen', 
            name: 'total_absen'
        }, {
            data: 'aksi', 
            name: 'aksi'
        }]
  });

});
</script>
@endsection