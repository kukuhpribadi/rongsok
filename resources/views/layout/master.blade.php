<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>@yield('title')</title>

  <!-- Custom fonts for this template-->
  <link href="{{asset('vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="{{asset('css/sb-admin-2.css')}}" rel="stylesheet">

  {{-- datatables --}}
  <link href="{{asset('vendor/datatables/dataTables.bootstrap4.css')}}" rel="stylesheet" type="text/css">

  {{-- sweetalert --}}
  <link rel="stylesheet" href="{{asset('vendor/sweetalert2-theme-bootstrap-4/bootstrap-4.css')}}">

  {{-- Select2 --}}
  <link rel="stylesheet" href="{{asset('vendor/select2/css/select2.css')}}">
  <link rel="stylesheet" href="{{asset('vendor/select2-bootstrap4-theme/select2-bootstrap4.css')}}">

  {{-- datepicker --}}
  <link rel="stylesheet" href="{{asset('vendor/tempusdominus/tempusdominus-bootstrap-4.min.css')}}">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    {{-- sidebar --}}
    @include('layout.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        {{-- sidebar --}}
        @include('layout.topbar')

        <!-- Begin Page Content -->
        <div class="container-fluid">
          @yield('content')
        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Your Website 2019</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="login.html">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
  <script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

  <!-- Core plugin JavaScript-->
  <script src="{{asset('vendor/jquery-easing/jquery.easing.min.js')}}"></script>

  <!-- Custom scripts for all pages-->
  <script src="{{asset('js/sb-admin-2.min.js')}}"></script>

  <!-- Page level plugins -->
  <script src="{{asset('vendor/chart.js/Chart.min.js')}}"></script>


  {{-- Datatable --}}
  <script src="{{asset('vendor/datatables/jquery.dataTables.js')}}"></script>
  <script src="{{asset('vendor/datatables/dataTables.bootstrap4.js')}}"></script>

  {{-- autonumeric --}}
  <script src="{{asset('vendor/autonumeric/autoNumeric.js')}}"></script>

  {{-- sweetalert --}}
  <script src="{{asset('vendor/sweetalert2/sweetalert2.js')}}"></script>

  <!-- select2 -->
  <script src="{{asset('vendor/select2/js/select2.js')}}"></script>

  {{-- datepicker --}}
  <script src="{{asset('vendor/moment/moment-with-locales.js')}}"></script>
  <script src="{{asset('vendor/tempusdominus/tempusdominus-bootstrap-4.min.js')}}"></script>

  {{-- chartjs --}}
  <script src="{{asset('vendor/chart.js/Chart.js')}}"></script>

  @if(Session::has('sukses'))
  <script>
    Swal.fire(
      'Sukses!',
      "{{ Session::get('sukses') }}",
      'success'
    );
  </script>
  @endif

  @if(Session::has('gagal'))
  <script>
    Swal.fire({
      icon: 'error',
      title: 'Gagal!',
      text: "{{ Session::get('gagal') }}",
    });
  </script>
  @endif

  @yield('script')

</body>

</html>