<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>Registrasi</title>
  </head>
  <body class="d-flex justify-content-center align-items-center" style="height: 120vh">

    <div class="container">
        <div class="row justify-content-center">
            @if(session()->has("RegisterError"))
            <div class="col-md-8">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session("RegisterError") }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
            @endif
            
            <div class="col-lg-6 col-md-8">
                <div class="card shadow-lg px-2 py-3">
                    <div class="card-header bg-white border-0 text-center">
                        <h3 class="fw-bold fs-2">Registrasi</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="/katalog/register">
                            @csrf
                            <div class="mb-3">
                                <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control shadow-sm @error('nama_lengkap') is-invalid @enderror" id="nama_lengkap" name="nama_lengkap" placeholder="Masukkan Nama Anda">
                                @error('nama_lengkap')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <input type="text" class="form-control shadow-sm @error('alamat') is-invalid @enderror" id="alamat" name="alamat" placeholder="Masukkan Alamat Anda">
                                @error('alamat')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="telp" class="form-label">No Telp</label>
                                <input type="number" class="form-control shadow-sm @error('no_telp') is-invalid @enderror" name="no_telp" id="telp" placeholder="Masukkan Nomor Anda">
                                @error('no_telp')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control shadow-sm @error('email') is-invalid @enderror" id="email" name="email" placeholder="Masukkan Email Anda">
                                @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control shadow-sm @error('password') is-invalid @enderror" id="password" name="password" placeholder="Masukkan Password Anda">
                                @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                <input type="password" class="form-control shadow-sm @error('password') is-invalid @enderror" id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi Password Anda">
                                @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-success w-100 mt-3 shadow-sm">Registrasi</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
  </body>
</html>
