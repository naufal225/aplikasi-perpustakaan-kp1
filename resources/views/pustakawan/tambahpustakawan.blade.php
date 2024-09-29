@extends('layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h2>Tambah Data Pustakawan</h2>
</div>  
        <form action="/kelola-data-pustakawan" method="post">
            @method("post")
            @csrf
            <div class="row">
                <div class="col-md-5">
                    <div class="mb-3">
                        <label for="kode" class="form-label">Kode Pustakawan</label>
                        <input type="text" class="form-control @error('kode_petugas') is-invalid @enderror" value="{{ $kodePustakawan }}" name="kode_petugas" id="kode" placeholder="Masukan kode pustakawan" readonly>
                        @error('kode_petugas')
                        <div class="invalid-message">
                          {{ $message }}
                        </div>
                        @enderror
                      </div>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" name="nama_lengkap" id="kode" placeholder="Masukan nama pustakawan" required>
                        @error('nama_lengkap')
                        <div class="invalid-message">
                          {{ $message }}
                        </div>
                        @enderror
                      </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control @error('alamat') is-invalid @enderror" name="alamat" id="alamat" placeholder="Masukan alamat pustakawan" required></textarea>
                        @error('alamat')
                        <div class="invalid-message">
                          {{ $message }}
                        </div>
                        @enderror
                      </div>
                    <div class="mb-3">
                        <label for="telp" class="form-label">No Telp</label>
                        <input type="number" class="form-control @error('no_telp') is-invalid @enderror" name="no_telp" id="telp" placeholder="Masukan no. Telp pustakawan" required>
                        @error('no_telp')
                        <div class="invalid-message">
                          {{ $message }}
                        </div>
                        @enderror
                      </div>
                      
                    </div>
                    <div class="col-md-5">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="Masukan email pustakawan" required>
                        @error('email')
                        <div class="invalid-message">
                          {{ $message }}
                        </div>
                        @enderror
                      </div>
                      <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="Masukan password pustakawan" required>
                        @error('password')
                        <div class="invalid-message">
                          {{ $message }}
                        </div>
                        @enderror
                      </div>
                      <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password_confirmation" id="password_confirmation" placeholder="Masukan konfirmasi password" required>
                      </div>
                      <div class="mb-3">
                        <label for="gambar" class="form-label label-gambar">Foto Pustakawan</label>
                        <input value="{{ old("gambar") }}" class="form-control" type="file" name="gambar" id="gambar" onchange="previewGambar()">
                      </div>
                </div>
              </div>
              
              <button class="btn mt-4 btn-primary shadow" type="submit">Tambah</button>
              
            </form>
</div>
@endsection