@extends('layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Kelola Data Pustakawan</h1>
</div>
<a href="/kelola-data-pustakawan/create" class="btn btn-primary shadow">Tambah Data Pustakawan</a>


<form action="/kelola-data-pustakawan" method="get">
    @csrf
      <div class="row">
        <div class="mb-3 mt-4">
          <div class="col-md-6 d-flex gap-3">
          <input type="text" class="form-control p-2 fs-6" id="search" name="s" placeholder="Cari berdasarkan nama atau kode pustakawan">
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
                <th scope="col">Kode Pustakawan</th>
                <th scope="col">Nama</th>
                <th scope="col">Alamat</th>
                <th scope="col">No Telp</th>
                <th scope="col">Email</th>
                <th scope="col">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($pustakawan as $item)
                  <tr class="text-center">
                    <td>{{ $loop->iteration + ($pustakawan->currentPage() - 1) * $pustakawan->perPage() }}</td>
                    <td>{{ $item->kode_petugas }}</td>
                    <td>{{ $item->nama_lengkap }}</td>
                    <td>{{ $item->alamat }}</td>
                    <td>{{ $item->no_telp }}</td>
                    <td>{{ $item->email }}</td>
                    <td class="d-flex justify-content-center gap-4">
                        <a href="/kelola-data-pustakawan/{{ $item->kode_petugas }}/edit" class="btn btn-warning"><i class="bi bi-pencil-square"></i></a>
                        <form action="/kelola-data-pustakawan/{{ $item->kode_petugas }}" onsubmit="return deleteConfirmation(event)" method="post">
                          @method('delete')
                          @csrf
                          <button type="submit" data-confirm="{{ $item->nama_lengkap }}" class="btn btn-danger"><i class="bi bi-x-circle"></i></button>
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
          {{ $pustakawan->links() }}
        </div>
      </div>

@endsection