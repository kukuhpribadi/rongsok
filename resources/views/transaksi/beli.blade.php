@extends('layout.master')
@section('title', 'Beli')
@section('content')
<div class="row">
  <div class="col">
    <div class="card shadow mb-4">
      {{-- header --}}
      <div class="card-header  py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Beli barang</h6>
        <h5 class="m-0 mr-3 font-weight-bold text-dark">{{$transaksiId}}</h5>
      </div>
      {{-- body --}}
      <div class="card-body">
        <div class="row">
          <div class="col">
            <form action="{{route('transaksiBeliStore')}}" method="post">
              @csrf
              <div class="row">
                <div class="form-group col-3">
                  <label for="datetimepicker4">Pilih Tanggal</label>
                  <div class="input-group date" id="datetimepicker4" data-target-input="nearest">
                    <input type="text" name="tanggal_input" class="form-control datetimepicker-input" data-target="#datetimepicker4" />
                    <div class="input-group-append" data-target="#datetimepicker4" data-toggle="datetimepicker">
                      <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                  </div>
                </div>
              </div>
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
                  <input type="hidden" name="transaksi_beli_id" value="{{$transaksiId}}">
                  <tr class="rowTransaksi" id="rowTr">
                    <td>
                      <select class="form-control select2 formTransaksiSelect" id="idSelect" name="nama[]">
                        <option value=""></option>
                        @foreach ($barang as $item)
                        <option data-id="{{$item->id}}" data-harga="{{$item->harga}}" data-nama="{{$item->nama}}" value="{{$item->id}}">{{$item->nama}}</option>
                        @endforeach
                      </select>
                    </td>
                    <td>
                      <input type="text" class="form-control" name="harga[]" id="harga" data-a-dec="," data-a-sep="." autocomplete="off">
                    </td>
                    <td>
                      <input type="text" class="form-control" name="qty[]" id="qty" autocomplete="off">
                    </td>
                    <td>
                      <input type="text" class="form-control" name="keterangan[]" id="keterangan" autocomplete="off">
                    </td>
                    <td>
                      <button class="btn btn-sm btn-icon btn-danger" id="buttonDelete"><i class="far fa-trash-alt" id="iconSampah"></i></button>
                    </td>
                    <td>
                      <input type="text" class="form-control" name="jumlah[]" id="jumlah" data-a-dec="," data-a-sep="." readonly>
                    </td>
                  </tr>
                  <tr class="rowAddBtn">
                    <td><button class="btn btn-sm btn-primary btn-block" id="btnAddRow">Add row</button></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Total</td>
                    <td>
                      <input type="text" class="form-control" name="total" id="total" data-a-dec="," data-a-sep="." autocomplete="off" readonly>
                    </td>
                  </tr>
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                      <button type="submit" class="btn btn-sm btn-success btn-block">Submit</button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('script')
<script>
  $(document).ready(function() {
    $('#datetimepicker4').datetimepicker({
      format: 'L',
      locale: 'id',
      defaultDate: new Date(),
    });

    // function add row
    const addRow = function() {
      let row = $('#rowTr');
      row.find(".formTransaksiSelect").each(function(index) {
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
    }

    // function loop row
    const loopRow = function() {
      let total = 0;
      $('.rowTransaksi').map((idx, v) => {
        $('#harga, #jumlah').autoNumeric('init', {
          mDec: '0'
        });
        let harga = $(v).find('#harga').val().split('.').join('');
        let qty = $(v).find('#qty').val();
        let jumlah = $(v).find('#jumlah').autoNumeric('set', harga * qty);
        jumlah = jumlah.val().split('.').join('');
        jumlah = parseInt(jumlah);
        total += jumlah;
      });
      $('#total').autoNumeric('init', {
        mDec: '0'
      });
      $('#total').autoNumeric('set', total);
    }

    //select2
    $('.formTransaksiSelect').select2({
      placeholder: 'Pilih jenis barang',
      allowClear: true,
    });

    // add row
    let idForSelect = 0;
    $('#btnAddRow').click(function(e) {
      e.preventDefault();
      addRow();
    });

    // shortcut keyboard
    // $(window).keypress(function(event) {
    //   if (event.code == 'NumpadEnter') {
    //     $('form').submit();
    //   } else if (event.code == 'NumpadAdd') {
    //     addRow();
    //   } else if (event.code == 'NumpadSubtract') {
    //     if ($('.rowTransaksi').length > 1) {
    //       $('.rowTransaksi').last().remove();
    //     } else if ($('.rowTransaksi').length == 1) {
    //       addRow();
    //       $('.rowTransaksi').first().remove();
    //     }

    //     loopRow();
    //   }
    // });

    // input form per row
    $('table').on('change keyup', function(e) {

      if (e.target.classList.contains('formTransaksiSelect')) {
        $('#harga, #jumlah').autoNumeric('init', {
          mDec: '0'
        });
        let harga = $(e.target).find(':selected').attr('data-harga');
        $(e.target).closest('tr').find('#harga').autoNumeric('set', harga);
        $(e.target).closest('tr').find('#qty').val(1);
        loopRow();
      } else if (e.target.id == 'qty' || e.target.id == 'harga') {
        loopRow();
      }
    });

    //delete row
    $('table').click(function(e) {
      if (e.target.id == 'buttonDelete' || e.target.id == 'iconSampah') {
        if ($('.rowTransaksi').length > 1) {
          $(e.target).closest('tr').remove();
        } else if ($('.rowTransaksi').length == 1) {
          addRow();
          $(e.target).closest('tr').remove();
        }

        loopRow();
      }
    });

  });
</script>
@endsection