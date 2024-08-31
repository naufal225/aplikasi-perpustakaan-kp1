<?php

namespace App\Http\Controllers;

use App\Models\Members;
use App\Models\TransaksiKembali;
use App\Models\TransaksiPinjam;
use Illuminate\Http\Request;

class TransaksiKembaliController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = TransaksiKembali::select('transaksi_kembali.*', 'transaksi_pinjam.kode_peminjaman', 'buku.judul_buku')
        ->join('transaksi_pinjam', 'transaksi_pinjam.kode_peminjaman', '=', 'transaksi_pinjam.id')
        ->join('buku', 'transaksi_pinjam.id_buku', '=', 'buku.id')
        ->where(function($query) use ($request) {
            $query->where('transaksi_kembali.kode_pengembalian', 'like', "%{$request->s}%")
                ->orWhere('transaksi_pinjam.kode_peminjaman', 'like', "%{$request->s}%")
                ->orWhere('buku.judul_buku', 'like', "%{$request->s}%");
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
        //
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
        $transaksiPinjam = TransaksiPinjam::where("kode_peminjaman", $request->kode_peminjaman)->all();
        
    }
}
