<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\TransaksiKembali;
use App\Models\TransaksiPinjam;
use Illuminate\Support\Facades\DB;

class ApiDataChart extends Controller
{
    public function getNumber() {
        $transaksiKembali = DB::table("transaksi_kembali")
            ->select(DB::raw("DATE(tgl_pengembalian) as tanggal, count(*) as jumlah"))
            ->groupBy("tanggal")
            ->get()
            ->keyBy("tanggal");

        $transkasiPinjam = DB::table("transaksi_pinjam")
            ->select(DB::raw("DATE(tgl_peminjaman) as tanggal, count(*) as jumlah"))
            ->groupBy("tanggal")
            ->get()
            ->keyBy("tanggal");

        $keterlambatan = DB::table("transaksi_pinjam")
            ->select(DB::raw("DATE(tgl_peminjaman) as tanggal, count(*) as jumlah"))
            ->where("status", "telat")
            ->groupBy("tanggal")
            ->get()
            ->keyBy("tanggal");

        $result = [];

        $allDates = $transaksiKembali->keys()
            ->merge($transkasiPinjam->keys())
            ->merge($keterlambatan->keys())
            ->unique()->sort();

        foreach($allDates as $tanggal) {
            $result[$tanggal] = [
                "jumlahPeminjaman" => $transkasiPinjam[$tanggal]->jumlah ?? 0,
                "jumlahPengembalian" => $transaksiKembali[$tanggal]->jumlah ?? 0,
                "jumlahKeterlambatan" => $keterlambatan[$tanggal]->jumlah ?? 0
            ];
        }

        return response()->json($result);
        
    }
}
