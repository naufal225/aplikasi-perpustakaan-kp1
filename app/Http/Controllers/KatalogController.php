<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class KatalogController extends Controller
{
    public function index() {
        return view("katalog.katalog", [
            "data" => Buku::all()
        ]);
    }

    public function show(Request $request) {
        return view("katalog.detail", [
            "buku" => Buku::where('judul_buku', $request->judul)->first()
        ]);
    }

    public function search(Request $request) {
        $buku = Buku::where("judul_buku", "like", "%{$request->judul_buku}%")->get();
        $data = [];

        if($buku) {
            $data[] = [
                "success" => true,
                "data" => $buku,
                "message" => "Data buku berhasil ditemukan"
            ];
        } else {
            $data[] = [
                "success" => false,
                "message" => "Data buku tidak ada..."
            ];
        }

        return response()->json($data, 200);
    }
}
