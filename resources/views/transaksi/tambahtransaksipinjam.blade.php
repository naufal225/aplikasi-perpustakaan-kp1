@extends('layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Tambah Transaksi Peminjaman Buku</h1>
</div>

<div class="row">
    <div class="col-md-5">
      @if(session()->has('gagal'))
      <div class="alert alert-success" role="alert">
          {{ session('gagal') }}
          <button type="button" style="float: right" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif

    </div>
  </div>

<form action="/transaksi/tambah-transaksi-pinjam">
    @csrf
    <div class="row">
        <div class="col-md-5">
            <div class="mb-3">
                <label for="kodeTransaksiPinjam" class="form-label">Kode Transaksi Peminjaman</label> <br>
                <input type="text" class="form-control" id="kodeTransaksiPinjam" name="kode_peminjaman" readonly value="{{ $kode_peminjaman }}">
            </div>
            <div class="mb-3">
                <label for="kodeMember" class="form-label">Kode Member</label> <br>
                <input type="text" class="form-control @error("kode_member") is-invalid @enderror " @if(session()->has('kode_buku') && count(session('kode_buku')) > 0) readonly @endif id="kodeMember" name="kode_member" value={{ old("kode_member", session("kode_member")) }}>
                @error('kode_member')
                    <div class="invalid-message">
                      {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="kodeBuku" class="form-label">Kode Buku</label> <br>
                <input type="text" class="form-control @error("kode_buku") is-invalid @enderror" id="kodeBuku" name="kode_buku">
                @error('kode_buku')
                        <div class="invalid-message">
                          {{ $message }}
                        </div>
                        @enderror
                <button type="submit" id="btnTambahTransaksi" class="btn btn-primary mt-3">Tambah</button>
            </div>
        </div>
    </div>
</form>

<div class="row col-md-11 mt-2 border border-dark">
    <div class="table-container">
        <table class="table table-striped">
            <thead>
              <tr class="text-center">
                <th scope="col">#</th>
                <th scope="col">Judul Buku</th>
                <th scope="col">Aksi</th>
              </tr>
            </thead>
            <tbody>
                @if (session()->has('kode_buku'))
                    @foreach (session('kode_buku') as $item)
                        <tr class="text-center">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->judul_buku }}</td>
                            <td>
                                <!-- Aksi untuk menghapus item dari session atau tindakan lainnya -->
                                <form action="{{ route('hapus.item', $item->kode_buku) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="3">Tidak ada buku di dalam keranjang.</td>
                    </tr>
                @endif
            </tbody>
            
          </table>

        </div>

        
    </div>
    <a href="/transaksi/tambah-transaksi-pinjam/simpan" class="btn btn-primary shadow px-3 py-2 mt-3">Simpan Transaksi Peminjaman</a>
@endsection