@extends('layout.master')
@section('title', 'Karyawan')
@section('content')
<div class="row">
    <!-- Area Chart -->
    <div class="col">
        <div class="card shadow mb-4">
            {{-- header --}}
            <div class="card-header  py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Data Karyawan</h6>
                <button class="btn btn-primary btn-sm" id="modal-2" data-toggle="modal" data-target="#modalTambah"><i class="far fa-plus-square"></i> Tambah karyawan</button>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <table class="table table-bordered table-striped" id="dataTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Karyawan</th>
                            <th>Nama</th>
                            <th>No. Telepon</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Tgl. Gabung</th>
                            <th>Upah</th>
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


{{-- modal tambah--}}
<div class="modal fade" tabindex="-1" role="dialog" id="modalTambah">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Karyawan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('karyawanStore')}}" method="post" id="formTambah">
                    @csrf
                    <div class="form-group">
                        <label>ID Karyawan</label>
                        <input type="text" class="form-control" name="id_karyawan" id="id_karyawan" autocomplete="off" readonly value="{{$idKaryawan}}">
                    </div>
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control" name="nama" id="nama" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>No. Telepon </label>
                        <input type="text" class="form-control" name="no_telp" id="no_telp" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <input type="text" class="form-control" name="alamat" id="alamat" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>Upah</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    Rp
                                </div>
                            </div>
                            <input type="text" class="form-control" name="upah" id="upah" data-a-dec="," data-a-sep="." autocomplete="off">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="role">Role</label>
                                <select class="form-control" id="role" name="role">
                                    <option value="1">Admin</option>
                                    <option value="2">Sopir</option>
                                    <option value="3">Kuli</option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="1">Aktif</option>
                                    <option value="2">Tidak Aktif</option>
                                </select>
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

{{-- modal edit--}}
<div class="modal fade" tabindex="-1" role="dialog" id="modalEdit">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Data Karyawan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('karyawanStore')}}" method="post" id="formEdit">
                    @csrf
                    <input type="hidden" name="id" id="idEdit">
                    <div class="form-group">
                        <label>ID Karyawan</label>
                        <input type="text" class="form-control" name="id_karyawan" id="id_karyawanEdit" autocomplete="off" readonly value="{{$idKaryawan}}">
                    </div>
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control" name="nama" id="namaEdit" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>No. Telepon </label>
                        <input type="text" class="form-control" name="no_telp" id="no_telpEdit" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <input type="text" class="form-control" name="alamat" id="alamatEdit" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>Upah</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    Rp
                                </div>
                            </div>
                            <input type="text" class="form-control" name="upah" id="upahEdit" data-a-dec="," data-a-sep="." autocomplete="off">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="role">Role</label>
                                <select class="form-control" id="roleEdit" name="role">
                                    <option value="1">Admin</option>
                                    <option value="2">Sopir</option>
                                    <option value="3">Kuli</option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" id="statusEdit" name="status">
                                    <option value="1">Aktif</option>
                                    <option value="2">Tidak Aktif</option>
                                </select>
                            </div>
                        </div>
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
            ajax: "{{route('dataKaryawan')}}",
            columns: [{
                data: 'DT_RowIndex',
                name: 'id'
            }, {
                data: 'id_karyawan',
                name: 'id_karyawan'
            }, {
                data: 'nama',
                name: 'nama'
            }, {
                data: 'no_telp',
                name: 'no_telp'
            }, {
                data: 'role',
                name: 'role'
            }, {
                data: 'status',
                name: 'status'
            }, {
                data: 'tanggal',
                name: 'tanggal'
            }, {
                data: 'upah',
                name: 'upah'
            }, {
                data: 'aksi',
                name: 'aksi'
            }]
        });

        // autoNumeric pada form harga
        $('#upah, #upahEdit').autoNumeric('init', {
            mDec: '0'
        });

        // reset form saat modal close
        $('.modal').on('hidden.bs.modal', function() {
            $(this).find('form')[0].reset();
        });

        // edit modal
        $('#modalEdit').on('show.bs.modal', function(event) {
            let button = $(event.relatedTarget)
            let id = button.data('id');
            let idKaryawan = button.data('id_karyawan');
            let nama = button.data('nama');
            let noTelp = button.data('no_telp');
            let alamat = button.data('alamat');
            let role = button.data('role');
            let status = button.data('status');
            let upah = button.data('upah');
            let modal = $(this);
            modal.find('.modal-body #idEdit').val(id);
            modal.find('.modal-body #id_karyawanEdit').val(idKaryawan);
            modal.find('.modal-body #namaEdit').val(nama);
            modal.find('.modal-body #no_telpEdit').val(noTelp);
            modal.find('.modal-body #alamatEdit').val(alamat);
            modal.find('.modal-body #upahEdit').val(upah);
            modal.find('.modal-body #roleEdit option').each((i, data) => {
                if (data.value == role) {
                    $(data).attr('selected', 'selected');
                }
            });
            modal.find('.modal-body #statusEdit option').each((i, data) => {
                if (data.value == status) {
                    $(data).attr('selected', 'selected');
                }
            });
        });

        // update data ajax
        $('#buttonUpdate').click(function(e) {
            e.preventDefault();
            let form = $('#formEdit');
            let data = form.serialize();

            $.ajax({
                url: "{{route('karyawanUpdate')}}",
                method: 'post',
                data: data,
                success: function(res) {
                    form.trigger('reset');
                    $('#modalEdit').modal('hide');
                    $('#dataTable').DataTable().ajax.reload();
                    Swal.fire('Sukses!', 'Data karyawan berhasil diubah', 'success');
                },
                error: function(data) {
                    let res = data.responseJSON;
                    // if ($.isEmptyObject(res) == false) {
                    //     $.each(res.errors, function(key, value) {
                    //         $('input[name ="'+ key +'"]')
                    //             .closest('.form-group')
                    //             .append('<span class="help-block text-danger">' + value + '</span>');
                    //         $('input[name ="'+ key +'"]').addClass('is-invalid');
                    //     })
                    // }
                }
            })
        });


        //delete data ajax
        $('#dataTable').on('click', '#buttonDelete', function(e) {
            e.preventDefault();

            let url = $(this).attr('href');
            let idKaryawan = $(this).attr("data-id_karyawan");
            let nama = $(this).attr("data-nama");

            Swal.fire({
                    title: 'Yakin akan menghapus data?',
                    text: `${idKaryawan} | ${nama}`,
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