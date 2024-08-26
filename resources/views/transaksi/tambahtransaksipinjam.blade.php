@extends('layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Tambah Transaksi Peminjaman Buku</h1>
</div>
<form action="">
    @method("post")
    @csrf
    <div class="row">
        <div class="col-md-5">
            <div class="mb-3">
                <label for="kodeTransaksiPinjam" class="form-label">Kode Transaksi Peminjaman</label> <br>
                <input type="text" class="form-control" id="kodeTransaksiPinjam" name="kode_peminjaman" readonly value="{{ $kode_peminjaman }}">
            </div>
            <div class="mb-3">
                <label for="kodeMember" class="form-label">Kode Member</label> <br>
                <input type="text" class="form-control" id="kodeMember" name="kode_member">
            </div>
            <div class="mb-3">
                <label for="kodeBuku" class="form-label">Kode Buku</label> <br>
                <input type="text" class="form-control" id="kodeBuku" name="kode_buku">
                <button type="submit" class="btn btn-primary mt-3">Tambah</button>
            </div>
        </div>
    </div>
</form>
@endsection