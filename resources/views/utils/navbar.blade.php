<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky d-flex flex-column vh-100 pt-5 pt-lg-3 mt-2 mt-lg-0">
      <ul class="nav flex-column">
        <li class="nav-item">
          <a class="nav-link {{ Request::is('home') ? 'active' : '' }}" aria-current="page" href="/home">
            <span data-feather="home"></span>
            Dashboard
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ Request::is('kelola-data-member*') ? 'active' : '' }}" aria-current="page" href="/kelola-data-member">
            <span data-feather="users"></span>
            Kelola Data Member
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ Request::is('/kelola-data-buku*') ? 'active' : '' }}" aria-current="page" href="/kelola-data-buku">
            <span data-feather="book"></span>
            Kelola Data Buku
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}" aria-current="page" href="#">
            <span data-feather="tag"></span>
            Kelola Data Kategori
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}" aria-current="page" href="#">
            <span data-feather="user-check"></span>
            Kelola Data Pustakawan
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}" aria-current="page" href="#">
            <span data-feather="arrow-down-circle"></span>
            Transaksi Peminjaman Buku
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}" aria-current="page" href="#">
            <span data-feather="arrow-up-circle"></span>
            Transaksi Pengembalian Buku
          </a>
        </li>
      </ul>
      <div class="mt-auto mb-5 row">
        <div class="col-11 ms-auto">
            <a href="/logout" class="btn btn-danger m-2 p-2 w-75">Logout</a>
        </div>
      </div>
    </div>
  </nav>
