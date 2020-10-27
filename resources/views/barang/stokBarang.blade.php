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
                    <a class="dropdown-item" href="#" data-periode="Hari">Hari</a>
                    <a class="dropdown-item" href="#" data-periode="Bulan">Bulan</a>
                    <a class="dropdown-item" href="#" data-periode="Tahun">Tahun</a>
                </div>
                <!-- <select name="filter_periode" id="filter_periode" class="form-control">
                    <option value=""> Pilih Periode </option>
                    <option value="hari">hari</option>
                    <option value="bulan"> bulan </option>
                    <option value="tahun"> tahun </option>
                </select> -->
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
        let data = "Hari";
        $('.dropdown-item').click(function(e) {
            data = $(this).data('periode');
            $('#dropdownMenuButton').text(data);
        })

        // datatable
        let table = $('#dataTable').DataTable({
            responsive: true,
            serverSide: false,
            ajax: {
                "url": "{{route('dataStokBarang')}}",
                "data": function(d) {
                    d.filter_periode = data.toLowerCase();
                }
            },
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
        //filter Berdasarkan periode
        $('.dropdown-item').click(function(e) {
            $('#dataTable').DataTable().ajax.reload();
        });

    });
</script>

@endsection