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
                      <select class="form-control select2 formTransaksiSelect" id="idSelect" name="nama[]" >
                        <option value=""></option>
                        @foreach ($barang as $item)
                        <option data-id="{{$item->id}}" data-harga="{{$item->harga}}" data-nama="{{$item->nama}}" value="{{$item->id}}">{{$item->nama}}</option>
                        @endforeach 
                      </select>
                    </td>
                    <td>
                      <input type="text" class="form-control" name="harga[]" id="harga" data-a-dec="," data-a-sep=".">
                    </td>
                    <td>
                      <input type="number" class="form-control" name="qty[]" id="qty">
                    </td>
                    <td>
                      <input type="text" class="form-control" name="keterangan[]" id="keterangan">
                    </td>
                    <td>
                      <button class="btn btn-sm btn-icon btn-danger" id="buttonDelete"><i class="far fa-trash-alt" id="iconSampah"></i></button>
                    </td>
                    <td>
                      <input type="text" class="form-control" name="jumlah[]" id="jumlah" data-a-dec="," data-a-sep=".">
                    </td>
                  </tr>
                  <tr class="rowAddBtn">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><button class="btn btn-sm btn-primary btn-block" id="btnAddRow">Add row</button></td>
                    <td>Total</td>
                    <td>
                      <input type="text" class="form-control" name="total" id="total" data-a-dec="," data-a-sep=".">
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
  //select2
  $('.formTransaksiSelect').select2({
        placeholder: 'Pilih jenis barang',
        allowClear: true,
    });

  // add row
  let idForSelect = 0;
  $('#btnAddRow').click(function(e){
    e.preventDefault();

    let row = $('#rowTr');
    row.find(".formTransaksiSelect").each(function(index)
    {
        $(this).select2('destroy');
    }); 
    let rowBaru = row.clone();
    rowBaru.find('input').val('');

    $(rowBaru).insertBefore('.rowAddBtn');

    $('.formTransaksiSelect').last().attr('id', `idSelect${idForSelect}`);
    $('.formTransaksiSelect').last().attr('data-select2-id', `idSelect${idForSelect}`);
    idForSelect++;
    $('.formTransaksiSelect').select2({
        placeholder: 'Pilih jenis barang',
        allowClear: true,
    });
    let removeFail = $('.formTransaksiSelect').last().next().next().remove();
  });

  // input form per row
  $('table').on('change keyup', function(e){
        let total = 0;
        $('.rowTransaksi').map((idx, v) => {
            $('#harga, #jumlah').autoNumeric('init', {mDec: '0'});
            let harga = $(v).find(':selected').attr('data-harga');
            if(harga == undefined){
                harga = null;
            };
            let formHarga = $(v).find('#harga').autoNumeric('set', harga);
            let qty = $(v).find('#qty').val();
            if (qty <= 0) {
                qty = 1;
                $(v).find('#qty').val(1);
            } 
            if (harga == undefined) {
                $(v).find('#qty').val('');
            }
            let jumlah = $(v).find('#jumlah').autoNumeric('set', harga * qty);
            jumlah = jumlah.val().split('.').join('')
            jumlah = parseInt(jumlah);
            if (harga == undefined) {
                $(v).find('#jumlah').val('');
            }
            total += jumlah;
            
        });
        $('#total').autoNumeric('init', {mDec: '0'});
        $('#total').autoNumeric('set', total)
    });

  //delete row
  $('table').click(function(e){
      if (e.target.id == 'buttonDelete' || e.target.id == 'iconSampah') {
          $(e.target).closest('tr').remove();
      }
  });

  

});
</script>
@endsection