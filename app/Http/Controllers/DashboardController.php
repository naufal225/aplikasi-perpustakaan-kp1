<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\TransaksiKembali;
use App\Models\TransaksiPinjam;

class DashboardController extends Controller
{
    public function index() {
        return view("dashboard", [
            "jumlahBuku" => Buku::count(),
            "jumlahKembali" => TransaksiKembali::count(),
            "jumlahPinjam" => TransaksiPinjam::count(),
            "keterlambatan" => TransaksiPinjam::where("status", "telat")->count()
        ]);
    }
}
