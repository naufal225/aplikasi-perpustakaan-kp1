@extends('layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Kelola Data Kategori</h1>
</div>

<a href="/kelola-data-kategori/create" class="btn btn-primary shadow">Tambah Data Kategori</a>


<form action="/kelola-data-kategori" method="get">
    @csrf
      <div class="row">
        <div class="mb-3 mt-4">
          <div class="col-md-6 d-flex gap-3">
          <input type="text" class="form-control p-2 fs-6" id="search" name="s" placeholder="Cari berdasarkan kode kategori atau kategori">
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
    <div class="table-container">
        <table class="table table-striped">
            <thead>
              <tr class="text-center">
                <th scope="col">No</th>
                <th scope="col">Kode Kategori</th>
                <th scope="col">Kategori</th>
                <th scope="col">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($kategori as $item)
                  <tr class="text-center">
                    <td>{{ $loop->iteration + ($kategori->currentPage() - 1) * $kategori->perPage() }}</td>
                    <td>{{ $item->kode_kategori }}</td>
                    <td>{{ $item->kategori }}</td>
                    <td class="d-flex justify-content-center gap-4">
                        <a href="/kelola-data-kategori/{{ $item->slug }}/edit" class="btn btn-warning mx-1 "><i class="bi bi-pencil-square"></i></a>
                        <form action="/kelola-data-kategori/{{ $item->slug }}" onsubmit="return deleteConfirmation(event)" method="post">
                          @method('delete')
                          @csrf
                          <button type="submit" data-confirm="{{ $item->kategori }}" class="btn btn-danger"><i class="bi bi-x-circle"></i></button>
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
          {{ $kategori->links() }}
        </div>
      </div>
@endsection