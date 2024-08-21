@extends('layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h2>Tambah Data Member</h2>
    </div>  
    <div class="row">
        <div class="col-md-8">
            <form action="/kelola-data-member" method="post">
                @method("post")
                @csrf
                <div class="mb-3">
                    <label for="kode" class="form-label">Kode Member</label>
                    <input type="text" class="form-control @error('kode_member') is-invalid @enderror" value="{{ $kodeMember }}" name="kode_member" id="kode" placeholder="Masukan kode member">
                    @error('kode_member')
                    <div class="invalid-message">
                      {{ $message }}
                    </div>
                    @enderror
                  </div>
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" name="nama_lengkap" id="kode" placeholder="Masukan nama member" required>
                    @error('nama_lengkap')
                    <div class="invalid-message">
                      {{ $message }}
                    </div>
                    @enderror
                  </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea class="form-control @error('alamat') is-invalid @enderror" name="alamat" id="alamat" placeholder="Masukan alamat member" required></textarea>
                    @error('alamat')
                    <div class="invalid-message">
                      {{ $message }}
                    </div>
                    @enderror
                  </div>
                <div class="mb-3">
                    <label for="telp" class="form-label">No Telp</label>
                    <input type="number" class="form-control @error('no_telp') is-invalid @enderror" name="no_telp" id="telp" placeholder="Masukan no. Telp member" required>
                    @error('no_telp')
                    <div class="invalid-message">
                      {{ $message }}
                    </div>
                    @enderror
                  </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="Masukan email member" required>
                    @error('email')
                    <div class="invalid-message">
                      {{ $message }}
                    </div>
                    @enderror
                  </div>
                  
                  <button class="btn btn-primary shadow" type="submit">Tambah</button>
            </form>
        </div>
    </div>
@endsection