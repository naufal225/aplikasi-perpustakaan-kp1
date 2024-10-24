<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Members;
use App\Models\Registrasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
    
        // Cek apakah data email ada di database
        $member = Members::where('email', $request->email)->first();
        if (!$member) {
            return back()->with("LoginError", "Email tidak ditemukan.");
        }
    
        // Debugging: Cek password yang diinput dan hash di DB
        if (!Hash::check($request->password, $member->password)) {
            return back()->with("LoginError", "Password tidak sesuai.");
        }
    
        // Lanjutkan jika password benar
        if(Auth::guard("member")->attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended("/katalog");
        }
    
        return back()->with("LoginError", "Login Gagal");
    }

    public function logout(Request $request) {
        // Hanya logout guard "member"
        Auth::guard("member")->logout();
    
        // Regenerate token untuk mencegah session fixation, hanya regenerasi session untuk member
        $request->session()->forget('member_guard'); // Menghapus session yang berhubungan dengan guard member
        $request->session()->regenerateToken();
    
        // Redirect setelah logout member, admin tetap login
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
            "no_telp.required" => "Masukkan Nomer Telepon Anda"
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
