@extends('layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Tambah Data Buku</h1>
</div>
<div class="row">
    <div class="col-md-12">
        <form action="/kelola-data-buku" method="post">
            @method("post")
            @csrf
            <div class="row">
                <div class="col-md-5">
                    <div class="mb-3">
                        <label for="kode" class="form-label">Kode Buku</label>
                        <input type="text" class="form-control @error('kode_buku') is-invalid @enderror" value="{{ $kodeBuku }}" name="kode_buku" id="kode" placeholder="Masukan kode buku">
                        @error('kode_buku')
                        <div class="invalid-message">
                          {{ $message }}
                        </div>
                        @enderror
                      </div>
                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul Buku</label>
                        <input type="text" class="form-control @error('judul_buku') is-invalid @enderror" name="judul_buku" id="judul" placeholder="Masukan judul buku" required>
                        @error('judul_buku')
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
                        <label for="isbn" class="form-label">ISBN</label>
                        <input type="number" class="form-control @error('isbn') is-invalid @enderror" name="isbn" id="isbn" placeholder="Masukan ISBN" required>
                        @error('isbn')
                        <div class="invalid-message">
                          {{ $message }}
                        </div>
                        @enderror
                      </div>
                    <div class="mb-3">
                        <label for="penulis" class="form-label">Penulis</label>
                        <input type="penulis" class="form-control @error('penulis') is-invalid @enderror" name="penulis" id="penulis" placeholder="Masukan nama penulis" required>
                        @error('penulis')
                        <div class="invalid-message">
                          {{ $message }}
                        </div>
                        @enderror
                      </div>
                    <div class="mb-3">
                        <label for="penerbit" class="form-label">Penerbit</label>
                        <input type="penerbit" class="form-control @error('penerbit') is-invalid @enderror" name="penerbit" id="penerbit" placeholder="Masukan nama penerbit" required>
                        @error('penerbit')
                        <div class="invalid-message">
                          {{ $message }}
                        </div>
                        @enderror
                      </div>
                      <div class="mb-3">
                        <label for="harga" class="form-label">Harga</label>
                        <input type="number" class="form-control @error('harga') is-invalid @enderror" name="harga" id="harga" placeholder="Masukan harga buku" required>
                        @error('harga')
                        <div class="invalid-message">
                          {{ $message }}
                        </div>
                        @enderror
                      </div>
                      <div class="mb-3">
                        <label for="sinopsis" class="form-label">Sinopsis</label>
                        <textarea name="sinopsis" id="sinospsis" cols="30" rows="10" placeholder="Masukan sinopsis buku"></textarea>
                      </div>
                </div>
                <div class="col-md-7">

                </div>
            </div>
              

              
              <button class="btn btn-primary shadow" type="submit">Tambah</button>
        </form>
    </div>
</div>
@endsection