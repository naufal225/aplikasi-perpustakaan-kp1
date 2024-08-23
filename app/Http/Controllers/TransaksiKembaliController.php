<?php

namespace App\Http\Controllers;

use App\Models\TransaksiKembali;
use Illuminate\Http\Request;

class TransaksiKembaliController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    return view('transaksi.kembalibuku', [
        "transaksi" => TransaksiKembali::select('transaksi_kembali.*', 'transaksi_pinjam.kode_peminjaman', 'buku.judul_buku')
            ->join('transaksi_pinjam', 'transaksi_pinjam.kode_peminjaman', '=', 'transaksi_pinjam.id')
            ->join('buku', 'transaksi_pinjam.id_buku', '=', 'buku.id')
            ->where(function($query) use ($request) {
                $query->where('transaksi_kembali.kode_pengembalian', 'like', "%{$request->s}%")
                    ->orWhere('transaksi_pinjam.kode_peminjaman', 'like', "%{$request->s}%")
                    ->orWhere('buku.judul_buku', 'like', "%{$request->s}%");
            })
            ->latest()
            ->paginate(5)
    ]);
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
}
