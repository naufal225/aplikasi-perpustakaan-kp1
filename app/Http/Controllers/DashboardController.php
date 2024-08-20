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
        return view("dashboard", [
            "jumlahBuku" => Buku::count(),
            "jumlahKembali" => TransaksiKembali::whereRaw("datediff(tgl_pengembalian, curdate())")->count(),
            "jumlahPinjam" => TransaksiPinjam::whereRaw("datediff(tgl_peminjaman, curdate())")->count(),
            "keterlambatan" => TransaksiPinjam::whereRaw("datediff(tgl_peminjaman, curdate()) and status = 'telat'")->count(),
            "hilangAtauRusak" => TransaksiKembali::whereRaw("datediff(tgl_pengembalian, curdate()) and kondisi = 'hilang atau rusak'")->count(),
        ]);
    }
}
