@extends('layouts.mainkatalog')

@section('container')

<div class="d-flex mt-2 justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h1 class="h2">Riwayat Peminjaman Anda</h1>
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

<div class="row mt-3">
    @foreach ($data as $item)
        <div class="col-md-12 mb-4">
            <div class="card d-flex flex-row h-100 shadow-sm">
                <img src="/storage/{{ $item->buku->gambar }}" class="card-img-start img-fluid" alt="{{ $item->buku->judul_buku }}" style="height: 230px;">
                <div class="card-body">
                    <h5 class="card-title">{{ $item->buku->judul_buku }}</h5>
                    <div class="row">
                        <div class="col">
                            <p class="card-text"><strong>Penulis:</strong> {{ $item->buku->penulis }}</p>
                            <p class="card-text"><strong>Penerbit:</strong> {{ $item->buku->penerbit }}</p>
                        </div>
                        <div class="col">
                            <p class="card-text"><strong>Tanggal Peminjaman:</strong> {{ \Carbon\Carbon::parse($item->tgl_peminjaman)->format('d F Y') }}</p>
                            <p class="card-text"><strong>Status:</strong> {{ $item->keterangan }}</p>
                        </div>
                    </div>                    
                    @if (!$item->rating_ada && $item->keterangan == "selesai")
                    <div class="row">
                        <div class="col">
                        </div>
                        <div class="col">
                            <form action="{{ route('rate.buku') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id_buku" value="{{ $item->buku->id }}">
                    
                                <div class="mb-3">
                                    <label for="rating" class="form-label">Berikan Rating:</label>
                                    <div class="star-rating">
                                        @for ($i = 5; $i >= 1; $i--)
                                            <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" required />
                                            <label for="star{{ $i }}" title="{{ $i }} stars">
                                                <i class="fas fa-star"></i>
                                            </label>
                                        @endfor
                                    </div>
                                </div>
                    
                                <button type="submit" class="btn btn-primary">Rate</button>
                            </form>
                        </div>
                    </div>
                    
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>

@endsection