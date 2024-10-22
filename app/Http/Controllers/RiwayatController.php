<?php

namespace App\Http\Controllers;

use App\Models\RateBuku;
use App\Models\TransaksiPinjam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    public function index() {
        // Ambil semua transaksi pinjam yang berkaitan dengan member yang sedang login
        $data = TransaksiPinjam::with('buku')->where('id_member', Auth::guard("member")->id())->get();
        
        // Tambahkan pengecekan rating
        foreach ($data as $item) {
            $item['rating_ada'] = RateBuku::where('id_member', Auth::guard("member")->id())
                                         ->where('id_buku', $item->id_buku)
                                         ->exists();
        }

        return view('katalog.riwayat', [
            "data" => $data
        ]);
    }
}
