<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\TransaksiKembali;
use App\Models\TransaksiPinjam;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ApiDataChart extends Controller
{
    public function getNumber() {
        $bulan = date("m");
        $tahun = date("Y");

        // Ambil transaksi pengembalian
        $transaksiKembali = DB::table("transaksi_kembali")
            ->select(DB::raw("DATE(tgl_pengembalian) as tanggal, count(*) as jumlah"))
            ->whereMonth('tgl_pengembalian', $bulan)
            ->whereYear('tgl_pengembalian', $tahun)
            ->groupBy(DB::raw("DATE(tgl_pengembalian)"))
            ->groupBy("kode_pengembalian")
            ->get()
            ->keyBy("tanggal");

        // Ambil transaksi peminjaman
        $transaksiPinjam = DB::table("transaksi_pinjam")
            ->select(DB::raw("DATE(tgl_peminjaman) as tanggal, count(*) as jumlah"))
            ->whereMonth('tgl_peminjaman', $bulan)
            ->whereYear('tgl_peminjaman', $tahun)
            ->groupBy(DB::raw("DATE(tgl_peminjaman)"))
            ->groupBy("kode_peminjaman")
            ->get()
            ->keyBy("tanggal");

        // Ambil transaksi yang terlambat
        $keterlambatan = DB::table("transaksi_pinjam")
            ->select(DB::raw("DATE(tgl_peminjaman) as tanggal, count(*) as jumlah"))
            ->whereMonth('tgl_peminjaman', $bulan)
            ->whereYear('tgl_peminjaman', $tahun)
            ->where("status", "telat")
            ->groupBy(DB::raw("DATE(tgl_peminjaman)"))
            ->groupBy("kode_peminjaman")
            ->get()
            ->keyBy("tanggal");

        // Inisialisasi array hasil
        $result = [];

        // Ambil semua tanggal dalam bulan tersebut
        $startDate = Carbon::create($tahun, $bulan, 1);
        $endDate = $startDate->copy()->endOfMonth();

        // Loop dari awal sampai akhir bulan
        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            $tanggal = $date->format("Y-m-d");
            
            // Set nilai default 0 jika tanggal tidak ada di database
            $result[$tanggal] = [
                "jumlahPeminjaman" => $transaksiPinjam[$tanggal]->jumlah ?? 0,
                "jumlahPengembalian" => $transaksiKembali[$tanggal]->jumlah ?? 0,
                "jumlahKeterlambatan" => $keterlambatan[$tanggal]->jumlah ?? 0
            ];
        }

        // Mengembalikan hasil dalam bentuk JSON
        return response()->json($result);
    }
}
