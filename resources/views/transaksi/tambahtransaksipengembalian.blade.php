@extends('layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Tambah Transaksi Pengembalian Buku</h1>
</div>
<form action="/transaksi/tambah-transaksi-kembali/cari-transaksi-pinjam">
    @csrf
    <div class="row">
        <div class="col-md-5">
            <div class="mb-3">
                <label for="kodeTransaksiPinjam" class="form-label">Kode Transaksi Peminjaman</label> <br>
                <input type="text" class="form-control" id="kodeTransaksiPinjam" name="kode_peminjaman" value="{{ old('kode_peminjaman') }}">
            </div>
            <div class="mb-3">
                <button class="btn btn-primary shadow" type="submit">Cari</button>
            </div>
        </div>
    </div>
</form>

<div class="row">
    <div class="col-md-5">
        <div class="mb-3">
            <label for="kodeMember" class="form-label">Kode Member</label> <br>
            <input readonly type="text" class="form-control" id="kodeMember" name="kode_member" value="{{ session()->has('kode_member') ? session('kode_member') : '' }}">
            @error('kode_member')
                <div class="invalid-message">
                  {{ $message }}
                </div>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-5">
      @if(session()->has('success'))
      <div class="alert alert-success" role="alert">
          {{ session('success') }}
          <button type="button" style="float: right" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif
    </div>
</div>

<div class="row">
    <div class="col-md-5">
      @if (session()->has('gagal'))
      <div class="alert alert-danger" role="alert">
          {{ session('gagal') }}
          <button type="button" style="float: right" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif
    </div>
</div>

<form action="/transaksi/kembali-buku" method="POST">
    @csrf
    <div class="row col-md-11 mt-2 border border-dark">
        <div class="table-container" style="overflow-x: scroll;">
            <table class="table table-striped">
                <thead>
                  <tr class="text-center">
                    <th scope="col">#</th>
                    <th scope="col">Kode Buku</th>
                    <th scope="col">Judul Buku</th>
                    <th scope="col">Pilih</th>
                    <th scope="col">Kondisi</th>
                  </tr>
                </thead>
                <tbody>
                    @if (session()->has('data_peminjaman'))
                    @foreach (session('data_peminjaman') as $item)
                        <tr class="text-center" id="row-{{ $item['kode_buku'] }}">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item['kode_buku'] }}</td>
                            <td>{{ $item['judul_buku'] }}</td>
                            <td>
                                <input type="hidden" name="status" value="{{ $item['status'] }}">
                                <input type="hidden" name="kode_peminjaman" value="{{ session("kode_peminjaman") ? session("kode_peminjaman") : "" }}">
                                <input type="checkbox" name="kembali[]" value="{{ $item['kode_buku'] }}" class="checkbox-kembali">
                            </td>
                            <td>
                                <select class="form-control kondisi" name="kondisi[{{ $item['kode_buku'] }}]" id="kondisi-{{ $item['kode_buku'] }}">
                                    <option value="baik">Baik</option>
                                    <option value="rusak atau hilang">Rusak atau hilang</option>
                                </select>
                            </td>
                        </tr>
                    @endforeach
                    @else
                        <tr>
                            <td colspan="5">Tidak ada buku di dalam keranjang.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-5">
            <button type="submit" class="btn btn-primary shadow">Proses Pengembalian</button>
        </div>
    </div>
</form>
@endsection
