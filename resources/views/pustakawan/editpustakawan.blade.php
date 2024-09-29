@extends('layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h2>Edit Data Pustakawan</h2>
</div>  
        <form action="/kelola-data-pustakawan/{{ $pustakawan->kode_petugas }}" method="post">
            @method("put")
            @csrf
            <div class="row">
                <div class="col-md-5">
                    <div class="mb-3">
                        <label for="kode" class="form-label">Kode Pustakawan</label>
                        <input type="text" class="form-control @error('kode_petugas') is-invalid @enderror" value="{{ $pustakawan->kode_petugas }}" name="kode_petugas" id="kode" placeholder="Masukan kode pustakawan" readonly>
                        @error('kode_petugas')
                        <div class="invalid-message">
                          {{ $message }}
                        </div>
                        @enderror
                      </div>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" value="{{ old("nama_lengkap", $pustakawan->nama_lengkap) }}" name="nama_lengkap" id="nama" placeholder="Masukan nama pustakawan" required>
                        @error('nama_lengkap')
                        <div class="invalid-message">
                          {{ $message }}
                        </div>
                        @enderror
                      </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control @error('alamat') is-invalid @enderror" name="alamat" id="alamat" placeholder="Masukan alamat pustakawan" required>{{ old("alamat", $pustakawan->alamat) }}</textarea>
                        @error('alamat')
                        <div class="invalid-message">
                          {{ $message }}
                        </div>
                        @enderror
                      </div>
                    <div class="mb-3">
                        <label for="telp" class="form-label">No Telp</label>
                        <input type="number" class="form-control @error('no_telp') is-invalid @enderror" value="{{ old("no_telp", $pustakawan->no_telp) }}" name="no_telp" id="telp" placeholder="Masukan no. Telp pustakawan" required>
                        @error('no_telp')
                        <div class="invalid-message">
                          {{ $message }}
                        </div>
                        @enderror
                      </div>
                      <button class="btn mt-4 btn-primary shadow" type="submit">Edit</button>

                </div>
                <div class="col-md-5">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old("email", $pustakawan->email) }}" name="email" id="email" placeholder="Masukan email pustakawan" required>
                        @error('email')
                        <div class="invalid-message">
                          {{ $message }}
                        </div>
                        @enderror
                      </div>
                      <div class="mb-3">
                        <label for="gambar" class="form-label label-gambar">Foto Pustakawan</label>
                        <input value="{{ old("gambar") }}" class="form-control" type="file" name="gambar" id="gambar" onchange="previewGambar()">
                      </div>
                </div>
            </div>
            
            
        </form>
</div>
@endsection