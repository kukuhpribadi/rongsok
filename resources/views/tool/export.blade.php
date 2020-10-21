@extends('layout.master')
@section('title', 'Export Laporan')
@section('content')
<div class="row">
    <div class="col">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Export laporan to Excel</h6>
                <button class="btn btn-primary btn-sm" id="modal-2" data-toggle="modal" data-target="#modalTambah"><i class="far fa-plus-square"></i> Export laporan</button>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped" id="dataTable">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Tanggal</th>
                            <th>Jenis</th>
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

<!-- modal tambah -->
<div class="modal fade" tabindex="-1" role="dialog" id="modalTambah">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Export laporan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('exportStore')}}" method="post" id="formTambah">
                <div class="modal-body">
                    @csrf
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
                    <div class="form-group">
                        <label>Jenis Laporan</label>
                        <select class="form-control select2 formTransaksiSelect" id="idSelect" name="jenis_laporan">
                            <option value=""></option>
                            <option value="Pembelian">Pembelian</option>
                            <option value="Penjualan">Penjualan</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="buttonSimpan">Export</button>
                </div>
            </form>
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
            ajax: "{{route('exportData')}}",
            columns: [{
                data: 'DT_RowIndex',
                name: 'id'
            }, {
                data: 'range',
                name: 'range'
            }, {
                data: 'jenis_laporan',
                name: 'jenis_laporan'
            }, {
                data: 'aksi',
                name: 'aksi'
            }]
        });

        // tanggal
        $('.date').datetimepicker({
            format: 'L',
            locale: 'id',
            defaultDate: new Date(),
        });

        let tanggal = $('.datetimepicker-input').val();

        //select2
        $('.formTransaksiSelect').select2({
            placeholder: 'Pilih beban',
            allowClear: true,
        });

        // reset form saat modal close
        $('.modal').on('hidden.bs.modal', function() {
            $(this).find('form')[0].reset();
            $(this).find('.formTransaksiSelect').trigger('change.select2');
            $(this).find('.help-block').remove();
            $(this).find('.is-invalid').removeClass('is-invalid');

            // tanggal
            $('.datetimepicker-input').val(tanggal);
        });

        //post modal
        $('#buttonSimpan').click(function(e) {
            e.preventDefault();
            let form = $('#formTambah');
            let data = form.serialize();
            form.find('.help-block').remove();
            form.find('.is-invalid').removeClass('is-invalid');

            $.ajax({
                url: "{{route('exportStore')}}",
                method: 'post',
                data: data,
                success: function(res) {
                    form.trigger('reset');
                    $('#modalTambah').modal('hide');
                    $('#dataTable').DataTable().ajax.reload();
                    Swal.fire('Sukses!', 'Export laporan ditambahkan', 'success');
                },
                error: function(data) {
                    let res = data.responseJSON;
                    if ($.isEmptyObject(res) == false) {
                        $.each(res.errors, function(key, value) {
                            $('#' + key)
                                .closest('.form-group')
                                .append('<span class="help-block text-danger">' + value + '</span>');
                            $('#' + key).addClass('is-invalid');
                        })
                    }
                }
            })
        });

        //delete data ajax
        $('#dataTable').on('click', '#buttonDelete', function(e) {
            e.preventDefault();

            let url = $(this).attr('href');
            let jenis = $(this).attr("data-jenis_laporan");
            let tanggal = $(this).attr("data-range");

            Swal.fire({
                    title: 'Yakin akan menghapus data?',
                    text: `${jenis} tanggal ${tanggal}`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Hapus!'
                })
                .then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: url,
                            method: "DELETE",
                            data: {
                                '_token': '{{ csrf_token() }}',
                            },
                            success: function(response) {
                                $('#dataTable').DataTable().ajax.reload();
                                Swal.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                )
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    type: 'error',
                                    title: 'Oops...',
                                    text: 'Something went wrong!'
                                });
                            }
                        });
                    }
                })
        });

        // $('#dataTable').on('click', '#buttonDownload', function(e) {
        //     e.preventDefault();
        //     let id = $(this).attr("data-id");
        //     let url = $(this).attr("href");
        //     $.ajax({
        //         url: url,
        //         method: "get",
        //         success: function(response) {
        //             console.log(response)
        //         },
        //         error: function(xhr) {
        //             Swal.fire({
        //                 type: 'error',
        //                 title: 'Oops...',
        //                 text: 'Data kosong'
        //             });
        //         }
        //     });
        // });
    })
</script>
@endsection