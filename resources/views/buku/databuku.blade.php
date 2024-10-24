@extends('layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Kelola Data Buku</h1>
</div>

<a href="/kelola-data-buku/create" class="btn btn-primary shadow">Tambah Data Buku</a>


<form action="/kelola-data-buku" method="get">
    @csrf
      <div class="row">
        <div class="mb-3 mt-4">
          <div class="col-md-6 d-flex gap-3">
          <input type="text" class="form-control p-2 fs-6" id="search" name="s" placeholder="Cari berdasarkan judul buku, kategori, penebit, atau penulis">
          <button class="btn btn-primary px-3" type="submit">Cari</button>
        </div>
        </div>
      </div>
  </form>

  <div class="row">
    <div class="col-md-5">
      @if (session()->has('success'))
      <div class="alert alert-success" role="alert">
          {{ session('success') }}
          <button type="button" style="float: right" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
          
      @endif

    </div>
  </div>

<div class="row col-md-11 mt-5 border border-dark">
    <div class="table-container" style="overflow-x: scroll">
        <table class="table table-striped" style="width: 1400px">
            <thead>
              <tr class="text-center">
                <th scope="col">No</th>
                <th scope="col">Kode Buku</th>
                <th scope="col">Judul Buku</th>
                <th scope="col">Gambar</th>
                <th scope="col">Rating</th>
                <th scope="col">Kategori</th>
                <th scope="col">Penulis</th>
                <th scope="col">Penerbit</th>
                <th scope="col">Harga</th>
                <th scope="col">Stok</th>
                <th scope="col">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($buku as $item)
                  <tr class="text-center">
                    <td>{{ $loop->iteration + ($buku->currentPage() - 1) * $buku->perPage() }}</td>
                    <td>{{ $item->kode_buku }}</td>
                    <td>{{ $item->judul_buku }}</td>
                    <td>
                      <a href="/kelola-data-buku/{{ $item->slug }}">
                        <img src="/storage/{{ $item->gambar }}" alt="" class="border border-2 shadow-sm" style="width: 50px">
                      </a>
                    </td>
                    <td><i style="color: rgb(123, 123, 27);" class="fas fa-star border-1"></i> {{ $item->rating }}</td>
                    <td>{{ $item->kategori }}</td>
                    <td>{{ $item->penulis }}</td>
                    <td>{{ $item->penerbit }}</td>
                    <td>Rp. {{ number_format($item->harga, 0, ",", ".") }}</td>
                    <td>{{ $item->stok }}</td>
                    <td>
                        <a href="/kelola-data-buku/{{ $item->slug }}" class="btn btn-info mx-1"><i class="bi bi-eye"></i></a>
                        <a href="/kelola-data-buku/{{ $item->slug }}/edit" class="btn btn-warning mx-1 "><i class="bi bi-pencil-square"></i></a>
                        <form action="/kelola-data-buku/{{ $item->kode_buku }}" onsubmit="return deleteConfirmation(event)" method="post" style="display: inline">
                          @method('delete')
                          @csrf
                          <button type="submit" data-confirm="{{ $item->judul_buku }}" class="btn btn-danger"><i class="bi bi-x-circle"></i></button>
                        </form>
                    </td>
                  </tr>
              @endforeach
            </tbody>
          </table>

        </div>
      </div>
      <div class="row mt-4">
        <div class="col-md-10">
          {{ $buku->links() }}
        </div>
      </div>
@endsection