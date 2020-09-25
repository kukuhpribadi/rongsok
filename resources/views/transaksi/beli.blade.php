@extends('layout.master')
@section('title', 'Beli')
@section('content')

<div class="row">

    <!-- Area Chart -->
    <div class="col">
      <div class="card shadow mb-4">
        {{-- header --}}
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Beli barang</h6>
        </div>
        {{-- body --}}
        <div class="card-body">
          <div class="row">
            <div class="col">
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th style="width: 20%">Jenis barang</th>
                    <th>Harga</th>
                    <th>Qty</th>
                    <th style="width: 30%">Keterangan</th>
                    <th>Aksi</th>
                    <th>Jumlah</th>
                  </tr>
                </thead>
                <tbody>
                  <tr class="rowTransaksi" id="rowTr">
                    <td>
                      <select class="form-control formTransaksiSelect" id="exampleFormControlSelect1">
                        <option>1</option>
                      </select>
                    </td>
                    <td>
                      <input type="text" class="form-control" name="harga" id="harga">
                    </td>
                    <td>
                      <input type="number" class="form-control" name="qty" id="qty">
                    </td>
                    <td>
                      <input type="text" class="form-control" name="keterangan" id="keterangan">
                    </td>
                    <td>
                      <button class="btn btn-sm btn-icon btn-danger" id="buttonDelete"><i class="far fa-trash-alt" id="iconSampah"></i></button>
                    </td>
                    <td>
                      <input type="text" class="form-control" name="jumlah" id="jumlah">
                    </td>
                  </tr>
                  <tr class="rowAddBtn">
                    <td>
                        
                    </td>
                    <td></td>
                    <td></td>
                    <td><button class="btn btn-sm btn-primary btn-block" id="btnAddRow">Add row</button></td>
                    <td>Total</td>
                    <td>
                      <input type="text" class="form-control" name="total" id="total">
                    </td>
                  </tr>
                </tbody>
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
  // add row
  $('#btnAddRow').click(function(e){
    e.preventDefault();
    let rowBaru = `<tr class="rowTransaksi" id="rowTr">
                    <td>
                      <select class="form-control" id="exampleFormControlSelect1">
                        <option>1</option>
                      </select>
                    </td>
                    <td>
                      <input type="text" class="form-control" name="harga" id="harga">
                    </td>
                    <td>
                      <input type="number" class="form-control" name="qty" id="qty">
                    </td>
                    <td>
                      <input type="text" class="form-control" name="keterangan" id="keterangan">
                    </td>
                    <td>
                      <button class="btn btn-sm btn-icon btn-danger" id="buttonDelete"><i class="far fa-trash-alt" id="iconSampah"></i></button>
                    </td>
                    <td>
                      <input type="text" class="form-control" name="jumlah" id="jumlah">
                    </td>
                  </tr>`;
    $(rowBaru).insertBefore('.rowAddBtn');

  });

  $('table').click(function(e){
        if (e.target.id == 'buttonDelete' || e.target.id == 'iconSampah') {
            $(e.target).closest('tr').remove();
        }
    });

});
</script>
@endsection