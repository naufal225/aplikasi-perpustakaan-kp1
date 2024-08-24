@extends('layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Kelola Data Member</h1>
</div>
<a href="/kelola-data-member/create" class="btn btn-primary shadow">Tambah Data Member</a>


<form action="/kelola-data-member" method="get">
    @csrf
      <div class="row">
        <div class="mb-3 mt-4">
          <div class="col-md-6 d-flex gap-3">
          <input type="text" class="form-control p-2 fs-6" id="search" name="s" placeholder="Cari berdasarkan nama atau kode member">
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
                <th scope="col">Kode Member</th>
                <th scope="col">Nama</th>
                <th scope="col">Alamat</th>
                <th scope="col">No Telp</th>
                <th scope="col">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($member as $item)
                  <tr class="text-center">
                    <td>{{ $loop->iteration + ($member->currentPage() - 1) * $member->perPage() }}</td>
                    <td>{{ $item->kode_member }}</td>
                    <td>{{ $item->nama_lengkap }}</td>
                    <td>{{ $item->alamat }}</td>
                    <td>{{ $item->no_telp }}</td>
                    <td>
                        <a href="/kelola-data-member/{{ $item->kode_member }}/edit" class="btn btn-warning"><i class="bi bi-pencil-square"></i></a>
                        <a href="" class="btn btn-danger"><i class="bi bi-x-circle"></i></a>
                    </td>
                  </tr>
              @endforeach
            </tbody>
          </table>

        </div>
      </div>
      <div class="row mt-4">
        <div class="col-md-10">
          {{ $member->links() }}
        </div>
      </div>

@endsection