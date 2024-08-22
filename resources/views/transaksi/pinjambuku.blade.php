@extends('layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Kelola Transaksi Peminjaman Buku</h1>
</div>

<a href="/transaksi/pinjam-buku/create" class="btn btn-primary shadow">Tambah Transaksi Peminjaman</a>


<form action="/transaksi/pinjam-buku" method="get">
    @csrf
      <div class="row">
        <div class="mb-3 mt-4">
          <div class="col-md-6 d-flex gap-3">
          <input type="text" class="form-control p-2 fs-6" id="search" name="s" placeholder="Cari berdasarkan kode peminjaman, nama peminjam atau judul buku">
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
                <th scope="col">#</th>
                <th scope="col">Kode Peminjaman</th>
                <th scope="col">Nama Peminjam</th>
                <th scope="col">Judul Buku</th>
                <th scope="col">Tanggal Pinjam</th>
                <th scope="col">Status</th>
                <th scope="col">Keterangan</th>
                <th scope="col">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($transaksi as $item)
              @dd($item->buku);
                  <tr class="text-center">
                    <td>{{ $loop->iteration + ($transaksi->currentPage() - 1) * $transaksi->perPage() }}</td>
                    <td>{{ $item->kode_peminjaman }}</td>
                    <td>{{ $item->member->nama_lengkap }}</td>
                    <td>{{ $item->buku->judul_buku }}</td>
                    <td>{{ $item->tgl_peminjaman }}</td>
                    <td>{{ $item->status }}</td>
                    <td>{{ $item->keterangan }}</td>
                    <td>
                        <a href="" class="btn btn-warning mx-1 "><i class="bi bi-pencil-square"></i></a>
                        <a href="" class="btn btn-danger mx-1"><i class="bi bi-x-circle"></i></a>
                    </td>
                  </tr>
              @endforeach
            </tbody>
          </table>

        </div>
      </div>
      <div class="row mt-4">
        <div class="col-md-10">
          {{ $transaksi->links() }}
        </div>
      </div>
@endsection