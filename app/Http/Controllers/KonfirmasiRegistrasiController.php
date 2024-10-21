<?php

namespace App\Http\Controllers;

use App\Models\Registrasi;
use Illuminate\Http\Request;

class KonfirmasiRegistrasiController extends Controller
{
    public function index(Request $request) {
        $data = Registrasi::whereRaw("nama_lengkap like ?", ["%$request->s%"])->latest()->paginate(5);
        return view("member.acc", [
            "data" => $data
        ]);
    }
}
