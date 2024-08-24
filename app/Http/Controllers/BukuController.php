<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('buku.databuku', [
            "buku" => Buku::join('kategori', 'kategori.id', '=', 'buku.id_kategori')
                ->select('buku.*', 'kategori.kategori')
                ->where(function($query) use($request) {
                    $query->where('judul_buku', 'like', "%$request->s%")
                    ->orWhere('penulis', 'like', "%$request->s%")
                    ->orWhere('penerbit', 'like', "%$request->s%")
                    ->orWhere('kategori.kategori', 'like', "%$request->s%");
                })->orderBy('buku.id')->paginate(5)
            ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Membuat kode buku

        $bukuTerakhir = Buku::latest()->first()->kode_buku ?? "B000";

        if($bukuTerakhir) {
            $kodeBuku = preg_replace("/\D/", "", $bukuTerakhir);
            $kodeBuku = intval($kodeBuku) + 1;
            $kodeBuku = str_pad($kodeBuku, 3, "0", STR_PAD_LEFT);
            $kodeBuku = "B" . $kodeBuku;

            return view('buku.tambahbuku', [
                'kodeBuku' => $kodeBuku,
                'kategori' => Kategori::all()
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            "kode_buku" => "required",
            "judul_buku" => "required",
            "slug" => "required|unique:buku",
            "id_kategori" => "required",
            "isbn" => "required",
            "penulis" => "required",
            "penerbit" => "required",
            "harga" => "required",
            "stok" => "required",
            "sinopsis" => "required"
        ]);

        $validate['gambar'] = $request->file('gambar')->store('gambar-buku', 'public');

        Buku::create($validate);

        return redirect('/kelola-data-buku')->with('success', 'Data Buku Berhasil Ditambahkan');
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
        return view("buku.editbuku", [
            "buku" => $buku->first()
        ]);
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

    public function checkSlug(Request $request) 
    {
        $slug = SlugService::createSlug(Buku::class, 'slug', $request->judul);
        
        return response()->json([
            "slug" => $slug
        ]);
    }
}
