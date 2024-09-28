@extends('layouts.mainkatalog')

@section('container')
<div class="d-flex mt-2 justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h1 class="h2">Katalog</h1>
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
<div class="row mt-3" id="search-result">
    @foreach ($data as $item)
        <div class="col-sm-3">
            <a href="/katalog/detail?judul={{ $item->judul_buku }}" class="text-decoration-none text-dark">
                <div class="card mb-4 shadow">
                    <img src="/storage/{{ $item->gambar }}" class="card-img-top border-bottom" alt="${item.title}">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-10">
                                <p>{{ $item->penulis }}</p>
                            </div>
                        </div>
                        <h6 class="card-title mt-1 mb-2 fs-5">{{ $item->judul_buku }}</h6>
                        <div class="row">
                            <div class="col-sm-12">
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
                </div>
            </a>
        </div>
    @endforeach
</div>


@endsection