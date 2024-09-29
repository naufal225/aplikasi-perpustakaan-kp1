@extends('layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detail Data Buku</h1>
</div>
<a href="/kelola-data-buku" class="btn btn-primary shadow mb-3">Kembali</a> <br>
<div class="row px-1 mt-3">
    <div class="col-10 col-md-2">
        <img src="/storage/{{ $buku->gambar }}" alt="" class="border border-1 border-dark img-fluid shadow">
    </div>
    <div class="col-12 col-md-8">
        <div class="row mb-2">
            <div class="col-md-6">
                <h6>Penulis</h6>
                <h6>{{ $buku->penulis }}</h6>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-6" style="background-color: antiquewhite">
                <h6>Judul Buku</h6>
                <h3 style="margin: 0;">{{ $buku->judul_buku }}</h3>
            </div>
            <div class="col-md-6">
                <h6>Kategori</h6>
                <h5>{{ $buku->kategori->kategori }}</h5>
            </div>
        </div>
        <div class="row mt-5" style="min-height: 169px">
            <div class="col-md-6">
                <h6>Sinopsis</h6>
                <p style="text-align: justify">
                    {{ $buku->sinopsis }}
                </p>

            </div>
        </div>
        <div class="row my-4">
            <div class="col-md-3">
                <h6>Penerbit</h6>
                <p>{{ $buku->penerbit }}</p>
            </div>
            <div class="col-md-3">
                <h6>ISBN</h6>
                <p>{{ $buku->isbn }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <h6>Harga</h6>
                <p>{{ $buku->harga }}</p>
            </div>
        </div>
    </div>
</div>
@endsection