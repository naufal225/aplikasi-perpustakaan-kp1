@extends('layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard</h1>
</div>
<div class="row mx-2 gap-2">
    <div style="height: 60px;" class="shadow col-md-2 my-2 me-5 border border-dark bg-primary rounded d-flex justify-content-center align-items-center text-white my-auto">
        <div class="d-flex w-100">
            <div class="pe-2 border-end border-dark">
                <h2 class="mb-0 text-center">{{ $jumlahBuku }}</h2>
            </div>
            <div class="ps-2">
                <h5 class="mt-2 text-center">Jumlah Buku</h5>
            </div>
        </div>
    </div>
    <div style="height: 60px;" class="shadow col-md-2 my-2 me-5 border border-dark bg-info rounded d-flex justify-content-center align-items-center text-white my-auto">
        <div class="d-flex w-100">
            <div class="pe-2 border-end border-dark">
                <h2 class="mb-0 text-center">{{ $jumlahPinjam }}</h2>
            </div>
            <div class="ps-2">
                <h5 class="mt-2 text-center">Peminjaman</h5>
            </div>
        </div>
    </div>
    <div style="height: 60px;" class="shadow col-md-2 my-2 me-5 border border-dark bg-success rounded d-flex justify-content-center align-items-center text-white my-auto">
        <div class="d-flex w-100">
            <div class="pe-2 border-end border-dark">
                <h2 class="mb-0 text-center">{{ $jumlahKembali }}</h2>
            </div>
            <div class="ps-1">
                <h5 class="mt-2 text-center">Pengembalian</h5>
            </div>
        </div>
    </div>
    <div style="height: 60px;" class="shadow col-md-2 my-2 me-5 border border-dark bg-danger rounded d-flex justify-content-center align-items-center text-white my-auto">
        <div class="d-flex w-100">
            <div class="pe-2 border-end border-dark">
                <h2 class="mb-0 text-center">{{ $keterlambatan }}</h2>
            </div>
            <div class="ps-2">
                <h5 class="mt-2 text-center">Keterlambatan</h5>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-9">
        <div class="mt-5 border-dark border-0 rounded shadow ms-2 p-lg-5 container-chart"><canvas id="chart"></canvas></div>

    </div>
</div>
<hr>

@endsection