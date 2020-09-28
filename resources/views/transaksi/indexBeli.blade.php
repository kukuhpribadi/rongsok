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
@endsection

@section('script')
<script>
$(document).ready(function(){
  // datatable
  $('#dataTable').DataTable({
    responsive: true,
    serverSide: false,
    ajax: '{{route('dataTransaksiBeli')}}',
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

  //delete data ajax
  $('#dataTable').on('click', '#buttonDelete',function(e) {
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