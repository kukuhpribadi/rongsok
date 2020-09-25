@extends('layout.master')
@section('title', 'Barang')
@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Barang</h1>
</div>

<div class="row">
    <!-- Area Chart -->
    <div class="col">
      <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <button class="btn btn-primary btn-sm" id="modal-2" data-toggle="modal" data-target="#modalTambah"><i class="far fa-plus-square"></i> Tambah jenis barang</button>
        </div>
        <!-- Card Body -->
        <div class="card-body">
          <table class="table table-bordered table-striped" id="dataTable">
            <thead>
              <tr>
                  <th>No</th>
                  <th>Jenis barang</th>
                  <th>Harga</th>
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
        <h5 class="modal-title">Tambah Jenis Barang</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{route('barangStore')}}" method="post" id="formTambah">
          @csrf
          <div class="form-group">
            <label>Jenis barang</label>
            <input type="text" class="form-control" name="nama" id="nama" autocomplete="off">
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
        <h5 class="modal-title">Edit Jenis Barang</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="#" method="post" id="formEdit">
          @csrf
          <input type="hidden" name="id" id="idEdit">
          <div class="form-group">
            <label>Jenis barang</label>
            <input type="text" class="form-control" name="nama" id="namaEdit" autocomplete="off">
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
$(document).ready(function(){
  // datatable
  $('#dataTable').DataTable({
    responsive: true,
    serverSide: false,
    ajax: '{{route('dataBarang')}}',
    columns: [{
            data: 'DT_RowIndex', 
            name: 'id'
        }, {
            data: 'nama', 
            name: 'nama'
        }, {
            data: 'harga', 
            name: 'harga'
        }, {
            data: 'aksi', 
            name: 'aksi'
        }]
  });

  // reset form saat modal close
  $('.modal').on('hidden.bs.modal', function(){
      $(this).find('form')[0].reset();
  });

  // autoNumeric pada form harga
  $('#harga, #hargaEdit').autoNumeric('init', {mDec: '0'});

  // edit modal
  $('#modalEdit').on('show.bs.modal', function(event) {
      let button = $(event.relatedTarget)
      let id = button.data('id');
      let nama = button.data('nama');
      let harga = button.data('harga');
      let modal = $(this);
      modal.find('.modal-body #idEdit').val(id);
      modal.find('.modal-body #namaEdit').val(nama);
      modal.find('.modal-body #hargaEdit').val(harga);
  });

  // update data ajax
  $('#buttonUpdate').click(function(e) {
    e.preventDefault();
    let form = $('#formEdit');
    let data = form.serialize();
    
    $.ajax({
        url: "{{route('barangUpdate')}}",
        method: 'post',
        data: data,
        success: function(res) {
            form.trigger('reset');
            $('#modalEdit').modal('hide');
            $('#dataTable').DataTable().ajax.reload();
            Swal.fire('Sukses!','Data barang berhasil diubah','success');
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
  $('#dataTable').on('click', '#buttonDelete',function(e) {
    e.preventDefault();

    let url = $(this).attr('href');
    let nama = $(this).attr("data-nama");

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
              method: "GET", 
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