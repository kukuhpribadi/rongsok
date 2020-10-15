@extends('layout.master')
@section('title', 'Set Beban Usaha')
@section('content')
<div class="row">
    <!-- Area Chart -->
    <div class="col">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Set Beban Usaha</h6>
                <button class="btn btn-primary btn-sm" id="modal-2" data-toggle="modal" data-target="#modalTambah"><i class="far fa-plus-square"></i> Tambah Beban Usaha</button>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <table class="table table-bordered table-striped" id="dataTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jenis beban</th>
                            <th>Harga</th>
                            <th>Keterangan</th>
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
                <h5 class="modal-title">Tambah Beban Usaha</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('bebanStore')}}" method="post" id="formTambah">
                    @csrf
                    <div class="form-group">
                        <label>Jenis beban</label>
                        <input type="text" class="form-control" name="jenis_beban" id="jenis_beban" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>Harga</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    Rp
                                </div>
                            </div>
                            <input type="text" class="form-control" name="harga" id="harga" data-a-dec="," data-a-sep="." autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <input type="text" class="form-control" name="keterangan" id="keterangan" autocomplete="off">
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

<!-- modal edit -->
<div class="modal fade" tabindex="-1" role="dialog" id="modalEdit">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Beban Usaha</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="post" id="formEdit">
                    @csrf
                    <input type="hidden" name="id" id="idEdit">
                    <div class="form-group">
                        <label>Jenis beban</label>
                        <input type="text" class="form-control" name="jenisBeban" id="jenisBebanEdit" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>Harga</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    Rp
                                </div>
                            </div>
                            <input type="text" class="form-control" name="harga" id="hargaEdit" data-a-dec="," data-a-sep="." autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <input type="text" class="form-control" name="keterangan" id="keteranganEdit" autocomplete="off">
                    </div>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="buttonUpdate">Update data</button>
                </form>
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
            ajax: "{{route('bebanData')}}",
            columns: [{
                data: 'DT_RowIndex',
                name: 'id'
            }, {
                data: 'jenis_beban',
                name: 'jenis_beban'
            }, {
                data: 'harga',
                name: 'harga'
            }, {
                data: 'keterangan',
                name: 'keterangan'
            }, {
                data: 'aksi',
                name: 'aksi'
            }]
        });

        // reset form saat modal close
        $('.modal').on('hidden.bs.modal', function() {
            $(this).find('form')[0].reset();
            $(this).find('.help-block').remove();
            $(this).find('.is-invalid').removeClass('is-invalid');
        });

        // autoNumeric pada form harga
        $('#harga, #hargaEdit').autoNumeric('init', {
            mDec: '0'
        });

        //post modal
        $('#buttonSimpan').click(function(e) {
            e.preventDefault();
            let form = $('#formTambah');
            let data = form.serialize();
            form.find('.help-block').remove();
            form.find('.is-invalid').removeClass('is-invalid');

            $.ajax({
                url: "{{route('bebanStore')}}",
                method: 'post',
                data: data,
                success: function(res) {
                    form.trigger('reset');
                    $('#modalTambah').modal('hide');
                    $('#dataTable').DataTable().ajax.reload();
                    Swal.fire('Sukses!', 'Beban usaha berhasil ditambahkan', 'success');
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

        // edit modal
        $('#modalEdit').on('show.bs.modal', function(event) {
            let button = $(event.relatedTarget)
            let id = button.data('id');
            let jenisBeban = button.data('jenis_beban');
            let harga = button.data('harga');
            let keterangan = button.data('keterangan');
            let modal = $(this);
            modal.find('.modal-body #idEdit').val(id);
            modal.find('.modal-body #jenisBebanEdit').val(jenisBeban);
            modal.find('.modal-body #hargaEdit').val(harga);
            modal.find('.modal-body #keteranganEdit').val(keterangan);
        });

        // update data ajax
        $('#buttonUpdate').click(function(e) {
            e.preventDefault();
            let form = $('#formEdit');
            let data = form.serialize();

            $.ajax({
                url: "{{route('bebanUpdate')}}",
                method: 'post',
                data: data,
                success: function(res) {
                    form.trigger('reset');
                    $('#modalEdit').modal('hide');
                    $('#dataTable').DataTable().ajax.reload();
                    Swal.fire('Sukses!', 'Beban usaha berhasil diubah', 'success');
                },
                error: function(data) {
                    let res = data.responseJSON;
                }
            })
        });

        //delete data ajax
        $('#dataTable').on('click', '#buttonDelete', function(e) {
            e.preventDefault();

            let url = $(this).attr('href');
            let nama = $(this).attr("data-jenis_beban");

            Swal.fire({
                    title: 'Yakin akan menghapus data?',
                    text: `${nama}`,
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
    });
</script>
@endsection