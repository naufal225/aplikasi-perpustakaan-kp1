<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\TransaksiKembali;
use App\Models\TransaksiPinjam;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index() {
        $bulan = date('m');
        $tahun = date('Y');

        return view("dashboard", [
            "jumlahBuku" => Buku::count(),
            "jumlahKembali" => TransaksiKembali::whereMonth('tgl_pengembalian', $bulan)->whereYear('tgl_pengembalian', $tahun)->count(),
            "jumlahPinjam" => TransaksiPinjam::whereMonth('tgl_peminjaman', $bulan)->whereYear('tgl_peminjaman', $tahun)->count(),
            "keterlambatan" => TransaksiPinjam::whereMonth('tgl_peminjaman', $bulan)->whereYear('tgl_peminjaman', $tahun)->count(),
            "hilangAtauRusak" => TransaksiKembali::whereMonth('tgl_pengembalian', $bulan)->whereYear('tgl_pengembalian', $tahun)->where('kondisi', 'hilang atau rusak')->count(),
        ]);
    }
}
