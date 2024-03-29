@extends('layout.master')
@section('title', 'Dashboard')
@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
  <div class="dropdown no-arrow">
    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      {{$namaButton}}
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
      <a class="dropdown-item" href="{{route('getDataBulanIni')}}">Bulan</a>
      <a class="dropdown-item" href="{{route('getDataTahunIni')}}">Tahun</a>
    </div>
  </div>
</div>

<!-- Content Row -->
<div class="row">

  <!-- Earnings (Monthly) Card Example -->
  <div class="col-xl col-md-6 mb-4">
    <div class="card border-left-danger shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Pengeluaran</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. {{$pengeluaran}}</div>
          </div>
          <div class="col-auto">
            <i class="fas fa-calendar fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Earnings (Monthly) Card Example -->
  <div class="col-xl col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Pendapatan</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. {{$pendapatan}}</div>
          </div>
          <div class="col-auto">
            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Earnings (Monthly) Card Example -->
  <div class="col-xl col-md-6 mb-4">
    <div class="card border-left-info shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Keuntungan</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. {{number_format(str_replace('.', '', $pendapatan) - str_replace('.', '', $pengeluaran), 0, ',', '.')}}</div>
            <div class="row no-gutters align-items-center">
              <div class="col-auto">
                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"></div>
              </div>
            </div>
          </div>
          <div class="col-auto">
            <i class="fas fa-wallet fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>



<!-- Content Row -->
<div class="row">
  <div class="col-8">
    <div class="card shadow mb-4">
      <!-- Card Header - Dropdown -->
      <div class="card-header">
        <h6 class="m-0 font-weight-bold text-primary">{{request()->routeIs('getDataTahunIni') ? 'Data transaksi tahun ini' : 'Data transaksi bulan ini'}}</h6>
      </div>
      <!-- Card Body -->
      <div class="card-body">
        <div class="chart-area" style="position: relative; height:60vh;">
          <canvas id="myChart"></canvas>
        </div>
      </div>
    </div>
  </div>

  <div class="col">
    <div class="card shadow mb-4">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Pembelian barang</h6>
      </div>
      <div class="card-body">
        <table class="table table-bordered table-striped" id="dataTable">
          <thead>
            <tr>
              <th>No</th>
              <th>Jenis barang</th>
              <th>Qty</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($jmlTransaksiBeli as $item)
            <tr>
              <td>{{$loop->iteration}}</td>
              <td>{{$item->barang->nama}}</td>
              @if(request()->routeIs('getDataTahunIni'))
              <td>{{$item->where('barang_id', $item->barang_id)->whereYear('tanggal_input', Carbon\Carbon::now()->year)->sum('qty')}}</td>
              @else
              <td>{{$item->where('barang_id', $item->barang_id)->whereYear('tanggal_input', Carbon\Carbon::now()->year)->whereMonth('tanggal_input', Carbon\Carbon::now()->month)->sum('qty')}}</td>
              @endif
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

@endsection

@section('script')
<script>
  function number_format(number, decimals, dec_point, thousands_sep) {
    // *     example: number_format(1234.56, 2, ',', ' ');
    // *     return: '1 234,56'
    number = (number + '').replace(',', '').replace(' ', '');
    var n = !isFinite(+number) ? 0 : +number,
      prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
      sep = (typeof thousands_sep === 'undefined') ? '.' : thousands_sep,
      dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
      s = '',
      toFixedFix = function(n, prec) {
        var k = Math.pow(10, prec);
        return '' + Math.round(n * k) / k;
      };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
      s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
      s[1] = s[1] || '';
      s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
  }
  var statistics_chart = document.getElementById("myChart").getContext('2d');
  var myChart = new Chart(statistics_chart, {
    type: 'line',
    data: {
      labels: <?= request()->routeIs('getDataTahunIni') ? json_encode($jmlBulan) : json_encode($jmlHari) ?>,
      datasets: [{
        label: 'Pengeluaran',
        data: <?= request()->routeIs('getDataTahunIni') ? json_encode($jmlTransaksiBeliPerBulan) : json_encode($jmlTransaksiBeliPerHari) ?>,
        lineTension: 0.3,
        backgroundColor: "rgba(224, 110, 99, 0.2)",
        borderColor: "rgba(224, 110, 99, 1)",
        pointRadius: 3,
        pointBackgroundColor: "rgba(224, 110, 99, 1)",
        pointBorderColor: "rgba(224, 110, 99, 1)",
        pointHoverRadius: 3,
        pointHoverBackgroundColor: "rgba(224, 110, 99, 1)",
        pointHoverBorderColor: "rgba(224, 110, 99, 1)",
        pointHitRadius: 10,
        pointBorderWidth: 2,
      }, {
        label: 'Pendapatan',
        data: <?= request()->routeIs('getDataTahunIni') ? json_encode($jmlTransaksiJualPerBulan) : json_encode($jmlTransaksiJualPerHari) ?>,
        lineTension: 0.3,
        backgroundColor: "rgba(28, 200, 138, 0.2)",
        borderColor: "rgba(28, 200, 138, 1)",
        pointRadius: 3,
        pointBackgroundColor: "rgba(28, 200, 138, 1)",
        pointBorderColor: "rgba(28, 200, 138, 1)",
        pointHoverRadius: 3,
        pointHoverBackgroundColor: "rgba(28, 200, 138, 1)",
        pointHoverBorderColor: "rgba(28, 200, 138, 1)",
        pointHitRadius: 10,
        pointBorderWidth: 2,
      }]
    },
    options: {
      tooltips: {
        backgroundColor: "rgb(255,255,255)",
        bodyFontColor: "#858796",
        titleMarginBottom: 10,
        titleFontColor: '#6e707e',
        titleFontSize: 14,
        borderColor: '#dddfeb',
        borderWidth: 1,
        xPadding: 15,
        yPadding: 15,
        displayColors: false,
        intersect: false,
        mode: 'index',
        caretPadding: 10,
        callbacks: {
          title: function() {},
          label: function(tooltipItem, chart) {
            var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
            return `${datasetLabel} Rp. ${number_format(tooltipItem.yLabel)}`;
          }
        }
      },
      legend: {
        display: false
      },
      scales: {
        yAxes: [{
          scaleLabel: {
            display: true,
            labelString: '<?= request()->routeIs('getDataTahunIni') ? 'Transaksi Per Bulan' : 'Transaksi Per Hari' ?>'
          },
          gridLines: {
            display: false,
            drawBorder: false,
          },
          ticks: {
            callback: function(value, index, values) {
              return 'Rp. ' + number_format(value);
            }
          }
        }],
        xAxes: [{
          scaleLabel: {
            display: true,
            labelString: '<?= request()->routeIs('getDataTahunIni') ? 'Bulan' : 'Tanggal' ?>'
          },
          gridLines: {
            color: '#fbfbfb',
            lineWidth: 2,
          }
        }]
      },
      responsive: true,
      maintainAspectRatio: false,
    }
  });
</script>

<script>
  $(document).ready(function() {
    $('#dataTable').DataTable({
      "dom": '<ftpr',
      "pageLength": 5,
    });
  })
</script>
@endsection