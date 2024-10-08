@extends('layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h2>Tambah Data Kategori</h2>
</div>  
<div class="row">
    <div class="col-md-8">
        <form action="/kelola-data-kategori" method="post">
            @method("post")
            @csrf
            <div class="mb-3">
                <label for="kode" class="form-label">Kode Kategori</label>
                <input readonly type="text" class="form-control @error('kode_kategori') is-invalid @enderror" value="{{ $kodeKategori }}" name="kode_kategori" id="kode" placeholder="Masukan kode kategori">
                @error('kode_kategori')
                <div class="invalid-message">
                  {{ $message }}
                </div>
                @enderror
              </div>
            <div class="mb-3">
                <label for="kategori" class="form-label">Kategori</label>
                <input type="text" class="form-control @error('kategori') is-invalid @enderror" name="kategori" id="kategori" placeholder="Masukan nama kategori" required>
                @error('kategori')
                <div class="invalid-message">
                  {{ $message }}
                </div>
                @enderror
              </div>
            <div class="mb-3">
                <label for="slug" class="form-label">slug</label>
                <input readonly type="text" class="form-control @error('slug') is-invalid @enderror" name="slug" id="slug" placeholder="Masukan slug" required>
                @error('slug')
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