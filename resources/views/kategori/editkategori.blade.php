@extends('layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h2>Edit Data Kategori</h2>
</div>  
<div class="row">
    <div class="col-md-8">
        <form action="/kelola-data-kategori/{{ $kategori->kode_kategori }}" method="post">
            @method("put")
            @csrf
            <div class="mb-3">
                <label for="kode" class="form-label">Kode Kategori</label>
                <input readonly type="text" class="form-control @error('kode_kategori') is-invalid @enderror" value="{{ $kategori->kode_kategori }}" name="kode_kategori" id="kode" placeholder="Masukan kode kategori">
                @error('kode_kategori')
                <div class="invalid-message">
                  {{ $message }}
                </div>
                @enderror
              </div>
            <div class="mb-3">
                <label for="kategori" class="form-label">Kategori</label>
                <input type="text" class="form-control @error('kategori') is-invalid @enderror" name="kategori" id="inputJudul" placeholder="Masukan nama kategori" required value="{{ $kategori->kategori }}">
                @error('kategori')
                <div class="invalid-message">
                  {{ $message }}
                </div>
                @enderror
              </div>
            <div class="mb-3">
                <label for="slug" class="form-label">slug</label>
                <input readonly type="text" class="form-control @error('slug') is-invalid @enderror" name="slug" id="slug" placeholder="Masukan slug" required value="{{ $kategori->slug }}">
                @error('slug')
                <div class="invalid-message">
                  {{ $message }}
                </div>
                @enderror
              </div>
              
              <button class="btn btn-primary shadow" type="submit">Edit</button>
        </form>
    </div>
</div>
@endsection