@extends('layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard</h1>
</div>
<div class="row mx-2 gap-3">
    <!-- Card Jumlah Buku -->
    <a href="/kelola-data-buku" class="card-info-dashboard shadow col-md-2 my-2 border border-dark bg-primary rounded d-flex justify-content-center align-items-center text-white text-decoration-none">
        <div class="text-center p-4">
            <h2 class="mb-0">{{ $jumlahBuku }}</h2>
            <h6 class="mt-0">Jumlah Buku</h6>
        </div>
    </a>
    <!-- Card Jumlah Peminjaman -->
    <a href="/transaksi/pinjam-buku" class="card-info-dashboard shadow col-md-2 my-2 border border-dark bg-info rounded d-flex justify-content-center align-items-center text-white text-decoration-none">
        <div class="text-center p-4">
            <h2 class="mb-0">{{ $jumlahPinjam }}</h2>
            <h6 class="mt-0">Peminjaman</h6>
        </div>
    </a>
    <!-- Card Jumlah Pengembalian -->
    <a href="/transaksi/kembali-buku" class="card-info-dashboard shadow col-md-2 my-2 border border-dark bg-success rounded d-flex justify-content-center align-items-center text-white text-decoration-none">
        <div class="text-center p-4">
            <h2 class="mb-0">{{ $jumlahKembali }}</h2>
            <h6 class="mt-0">Pengembalian</h6>
        </div>
    </a>
    <!-- Card Jumlah Keterlambatan -->
    <a href="/transaksi/kembali-buku" class="card-info-dashboard shadow col-md-2 my-2 border border-dark bg-danger rounded d-flex justify-content-center align-items-center text-white text-decoration-none">
        <div class="text-center p-4">
            <h2 class="mb-0">{{ $keterlambatan }}</h2>
            <h6 class="mt-0">Keterlambatan</h6>
        </div>
    </a>
    <!-- Card Buku Hilang/Rusak -->
    <a href="/transaksi/kembali-buku" class="card-info-dashboard shadow col-md-2 my-2 border border-dark bg-warning rounded d-flex justify-content-center align-items-center text-white text-decoration-none">
        <div class="text-center p-4">
            <h2 class="mb-0">{{ $hilangAtauRusak }}</h2>
            <h6 class="mt-0">Buku Hilang/Rusak</h6>
        </div>
    </a>
</div>

<div class="row">
    <div class="col-md-9">
        <div class="mt-5 border-dark border-0 rounded shadow p-4 container-chart">
            <h6 class="text-center">Tabel Data Transaksi Per Bulan {{ $bulanHuruf }} Tahun {{ date("Y") }}</h6>
            <canvas id="chart"></canvas>
        </div>
    </div>
</div>
<hr>
@endsection
