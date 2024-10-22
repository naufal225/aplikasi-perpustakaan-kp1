<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\RateBuku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RateBukuController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'id_buku' => 'required|exists:buku,id',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        RateBuku::updateOrCreate(
            [
                'id_member' => Auth::guard("member")->id(),
                'id_buku' => $request->id_buku,
            ],
            [
                'rating' => $request->rating,
            ]
        );

        $buku = Buku::find($request->id_buku);
        if ($buku) {
            $buku->calculateRating(); // Panggil method untuk menghitung rating
        }

        return redirect()->back()->with('success', 'Berhasil menambahkan rating buku');
    }
}
