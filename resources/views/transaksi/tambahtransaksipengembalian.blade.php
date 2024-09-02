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
                <input type="text" class="form-control" id="kodeTransaksiPinjam" name="kode_peminjaman" value="{{ old("kode_peminjaman") }}">
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
            <input readonly type="text" class="form-control" id="kodeMember" name="kode_member" value="{{ session()->has("kode_member") ? session("kode_member") : "" }}">
            @error('kode_member')
                <div class="invalid-message">
                  {{ $message }}
                </div>
            @enderror
        </div>
    </div>
</div>

<div class="row col-md-11 mt-2 border border-dark">
    <div class="table-container" style="overflow-x: scroll;">
        <table class="table table-striped">
            <thead>
              <tr class="text-center">
                <th scope="col">#</th>
                <th scope="col">Kode Buku</th>
                <th scope="col">Judul Buku</th>
                <th scope="col">Status</th>
                <th scope="col">Kondisi</th>
                <th scope="col">Aksi</th>
              </tr>
            </thead>
            <tbody>
                @if (session()->has('data_peminjaman'))
                @foreach (session('data_peminjaman') as $item)
                        <tr class="text-center">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item["kode_buku"] }}</td>
                            <td>{{ $item["judul_buku"] }}</td>
                            <td class="status">{{ $item["status"] }}</td>
                            <td>
                                <select class="custom-select form-control kondisi" name="kondisi" id="kondisi">
                                    <option value="baik" class="opsi-baik">Baik</option>
                                    <option value="rusak atau hilang" class="opsi-jelek">Rusak atau hilang</option>
                                </select>
                            </td>
                            <td>
                                <!-- Aksi untuk menghapus item dari session atau tindakan lainnya -->
                                <form action="/transaksi/kembali-buku" method="POST" class="btn-kembali">
                                    @csrf
                                    <input type="hidden" name="kode_member" value="{{ session("kode_member") }}">
                                    <input type="hidden" name="kode_buku" value="{{ $item['kode_buku'] }}">
                                    <button type="submit" class="btn btn-primary shadow px-3">Kembalikan</button>
                                </form>
                                <form action="" method="POST" class="btn-denda">
                                    @csrf
                                    <input type="hidden" name="kode_member" value="{{ session("kode_member") }}">
                                    <input type="hidden" name="kode_buku" value="{{ $item['kode_buku'] }}">
                                    <button type="submit" class="btn btn-danger shadow">Bayar Denda</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6">Tidak ada buku di dalam keranjang.</td>
                    </tr>
                @endif
            </tbody>
            
          </table>

        </div>

        
    </div>
@endsection