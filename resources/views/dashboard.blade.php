@extends('layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard</h1>
</div>
<div class="row mx-2 gap-2">
    <div style="height: 60px;" class="col-md-2 my-2 me-5 border border-dark bg-primary rounded d-flex justify-content-center align-items-center text-white my-auto">
        <div class="d-flex w-100">
            <div class="pe-2 border-end border-dark">
                <h2 class="mb-0 text-center">{{ $jumlahBuku }}</h2>
            </div>
            <div class="ps-2">
                <h5 class="mt-2 text-center">Jumlah Buku</h5>
            </div>
        </div>
    </div>
    <div style="height: 60px;" class="col-md-2 my-2 me-5 border border-dark bg-info rounded d-flex justify-content-center align-items-center text-white my-auto">
        <div class="d-flex w-100">
            <div class="pe-2 border-end border-dark">
                <h2 class="mb-0 text-center">{{ $jumlahPinjam }}</h2>
            </div>
            <div class="ps-2">
                <h6 class="mt-2 text-center">Transaksi Pinjam</h6>
            </div>
        </div>
    </div>
    <div style="height: 60px;" class="col-md-2 my-2 me-5 border border-dark bg-success rounded d-flex justify-content-center align-items-center text-white my-auto">
        <div class="d-flex w-100">
            <div class="pe-2 border-end border-dark mt-2">
                <h2 class="mb-1 text-center">{{ $jumlahKembali }}</h2>
            </div>
            <div class="ps-2">
                <h6 class="mt-3 text-center">Transaksi Kembali</h6>
            </div>
        </div>
    </div>
    <div style="height: 60px;" class="col-md-2 my-2 me-5 border border-dark bg-danger rounded d-flex justify-content-center align-items-center text-white my-auto">
        <div class="d-flex w-100">
            <div class="pe-2 border-end border-dark">
                <h2 class="mb-0 text-center">{{ $keterlambatan }}</h2>
            </div>
            <div class="ps-2">
                <h6 class="mt-2 text-center">Keterlambatan</h6>
            </div>
        </div>
    </div>
</div>
<div class="mt-5 border-dark border ms-2 p-lg-5 container-chart" style=""><canvas id="chart"></canvas></div>
<hr>

@endsection