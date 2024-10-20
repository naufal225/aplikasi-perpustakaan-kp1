<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Members;
use App\Models\Registrasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function login(Request $request) {
        $credentials = $request->validate([
            "email" => "required|email",
            "password" => "required"
        ], [
            "email.required" => "Masukan Email Anda",
            "email.email" => "Pastikan Email Anda Valid",
            "password.required" => "Masukan Password Anda"
        ]);

        $remember = $request->has('ingatSaya');

        if(Auth::guard("member")->attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return redirect()->intended("/katalog");
        }

        return back()->with("LoginError", "Login Gagal");
    }

    public function logout(Request $request) {
        Auth::guard("member")->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/katalog');
    }

    public function showHistory() {

    }

    public function register(Request $request) {
        $credentials = $request->validate([
            "nama_lengkap" => "required",
            "alamat" => "required",
            "no_telp" =>"required",
            "email" => "required|email",
            "password" => "required|confirmed"
        ], [
            "email.required" => "Masukkan Email Anda",
            "email.email" => "Pastikan Email Anda Valid",
            "password.required" => "Masukkan Password Anda",
            "password.confirmed" => "Password harus terkonfirmasi",
            "nama_lengkap.required" => "Masukkan Nama Lengkap Anda",
            "alamat.required" => "Masukkan Data Alamat Lengkap Anda",
            "no_telp.required" => "Masukkna Nomer Telepon Anda"
        ]);

        $emailTerdaftar = Members::where('email', $request->email)->first();

        $emailPendaftar = Registrasi::where('email', $request->email)->first();

        if(!$emailPendaftar && !$emailTerdaftar) {
            $credentials['password'] = bcrypt($credentials['password']);
            Registrasi::create($credentials);
            return redirect('/katalog')->with("RegisterSuccess", "Registrasi Berhasil, Silahkan menunggu persetujuan dari admin");
        }

        return back()->with("RegisterError", "Registrasi Gagal, Email sudah terpakai");
    }
}
