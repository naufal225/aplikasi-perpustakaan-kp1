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
            <input readonly type="text" class="form-control" id="kodeMember" name="kode_member">
            @error('kode_member')
                <div class="invalid-message">
                  {{ $message }}
                </div>
            @enderror
        </div>
    </div>
</div>
@endsection