@extends('layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Tambah Data Buku</h1>
</div>
<div class="row">
    <div class="col-md-12">
        <form action="/kelola-data-buku" method="post" enctype="multipart/form-data">
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
                        <label for="inputJudul" class="form-label">Judul Buku</label>
                        <input type="text" class="form-control @error('judul_buku') is-invalid @enderror" name="judul_buku" id="inputJudul" placeholder="Masukan judul buku" required>
                        @error('judul_buku')
                        <div class="invalid-message">
                          {{ $message }}
                        </div>
                        @enderror
                      </div>
                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" class="form-control @error('slug') is-invalid @enderror" name="slug" id="slug" placeholder="Masukan slug" required readonly>
                        @error('slug')
                        <div class="invalid-message">
                          {{ $message }}
                        </div>
                        @enderror
                      </div>
                    <div class="mb-3">
                        <label for="isbn" class="form-label">ISBN</label>
                        <input type="text" class="form-control @error('isbn') is-invalid @enderror" name="isbn" id="isbn" placeholder="Masukan ISBN" required>
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
                      
                </div>
                <div class="col-md-7">
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
                    <label for="stok" class="form-label">Stok</label>
                    <input type="number" class="form-control @error('stok') is-invalid @enderror" name="stok" id="stok" placeholder="Masukan stok buku" required>
                    @error('harga')
                    <div class="invalid-message">
                      {{ $message }}
                    </div>
                    @enderror
                  </div>
                  <div class="mb-3">
                    <label for="sinopsis" class="form-label">Sinopsis</label> <br>
                    <textarea name="sinopsis" id="sinospsis" style="height: 80px; max-height: 80px; width: 100%" placeholder="Masukan sinopsis buku"></textarea>
                  </div>
                  <div class="mb-3">
                    <label for="gambar" class="form-label">Gambar Cover Buku</label>
                    <input class="form-control" type="file" id="gambar">
                  </div>
                </div>
            </div>
              

              
              <button class="btn btn-primary shadow" type="submit">Tambah</button>
        </form>
    </div>
</div>
@endsection