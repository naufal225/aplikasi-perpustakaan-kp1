@extends('layouts.mainkatalog')

@section('container')

@if(session()->has("RegisterSuccess"))
    <div class="col-md-8 mx-auto">
        <div class="alert alert-success d-flex justify-content-between align-items-center" role="alert">
            {{ session("RegisterSuccess") }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
@endif

<div class="d-flex mt-2 justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h1 class="h2">Cari Data Buku</h1>
</div>

<div class="row mt-1">
    <div class="col-md-9">
        <form id="search-form">
            <div class="form-group">
                <input type="text" id="search-input" class="form-control" placeholder="Cari judul buku...">
            </div>
        </form>
    </div>
</div>

<div class="row mt-3 justify-content-center" id="search-result">
    @foreach ($data as $item)
        <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
            <a href="/katalog/detail?judul={{ $item->judul_buku }}" class="text-decoration-none text-dark">
                <div class="card shadow h-100 position-relative">
                    <!-- Rating di atas gambar -->
                    <div class="position-absolute top-0 start-0 bg-warning text-dark p-2 rounded-end shadow-sm">
                        <i class="fas fa-star"></i>
                        @if($item->rating)
                            {{ $item->rating }}
                        @else
                            Belum ada rating
                        @endif
                    </div>
                    <img src="/storage/{{ $item->gambar }}" class="card-img-top border-bottom" alt="{{ $item->judul_buku }}">
                    <div class="card-body d-flex flex-column">
                        <div class="mb-auto">
                            <p class="card-text">{{ $item->penulis }}</p>
                            <h6 class="card-title mt-1 mb-2 fs-5">{{ $item->judul_buku }}</h6>
                            <p>Stok: 
                                @if($item->stok > 0)
                                    <span class="bg-success text-light px-1 py-2">{{ $item->stok }}</span>
                                @else
                                    <span class="bg-danger text-light px-1 py-2">{{ $item->stok }}</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    @endforeach
</div>

@endsection
