<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  @if(session()->has("kode_peminjaman") && session()->has("kode_member")) 
    <meta name="kode_peminjaman" content="{{ session('kode_peminjaman') }}">
    <meta name="kode_member" content="{{ session('kode_member') }}">
  @endif

  <title>Aplikasi Perpustakaan KP 1</title>

  <link rel="icon" type="image/x-icon" href="img/apalah.png">

  <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/dashboard/">

  <!-- Include Bootstrap CSS from jsDelivr CDN -->
  <link href="{{ asset('css/bs/bootstrap.css') }}" rel="stylesheet">

  {{-- Bootstrap Icon CDN --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <!-- Custom styles for this template -->
  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
  <link rel="stylesheet" href="{{ asset("css/style.css") }}">

  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }
  </style>
</head>
<body>
  @include('utils.header')
  @include('utils.navbar')

  <div class="container-fluid pb-5">
    <div class="row">
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
          @yield('container')
        
      </main>
    </div>
  </div>
  <script src="https://unpkg.com/feather-icons"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
  <script src="{{ asset("js/bs/bootstrap.js") }}"></script>

  <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
 
  @if(Request::is('home'))
  <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>
  <script src="{{ asset('js/dashboard.js') }}"></script>
  @endif

  <div class="card confirm-delete-card" style="width: 18rem;position:fixed;top:50%;left:50%;transform: translate(-50%, -50%)">
    <div class="card-body text-center py-3 px-4">
      <h5 class="card-title confirm-delete-card-text p-1 mt-2">Apakah Anda Yakin Ingin Menghapus</h5><h5 class="itemForDelete"></h5>
      <button onclick="cancelDelete()" class="cancel-button btn btn-warning mb-1 mt-2 me-1">Tidak</button>
      <button onclick="confirmDelete()" class="yes-button btn btn-danger mb-1 mt-2 ms-1">Ya</button>
    </div>
  </div>

  <script src="{{ asset('js/script.js') }}"></script>
  <script>
    feather.replace();

  </script>
</body>
</html>
