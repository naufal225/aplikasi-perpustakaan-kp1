<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky d-flex flex-column vh-100 pt-3">
      <ul class="nav flex-column">
        <li class="nav-item">
          <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" aria-current="page" href="#">
            <span data-feather="home"></span>
            Dashboard
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}" aria-current="page" href="#">
            <span data-feather="users"></span>
            Kelola Data Member
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}" aria-current="page" href="#">
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
        <div class="col-md-11">
            <a href="/logout" class="btn btn-danger m-2 p-2 w-100">Logout</a>
        </div>
      </div>
    </div>
  </nav>
