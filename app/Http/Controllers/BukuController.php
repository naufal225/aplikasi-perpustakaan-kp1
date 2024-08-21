<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('databuku', [
            "buku" => Buku::whereRaw(
                "
                kode_buku like ? 
                or judul_buku like ?
                or isbn like ? 
                or penerbit like ?
                or penulis like ?
                ", ["%$request->s%", "%$request->s%", "%$request->s%", "%$request->s%", "%$request->s%"]
            )->latest()->paginate(5)
            ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Membuat kode buku

        $bukuTerakhir = Buku::latest()->first()->kode_buku;

        if($bukuTerakhir) {
            $kodeBuku = preg_replace("/\D/", "", $bukuTerakhir);
            $kodeBuku = intval($kodeBuku) + 1;
            $kodeBuku = str_pad($kodeBuku, 3, "0", STR_PAD_LEFT);
            $kodeBuku = "M" . $kodeBuku;

            return view('tambahbuku', [
                'kodeBuku' => $kodeBuku
            ]);
        }

        return view('tambahbuku', [
            'kodeBuku' => "M001"
        ]);
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
    public function show(Buku $buku)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Buku $buku)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Buku $buku)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Buku $buku)
    {
        //
    }
}
