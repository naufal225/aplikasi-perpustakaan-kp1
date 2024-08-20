@extends('layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Kelola Data Member</h1>
</div>
<a href="/kelola-data-member/create" class="btn btn-primary shadow">Tambah Data Member</a>

@if (session()->has('success'))
<div class="alert alert-success" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
    
@endif

<form action="/kelola-data-member/search" method="get">
    @csrf
    <div class="mb-3 mt-4">
        <div class="row">
            <div class="col-md-6 d-flex gap-3">
                <input type="text" class="form-control p-2 fs-6" id="search" name="s" placeholder="Cari berdasarkan judul buku, kategori, penebit, atau penulis">
                <button class="btn btn-primary px-3" type="submit">Cari</button>
            </div>
        </div>
      </div>
</form>

<div class="row col-md-11 mt-5 border border-dark">
    <div class="table-container">
        <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Kode Member</th>
                <th scope="col">Nama</th>
                <th scope="col">Alamat</th>
                <th scope="col">No Telp</th>
                <th scope="col">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($member as $item)
                  <tr class="">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->kode_member }}</td>
                    <td>{{ $item->nama_lengkap }}</td>
                    <td>{{ $item->alamat }}</td>
                    <td>{{ $item->no_telp }}</td>
                    <td>
                        <a href="" class="btn btn-warning">Edit</a>
                        <a href="" class="btn btn-danger">Delete</a>
                    </td>
                  </tr>
              @endforeach
            </tbody>
          </table>
    </div>
</div>

@endsection