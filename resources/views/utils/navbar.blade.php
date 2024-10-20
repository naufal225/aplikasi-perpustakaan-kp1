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
        @can('admin')
        <li class="nav-item">
          <a class="nav-link {{ Request::is('konfirmasi-registrasi-member*') ? 'active' : '' }}" aria-current="page" href="/konfirmasi-registrasi-member">
            <span data-feather="users"></span>
            Konfirmasi Registrasi Member
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ Request::is('kelola-data-buku*') ? 'active' : '' }}" aria-current="page" href="/kelola-data-buku">
            <span data-feather="book"></span>
            Kelola Data Buku
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ Request::is('kelola-data-kategori*') ? 'active' : '' }}" aria-current="page" href="/kelola-data-kategori">
            <span data-feather="tag"></span>
            Kelola Data Kategori
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ Request::is('kelola-data-pustakawan*') ? 'active' : '' }}" aria-current="page" href="/kelola-data-pustakawan">
            <span data-feather="user-check"></span>
            Kelola Data Pustakawan
          </a>
        </li>
        @endcan
        <li class="nav-item">
          <a class="nav-link {{ Request::is('transaksi/pinjam-buku*') ? 'active' : '' }}" aria-current="page" href="/transaksi/pinjam-buku">
            <span data-feather="arrow-down-circle"></span>
            Transaksi Peminjaman Buku
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ Request::is('transaksi/kembali-buku*') ? 'active' : '' }}" aria-current="page" href="/transaksi/kembali-buku">
            <span data-feather="arrow-up-circle"></span>
            Transaksi Pengembalian Buku
          </a>
        </li>
      </ul>
      <div class="mt-auto mb-3 row">
        <div class="col-11 ms-auto mb-5">
            <a href="/logout" class="btn btn-dark m-2 p-2 w-75"><i class="bi bi-box-arrow-right pe-2"></i>Logout</a>
        </div>
      </div>
    </div>
  </nav>
