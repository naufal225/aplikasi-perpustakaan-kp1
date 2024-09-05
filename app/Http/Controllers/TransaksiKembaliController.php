<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Members;
use App\Models\TransaksiKembali;
use App\Models\TransaksiPinjam;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransaksiKembaliController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = TransaksiKembali::select('transaksi_kembali.*', 'transaksi_pinjam.kode_peminjaman', 'buku.judul_buku')
        ->join('transaksi_pinjam', 'transaksi_pinjam.id', '=', 'transaksi_kembali.id_peminjaman')
        ->join('buku', 'transaksi_pinjam.id_buku', '=', 'buku.id')
        ->where(function($q) use ($request) {
            $q->where('transaksi_kembali.kode_pengembalian', 'like', "%$request->s%")
                ->orWhere('transaksi_pinjam.kode_peminjaman', 'like', "%$request->s%")
                ->orWhere('buku.judul_buku', 'like', "%$request->s%");
        });

        if($request->has("tanggal_awal") && $request->has("tanggal_akhir")) {
            $transaksi = $query->whereBetween("transaksi_kembali.tgl_pengembalian", [$request->tanggal_awal, $request->tanggal_akhir]);
        }

        $transaksi = $query->latest()->paginate(5);

        return view('transaksi.kembalibuku', [
            "transaksi" => $transaksi
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('transaksi.tambahtransaksipengembalian');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // Mendapatkan id buku terkait dan id peminjaman terkait
    $id_buku = Buku::where("kode_buku", $request->kode_buku)->first()->id;
    $id_peminjaman = TransaksiPinjam::where("kode_peminjaman", $request->kode_peminjaman)
                     ->where("id_buku", $id_buku)->first()->id;

    // Menyimpan transaksi pengembalian
    $tgl_default = Carbon::today()->format("ymd");
    $transaksiTerakhir = TransaksiKembali::whereDate("tgl_pengembalian", Carbon::today())->latest()->first() ?? "TRK24" . $tgl_default . "000";
    
    if ($transaksiTerakhir != "TRK" . $tgl_default . "000") {
        $jumlahTransaksiTerakhir = TransaksiKembali::whereDate("tgl_pengembalian", Carbon::today())->count() + 1;
        $jumlahTransaksiTerakhir = str_pad($jumlahTransaksiTerakhir, 3, "0", STR_PAD_LEFT);
        $kodeTransaksi = "TRK" . Carbon::today()->format("ymd") . $jumlahTransaksiTerakhir;
    } else {
        $kodeTransaksi = "TRK" . Carbon::today()->format("ymd") . "001";
    }

    TransaksiKembali::create([
        "kode_pengembalian" => $kodeTransaksi,
        "tgl_pengembalian" => Carbon::today()->format("ymd"),
        "id_peminjaman" => $id_peminjaman,
        "kondisi" => "baik",
        "status" => "belum telat",
    ]);

    TransaksiPinjam::where("kode_peminjaman", $request->kode_peminjaman)
        ->where("id_buku", $id_buku)
        ->update([
            "status" => "belum telat",
            "keterangan" => "selesai"
        ]);

    Buku::where("kode_buku", $request->kode_buku)
        ->increment('stok');

    // if ($request->ajax()) {
    // }
    
    return response()->json(['success' => true]);
    // return redirect("/transaksi/kembali-buku/create")->with("success", "Transaksi pengembalian baru berhasil dibuat");
}


    /**
     * Display the specified resource.
     */
    public function show(TransaksiKembali $transaksiKembali)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TransaksiKembali $transaksiKembali)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TransaksiKembali $transaksiKembali)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TransaksiKembali $transaksiKembali)
    {
        //
    }

    public function cariTransaksiPinjam(Request $request) {
        $transaksiPinjam = TransaksiPinjam::where("kode_peminjaman", $request->kode_peminjaman)->first();
    
        if(!$transaksiPinjam) {
            return redirect()->back()->with("gagal", "Transaksi peminjaman tidak ada");
        }

        $transaksiPinjam = TransaksiPinjam::where("kode_peminjaman", $request->kode_peminjaman)->where("keterangan", "belum selesai")->get();
        
        if(!count($transaksiPinjam)) {
            return redirect()->back()->with("success", "Transaksi peminjaman sudah selesai");
        }
        
        $kode_member = Members::where("id", $transaksiPinjam[0]->id_member)->first()->kode_member;

        $data = [];

        foreach($transaksiPinjam as $transaksi) {
            $buku = Buku::where("id", $transaksi->id_buku)->first();
            $data[] = [
                "kode_buku" => $buku->kode_buku,
                "judul_buku" => $buku->judul_buku,
                "status" => $transaksi->status,
            ];
        }
        
        // dd($data[0]);
        
        return redirect()->back()->with([
            "kode_peminjaman" => $transaksi->kode_peminjaman,
            "kode_member" => $kode_member,
            "data_peminjaman" => $data
        ]);
    }
}
