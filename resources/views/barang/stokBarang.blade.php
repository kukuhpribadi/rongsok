@extends('layout.master')
@section('title', 'Stok Barang')
@section('content')
<div class="row">
    <!-- Area Chart -->
    <div class="col">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Stok Barang</h6>
                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Hari
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#">Hari</a>
                    <a class="dropdown-item" href="#">Bulan</a>
                    <a class="dropdown-item" href="#">Tahun</a>
                </div>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <table class="table table-bordered table-striped" id="dataTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jenis barang</th>
                            <th>Masuk</th>
                            <th>Keluar</th>
                            <th>Stok</th>
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
    $(document).ready(function() {
        // datatable
        $('#dataTable').DataTable({
            responsive: true,
            serverSide: false,
            ajax: "{{route('dataStokBarang')}}",
            columns: [{
                data: 'DT_RowIndex',
                name: 'id'
            }, {
                data: 'nama',
                name: 'nama'
            }, {
                data: 'masuk',
                name: 'masuk'
            }, {
                data: 'keluar',
                name: 'keluar'
            }, {
                data: 'stok',
                name: 'stok'
            }, {
                data: 'aksi',
                name: 'aksi'
            }]
        });

    });
</script>

@endsection