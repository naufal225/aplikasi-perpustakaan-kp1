@extends('layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Konfirmasi Registrasi Member</h1>
</div>


<form action="/konfirmasi-registrasi-member" method="get">
    @csrf
      <div class="row">
        <div class="mb-3 mt-4">
          <div class="col-md-6 d-flex gap-3">
          <input type="text" class="form-control p-2 fs-6" id="search" name="s" placeholder="Cari berdasarkan nama">
          <button class="btn btn-primary px-3" type="submit">Cari</button>
        </div>
        </div>
      </div>
  </form>


<div class="row col-md-11 mt-5 border border-dark">
    <div class="table-container">
        <table class="table table-striped">
            <thead>
              <tr class="text-center">
                <th scope="col">No</th>
                <th scope="col">Nama</th>
                <th scope="col">Alamat</th>
                <th scope="col">Email</th>
                <th scope="col">No Telp</th>
                <th scope="col">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($data as $item)
                  <tr class="text-center">
                    <td>{{ $loop->iteration + ($data->currentPage() - 1) * $data->perPage() }}</td>
                    <td>{{ $item->nama_lengkap }}</td>
                    <td>{{ $item->alamat }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->no_telp }}</td>
                    <td class="d-flex justify-content-center gap-4">
                        <form action="/konfirmasi-registrasi-member/tolak/{{ $item->id }}" method="post">
                          @method('post')
                          @csrf
                          <button type="submit" class="btn btn-danger"><i class="bi bi-x-circle"></i></button>
                        </form>
                        <form action="/konfirmasi-registrasi-member/acc/{{ $item->id }}" method="post">
                          @method('post')
                          @csrf
                          <button type="submit" class="btn btn-success"><i class="bi bi-check"></i></button>
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
          {{ $data->links() }}
        </div>
      </div>

@endsection