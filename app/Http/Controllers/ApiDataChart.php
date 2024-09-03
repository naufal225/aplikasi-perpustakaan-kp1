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
        $bulan = date("m");
        $tahun = date("Y");

        $transaksiKembali = DB::table("transaksi_kembali")
            ->select(DB::raw("DATE(tgl_pengembalian) as tanggal, count(*) as jumlah"))
            ->whereMonth('tgl_pengembalian', $bulan)
            ->whereYear('tgl_pengembalian', $tahun)
            ->groupBy(DB::raw("DATE(tgl_pengembalian)"))
            ->groupBy("kode_pengembalian")
            ->get()
            ->keyBy("tanggal");

        $transaksiPinjam = DB::table("transaksi_pinjam")
            ->select(DB::raw("DATE(tgl_peminjaman) as tanggal, count(*) as jumlah"))
            ->whereMonth('tgl_peminjaman', $bulan)
            ->whereYear('tgl_peminjaman', $tahun)
            ->groupBy(DB::raw("DATE(tgl_peminjaman)"))
            ->groupBy("kode_peminjaman")
            ->get()
            ->keyBy("tanggal");

        $keterlambatan = DB::table("transaksi_pinjam")
            ->select(DB::raw("DATE(tgl_peminjaman) as tanggal, count(*) as jumlah"))
            ->whereMonth('tgl_peminjaman', $bulan)
            ->whereYear('tgl_peminjaman', $tahun)
            ->where("status", "telat")
            ->groupBy(DB::raw("DATE(tgl_peminjaman)"))
            ->groupBy("kode_peminjaman")
            ->get()
            ->keyBy("tanggal");
            
            // dd($transaksiPinjam["2024-09-03"]->jumlah);

        $result = [];

        $allDates = $transaksiKembali->keys()
            ->merge($transaksiPinjam->keys())
            ->merge($keterlambatan->keys())
            ->unique()->sort();

        foreach($allDates as $tanggal) {
            $result[$tanggal] = [
                "jumlahPeminjaman" => $transaksiPinjam[$tanggal]->jumlah ?? 0,
                "jumlahPengembalian" => $transaksiKembali[$tanggal]->jumlah ?? 0,
                "jumlahKeterlambatan" => $keterlambatan[$tanggal]->jumlah ?? 0
            ];
        }


        return response()->json($result);
        
    }
}
