<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Katalog Perpustakaan KP 1</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

  <link rel="stylesheet" href="{{ asset("css/rating.css") }}">

  <link rel="icon" type="image/x-icon" href="{{ asset('img/logoperpus.png') }}">

  <!-- Include Bootstrap CSS from jsDelivr CDN -->
  <link href="{{ asset('css/bs/bootstrap.css') }}" rel="stylesheet">

  {{-- Bootstrap Icon CDN --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <!-- Custom styles for this template -->
  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">

  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }

    /* Ensure the image scales well in small devices */
    .img-fluid {
      max-width: 100%;
      height: auto;
    }

    /* Style adjustments for delete confirmation card */
    .confirm-delete-card {
      display: none; /* Hidden by default */
      width: 18rem;
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      z-index: 1050;
    }
  </style>
</head>
<body>
  <script src="{{ asset("js/jquery-3.7.1.min.js") }}"></script>
  {{-- Include the header for catalog --}}
  @include('utils.headerkatalog')

  {{-- Main content area --}}
  <div class="container pb-5 mt-4">
    <div class="row">
      <main class="col-md-12 col-lg-12 px-md-4">
          @yield('container')
      </main>
    </div>
  </div>

  @include('utils.footer')


  {{-- Include necessary JS libraries --}}
  <script src="https://unpkg.com/feather-icons"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
  <script src="{{ asset('js/bs/bootstrap.js') }}"></script>

  <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" crossorigin="anonymous"></script>

  {{-- Conditionally include Chart.js if on 'home' page --}}
  @if(Request::is('home'))
  <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" crossorigin="anonymous"></script>
  <script src="{{ asset('js/dashboard.js') }}"></script>
  @endif

  {{-- Delete confirmation modal --}}
  <div class="card confirm-delete-card">
    <div class="card-body text-center py-3 px-4">
      <h5 class="card-title confirm-delete-card-text p-1 mt-2">Apakah Anda Yakin Ingin Menghapus</h5>
      <h5 class="itemForDelete"></h5>
      <button onclick="cancelDelete()" class="cancel-button btn btn-warning mb-1 mt-2 me-1">Tidak</button>
      <button onclick="confirmDelete()" class="yes-button btn btn-danger mb-1 mt-2 ms-1">Ya</button>
    </div>
  </div>

  {{-- Include custom JS --}}
  <script src="{{ asset('js/script.js') }}"></script>
  <script src="{{ asset('js/katalog.js') }}"></script>

  {{-- Initialize Feather Icons --}}
  <script>
    feather.replace();
  </script>

  {{-- Script to manage delete confirmation modal visibility --}}
  <script>
    function showDeleteModal(item) {
      $('.itemForDelete').text(item);
      $('.confirm-delete-card').show();
    }

    function cancelDelete() {
      $('.confirm-delete-card').hide();
    }

    function confirmDelete() {
      // Your delete logic here
      cancelDelete();
    }
  </script>
</body>
</html>
