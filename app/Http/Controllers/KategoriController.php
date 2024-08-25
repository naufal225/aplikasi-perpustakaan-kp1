<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        return view("kategori.datakategori", [
            "kategori" => Kategori::whereRaw(
                "kode_kategori like ?
                or kategori like ?", 
                ["%$request->s%", "%$request->s%"]
            )->latest()->paginate(5)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // buat kode kategori

        $kategoriTerakhir = Kategori::latest()->first()->kode_kategori ?? "K000";

        if($kategoriTerakhir) {
            $kategoriTerakhir = preg_filter('/\D/', '', $kategoriTerakhir);
            $kategoriTerakhir = intval($kategoriTerakhir) + 1;
            $kategoriTerakhir = str_pad($kategoriTerakhir, 3, "0", STR_PAD_LEFT);
            $kodeKategori = "K" . $kategoriTerakhir;

            return view('kategori.tambahkategori', [
                'kodeKategori' => $kodeKategori
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'kode_kategori' => 'required',
            'kategori' => 'required',
            'slug' => 'required'
        ]);

        Kategori::create($validate);

        return redirect('/kelola-data-kategori')->with('success', "Kategori baru berhasil ditambahkan");
    }

    /**
     * Display the specified resource.
     */
    public function show(Kategori $kategori)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($slug)
    {
        return view('kategori.editkategori', [
            "kategori" => Kategori::where("slug", $slug)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $slug)
    {
        $kategori = Kategori::where('slug', $slug)->first()->kategori;
        $validate = $request->validate([
            "kategori" => "required"
        ], [
            "kategori.required" => "Masukan nama kategori"
        ]);

        Kategori::where("slug", $slug)->update($validate);

        return redirect('/kelola-data-kategori')->with("success", "Data kategori \"$kategori\" berhasil diperbarui");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($slug)
    {
        $kategori = Kategori::where("slug", $slug);
        $nama = $kategori->first()->kategori;
        $kategori->first()->delete();

        return redirect('/kelola-data-kategori')->with('success', "Data kategori \"$nama\" berhasil dihapus");
    }

    public function checkSlug(Request $request) {
        $slug = SlugService::createSlug(Kategori::class, "slug", $request->kategori);
        return response()->json([
            "slug" => $slug
        ]);
    }
}
