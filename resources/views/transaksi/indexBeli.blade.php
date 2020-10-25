@extends('layout.master')
@section('title', 'Daftar Beli')
@section('content')

<div class="row">

  <!-- Area Chart -->
  <div class="col">
    <div class="card shadow mb-4">
      {{-- header --}}
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Beli</h6>
      </div>
      {{-- body --}}
      <div class="card-body">
        <div class="row">
          <div class="col">
            <table class="table table-bordered table-striped" id="dataTable">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>ID Transaksi</th>
                  <th>Jenis Barang</th>
                  <th>Harga</th>
                  <th>Qty</th>
                  <th>Total</th>
                  <th>Tanggal</th>
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
        <form action="{{route('transaksiBeliUpdate')}}" method="post" id="formEdit">
          @csrf
          <input type="hidden" name="id" id="idEdit">
          <div class="form-group">
            <label for="datetimepicker4">Pilih Tanggal</label>
            <div class="input-group date" id="datetimepicker4" data-target-input="nearest">
              <input type="text" name="tanggal_input" id="tanggal_inputEdit" class="form-control datetimepicker-input" data-target="#datetimepicker4" />
              <div class="input-group-append" data-target="#datetimepicker4" data-toggle="datetimepicker">
                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label>ID Transaksi</label>
            <input type="text" class="form-control" name="transaksi_beli_id" id="transaksiIdEdit" autocomplete="off" readonly>
          </div>
          <div class="form-group">
            <label>Jenis barang</label>
            <select class="form-control select2 formTransaksiSelect" id="idSelect" name="nama">
              @foreach ($barang as $item)
              <option value="{{$item->id}}" data-harga="{{$item->harga}}">{{$item->nama}}</option>
              @endforeach
            </select>
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
            <label>Qty</label>
            <input type="text" class="form-control" name="qty" id="qtyEdit" autocomplete="off">
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
      ajax: "{{route('dataTransaksiBeli')}}",
      columns: [{
        data: 'DT_RowIndex',
        name: 'id'
      }, {
        data: 'transaksi_beli_id',
        name: 'transaksi_beli_id'
      }, {
        data: 'jenis_barang',
        name: 'jenis_barang'
      }, {
        data: 'harga',
        name: 'harga'
      }, {
        data: 'qty',
        name: 'qty'
      }, {
        data: 'total',
        name: 'total'
      }, {
        data: 'tanggal',
        name: 'tanggal'
      }, {
        data: 'aksi',
        name: 'aksi'
      }]
    });

    $('#datetimepicker4').datetimepicker({
      format: 'L',
      locale: 'id',
      defaultDate: new Date(),
    });

    // reset form saat modal close
    $('.modal').on('hidden.bs.modal', function() {
      $(this).find('form')[0].reset();
      $(this).find('option:selected').removeAttr('selected');
    });

    // autoNumeric pada form harga
    $('#harga, #hargaEdit').autoNumeric('init', {
      mDec: '0'
    });

    $('.modal').on('change', function(e) {
      if (e.target.classList.contains('formTransaksiSelect')) {
        $('#hargaEdit').autoNumeric('init', {
          mDec: '0'
        });
        let harga = $(e.target).find(':selected').attr('data-harga');
        $('#hargaEdit').autoNumeric('set', harga);
      }
    });

    // edit data transaksi
    $('#modalEdit').on('show.bs.modal', function(event) {
      let button = $(event.relatedTarget);
      let id = button.data('id');
      let tanggalInput = button.data('tanggal_input');
      let transaksiId = button.data('transaksi_beli_id');
      let barang_id = button.data('barang_id');
      let harga = button.data('harga');
      let qty = button.data('qty');
      let keterangan = button.data('keterangan');
      let modal = $(this);
      modal.find('.modal-body #idEdit').val(id);
      modal.find('.modal-body #tanggal_inputEdit').val(tanggalInput);
      modal.find('.modal-body #transaksiIdEdit').val(transaksiId);
      modal.find('.modal-body #hargaEdit').val(harga);
      modal.find('.modal-body #qtyEdit').val(qty);
      modal.find('.modal-body #keteranganEdit').val(keterangan);
      modal.find('.modal-body #idSelect option').each((i, data) => {
        if (data.value == barang_id) {
          $(data).attr('selected', 'selected');
        }
      });

      //select2
      $('.formTransaksiSelect').select2({
        placeholder: 'Pilih jenis barang',
        allowClear: true,
      });


    });

    // update data ajax
    $('#buttonUpdate').click(function(e) {
      e.preventDefault();
      let form = $('#formEdit');
      let data = form.serialize();

      $.ajax({
        url: "{{route('transaksiBeliUpdate')}}",
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
      let nama = $(this).attr("data-nama");
      let idTransaksi = $(this).attr("data-idTransaksi");

      Swal.fire({
          title: 'Yakin akan menghapus data?',
          text: `${idTransaksi} | ${nama}`,
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