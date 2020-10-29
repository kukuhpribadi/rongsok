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
                <span>
                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Hari
                    </button>
                    <button class="btn btn-primary btn-sm" id="modal-2" data-toggle="modal" data-target="#modalTambah"><i class="fas fa-search"></i> Set tanggal</button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="#" data-periode="Hari">Hari</a>
                        <a class="dropdown-item" href="#" data-periode="Bulan">Bulan</a>
                        <a class="dropdown-item" href="#" data-periode="Tahun">Tahun</a>
                    </div>
                </span>
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

<!-- modal edit -->
<div class="modal fade" tabindex="-1" role="dialog" id="modalEdit">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Stok Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" method="post" id="formEdit">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="id" id="idEdit">
                    <div class="form-group">
                        <label>Jenis barang</label>
                        <input type="text" class="form-control" name="nama" id="namaEdit" autocomplete="off" readonly>
                    </div>
                    <div class="form-group">
                        <label>Stok barang</label>
                        <input type="text" class="form-control" name="stok" id="stokEdit" autocomplete="off">
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="buttonUpdate">Update data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- modal set tanggal -->
<div class="modal fade" tabindex="-1" role="dialog" id="modalTambah">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Set tanggal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" method="get" id="formTambah">
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="datetimepicker4">Dari</label>
                                <div class="input-group date" id="datetimepicker4start" data-target-input="nearest">
                                    <input type="text" name="tanggalStart" class="form-control datetimepicker-input" data-target="#datetimepicker4start" />
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
                                    <input type="text" name="tanggalEnd" class="form-control datetimepicker-input" data-target="#datetimepicker4end" />
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
                    <button type="submit" class="btn btn-primary" id="buttonSimpan">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {

        // tanggal
        $('.date').datetimepicker({
            format: 'L',
            locale: 'id',
            defaultDate: new Date(),
        });

        let tanggal = $('.datetimepicker-input').val();
        // reset form saat modal close
        $('.modal').on('hidden.bs.modal', function() {
            $(this).find('form')[0].reset();
            $(this).find('.formTransaksiSelect').trigger('change.select2');
            $(this).find('.help-block').remove();
            $(this).find('.is-invalid').removeClass('is-invalid');

            // tanggal
            $('.datetimepicker-input').val(tanggal);
        });


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

        $('#buttonSimpan').click(function(e) {
            e.preventDefault();
            let form = $('#formTambah');
            data = form.serializeArray();
            tanggalStart = data[0].value.split("/");
            tanggalStart = `${tanggalStart[2]}-${tanggalStart[1]}-${tanggalStart[0]}`;
            tanggalEnd = data[1].value.split("/");
            tanggalEnd = `${tanggalEnd[2]}-${tanggalEnd[1]}-${tanggalEnd[0]}`;
            data = `${tanggalStart}/${tanggalEnd}`;
            $.ajax({
                url: "{{route('dataStokBarang')}}",
                method: 'get',
                data: data,
                success: function(res) {
                    form.trigger('reset');
                    $('#modalTambah').modal('hide');
                    $('#dataTable').DataTable().ajax.reload();
                },
                error: function(data) {}
            })
        });

        // edit modal
        $('#modalEdit').on('show.bs.modal', function(event) {
            let button = $(event.relatedTarget)
            let id = button.data('id');
            let nama = button.data('nama');
            let stok = button.data('stok');
            let modal = $(this);
            modal.find('.modal-body #idEdit').val(id);
            modal.find('.modal-body #namaEdit').val(nama);
            modal.find('.modal-body #stokEdit').val(stok);
        });

        // update data ajax
        $('#buttonUpdate').click(function(e) {
            e.preventDefault();
            let form = $('#formEdit');
            let data = form.serialize();

            $.ajax({
                url: "{{route('stokBarangUpdate')}}",
                method: 'post',
                data: data,
                success: function(res) {
                    form.trigger('reset');
                    $('#modalEdit').modal('hide');
                    $('#dataTable').DataTable().ajax.reload();
                    Swal.fire('Sukses!', 'Data barang berhasil diubah', 'success');
                },
                error: function(data) {
                    let res = data.responseJSON;
                }
            })
        });
    });
</script>

@endsection