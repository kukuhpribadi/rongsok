@extends('layout.master')
@section('title', 'Bayar Beban Usaha')
@section('content')
<div class="row">
    <!-- Area Chart -->
    <div class="col">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Data pembayaran beban usaha</h6>
                <button class="btn btn-primary btn-sm" id="modal-2" data-toggle="modal" data-target="#modalTambah"><i class="far fa-plus-square"></i> Bayar Beban Usaha</button>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <table class="table table-bordered table-striped" id="dataTable">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>No. Nota</th>
                            <th>Jenis beban</th>
                            <th>Total</th>
                            <th>Tgl Pembayaran</th>
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
                <h5 class="modal-title">Pembayaran Beban Usaha</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('bebanBayarStore')}}" method="post" id="formTambah">
                    @csrf
                    <div class="form-group">
                        <label>Jenis beban</label>
                        <select class="form-control select2 formTransaksiSelect" id="idSelect" name="jenis_beban">
                            <option value=""></option>
                            @foreach ($beban as $item)
                            <option data-id="{{$item->id}}" data-harga="{{$item->harga}}" data-jenis_beban="{{$item->jenis_beban}}" value="{{$item->id}}">{{$item->jenis_beban}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Jumlah</label>
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
                        <label>No. Nota / Kwitansi / Pembayaran</label>
                        <input type="text" class="form-control" name="no_nota" id="no_nota" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="datetimepicker4">Tanggal Pembayaran</label>
                        <div class="input-group date" id="datetimepicker4" data-target-input="nearest">
                            <input type="text" name="tanggal_pembayaran" class="form-control datetimepicker-input" data-target="#datetimepicker4" />
                            <div class="input-group-append" data-target="#datetimepicker4" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea name="keterangan" id="keterangan" cols="30" rows="5" class="form-control"></textarea>
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

<!-- modal tambah -->
<div class="modal fade" tabindex="-1" role="dialog" id="modalEdit">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Pembayaran Beban Usaha</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('bebanBayarStore')}}" method="post" id="formEdit">
                    @csrf
                    <input type="hidden" name="id" id="idEdit">
                    <div class="form-group">
                        <label>Jenis beban</label>
                        <select class="form-control select2 formTransaksiSelect" id="idSelectEdit" name="jenis_beban">
                            <option value=""></option>
                            @foreach ($beban as $item)
                            <option data-id="{{$item->id}}" data-harga="{{$item->harga}}" data-jenis_beban="{{$item->jenis_beban}}" value="{{$item->id}}">{{$item->jenis_beban}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Jumlah</label>
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
                        <label>No. Nota / Kwitansi / Pembayaran</label>
                        <input type="text" class="form-control" name="no_nota" id="no_notaEdit" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="datetimepicker4">Tanggal Pembayaran</label>
                        <div class="input-group date" id="datetimepicker41" data-target-input="nearest">
                            <input type="text" name="tanggal_pembayaran" id="tanggal_pembayaranEdit" class="form-control datetimepicker-input" data-target="#datetimepicker41" />
                            <div class="input-group-append" data-target="#datetimepicker41" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea name="keterangan" id="keteranganEdit" cols="30" rows="5" class="form-control"></textarea>
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
            ajax: "{{route('bebanBayarData')}}",
            columns: [{
                data: 'DT_RowIndex',
                name: 'id'
            }, {
                data: 'no_nota',
                name: 'no_nota'
            }, {
                data: 'jenis_beban',
                name: 'jenis_beban'
            }, {
                data: 'harga',
                name: 'harga'
            }, {
                data: 'tanggal_pembayaran',
                name: 'tanggal_pembayaran'
            }, {
                data: 'aksi',
                name: 'aksi'
            }]
        });

        // tanggal_pembayaran
        $('.date').datetimepicker({
            format: 'L',
            locale: 'id',
            defaultDate: new Date(),
        });

        tanggal = $('.datetimepicker-input').val();

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

            // tanggal_pembayaran
            $('.datetimepicker-input').val(tanggal);
        });

        // input form per row
        let inputFormChange = function() {
            $('.modal').on('change', function(e) {

                if (e.target.classList.contains('formTransaksiSelect')) {
                    $('#harga, #hargaEdit').autoNumeric('init', {
                        mDec: '0'
                    });
                    let harga = $(e.target).find(':selected').attr('data-harga');
                    $('#harga, #hargaEdit').autoNumeric('set', harga);
                }
            });
        }

        inputFormChange();

        //post modal
        $('#buttonSimpan').click(function(e) {
            e.preventDefault();
            let form = $('#formTambah');
            let data = form.serialize();
            form.find('.help-block').remove();
            form.find('.is-invalid').removeClass('is-invalid');

            $.ajax({
                url: "{{route('bebanBayarStore')}}",
                method: 'post',
                data: data,
                success: function(res) {
                    form.trigger('reset');
                    $('#modalTambah').modal('hide');
                    $('#dataTable').DataTable().ajax.reload();
                    Swal.fire('Sukses!', 'Pembayaran berhasil ditambahkan', 'success');
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
            let dataBebanUsahaId = button.data('beban_usaha_id');
            let harga = button.data('harga');
            let noNota = button.data('no_nota');
            let tanggalPembayaran = button.data('tanggal_pembayaran');
            let keterangan = button.data('keterangan');
            let modal = $(this);
            modal.find('.modal-body #idEdit').val(id);
            modal.find('.modal-body #hargaEdit').val(harga);
            modal.find('.modal-body #no_notaEdit').val(noNota);
            modal.find('.modal-body #tanggal_pembayaranEdit').val(tanggalPembayaran);
            modal.find('.modal-body #keteranganEdit').val(keterangan);
            modal.find('.modal-body #idSelectEdit option').each((i, data) => {
                if (data.value == dataBebanUsahaId) {
                    $(data).attr('selected', 'selected');
                }
            });
            //select2
            $('.formTransaksiSelect').select2({
                placeholder: 'Pilih jenis barang',
                allowClear: true,
            });

            inputFormChange();
        });

        // update data ajax
        $('#buttonUpdate').click(function(e) {
            e.preventDefault();
            let form = $('#formEdit');
            let data = form.serialize();

            $.ajax({
                url: "{{route('bebanBayarUpdate')}}",
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

        //delete data ajax
        $('#dataTable').on('click', '#buttonDelete', function(e) {
            e.preventDefault();

            let url = $(this).attr('href');
            let jenisBeban = $(this).attr("data-jenis_beban");
            let tanggalPembayaran = $(this).attr("data-tanggal_pembayaran");

            Swal.fire({
                    title: 'Yakin akan menghapus data?',
                    text: `${jenisBeban} pembayaran tanggal ${tanggalPembayaran}`,
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
    })
</script>
@endsection