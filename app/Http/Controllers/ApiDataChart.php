<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\TransaksiKembali;
use App\Models\TransaksiPinjam;

class ApiDataChart extends Controller
{
    public function getNumber() {
        return response()->json(
            [
                "jumlahTransaksiKembali" => TransaksiKembali::count(),
                "jumlahTransaksiPinjam" => TransaksiPinjam::count(),
                "jumlahBuku" => Buku::count(),
                "jumlahKeterlambatan" => TransaksiPinjam::where("status", "telat")->count()
            ]
        );
    }
}
