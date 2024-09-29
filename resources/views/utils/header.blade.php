<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6 fw-bold" href="/dashboard">APLIKASI PERPUSTAKAAN</a>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="d-flex justify-content-between me-5">
      <h5 class="text-white ms-3 my-2 akun position-relative">
          <i class="bi bi-person mr-2"></i>{{ Auth::user()->nama_lengkap }}
          <!-- Card muncul saat hover -->
          <div class="profile-card shadow p-3 mb-5 bg-white rounded" id="profile-card">
              <img src="{{ Auth::user()->pp ? asset('storage/' . Auth::user()->gambar) : asset('img/apalah.png') }}" alt="Profile Picture" class="img-thumbnail rounded-circle ml-4" width="200" height="200">
              <h6 class="mt-2">{{ Auth::user()->nama_lengkap }}</h6>
              <a href="/profile/settings" class="btn btn-sm btn-outline-primary">Pengaturan</a>
          </div>
      </h5>
  </div>
</header>
