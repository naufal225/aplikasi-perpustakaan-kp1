<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid d-flex justify-content-between">
    <a class="navbar-brand" href="#">KATALOG PERPUSTAKAAN</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="pe-5" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link {{ Request::is('katalog') ? 'active' : '' }} mx-2" aria-current="page" href="/katalog">Katalog</a>
        </li>
        @auth('member')
        <li class="nav-item">
          <a class="nav-link {{ Request::is('katalog/riwayat') ? 'active' : '' }} mx-2" aria-current="page" href="/katalog/riwayat">Riwayat Registrasi</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active text-white bg-danger mx-2" aria-current="page" href="/katalog/logout">Logout</a>
        </li>
        @else
        <li class="nav-item">
          <a class="nav-link active text-white bg-success mx-2" aria-current="page" href="/katalog/login">Login</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active text-white bg-success mx-2" aria-current="page" href="/katalog/registrasi">Registrasi</a>
        </li>
        @endauth
      </ul>
    </div>
  </div>
</nav>