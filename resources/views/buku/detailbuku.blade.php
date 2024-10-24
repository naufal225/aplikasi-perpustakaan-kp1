@extends('layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detail Buku: {{ $buku->judul_buku }}</h1>
</div>

<a href="/kelola-data-buku" class="btn btn-primary shadow mb-4">
    <i class="bi bi-arrow-left"></i> Kembali
</a> 

<div class="row g-4">
    <!-- Gambar Buku -->
    <div class="col-md-3">
        <div class="card shadow-sm position-relative">
            <!-- Rating di atas gambar -->
            <div class="position-absolute top-0 start-0 bg-warning text-dark p-2 rounded-end shadow-sm">
                <i class="fas fa-star"></i> 
                @if($buku->rating)
                    {{ $buku->rating }}
                @else
                    Belum ada rating
                @endif
            </div>
            <img src="/storage/{{ $buku->gambar }}" class="card-img-top img-fluid border" alt="Gambar Buku">
        </div>
    </div>

    <!-- Detail Buku -->
    <div class="col-md-8">
        <div class="card shadow-sm p-4">
            <div class="mb-4">
                <h4 class="text-primary">{{ $buku->judul_buku }}</h4>
                <p><strong>Penulis: </strong>{{ $buku->penulis }}</p>
                <p><strong>Kategori: </strong>{{ $buku->kategori->kategori }}</p>
            </div>

            <div class="mb-4">
                <h5 class="text-secondary">Sinopsis</h5>
                <p class="" style="text-align: justify">{{ $buku->sinopsis }}</p>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <p><strong>Penerbit: </strong>{{ $buku->penerbit }}</p>
                </div>
                <div class="col-md-4">
                    <p><strong>ISBN: </strong>{{ $buku->isbn }}</p>
                </div>
                <div class="col-md-4">
                    <p><strong>Harga: </strong>Rp. {{ number_format($buku->harga, 0, ",", ".") }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
