<?php

namespace App\Http\Controllers;

use App\Models\Members;
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

    public function acc(Request $request) {
        // ambil data request nya
        $idregistrasi = $request->id;
        $registrasi = Registrasi::find($idregistrasi);

        // ubah status registrasi jadi acc
        if($registrasi) {
            $registrasi->update(['acc' => 'acc']);
        }

        $nama_lengkap = $registrasi->nama_lengkap;
        $alamat = $registrasi->alamat;
        $no_telp = $registrasi->no_telp;
        $email = $registrasi->email;
        $password = $registrasi->password;

        // buat kode member

        $memberTerakhir = Members::latest()->first()->kode_member ?? "M000";

        if($memberTerakhir) {
            $kodeMember = preg_replace('/\D/', "", $memberTerakhir);
            $kodeMember = intval($kodeMember) + 1;
            $kodeMember = str_pad($kodeMember, 3, "0", STR_PAD_LEFT);
            $kode = "M" . $kodeMember;
        }

        // simpan data member baru

        Members::create([
            "nama_lengkap" => $nama_lengkap,
            "alamat" => $alamat,
            "no_telp" => $no_telp,
            "email" => $email,
            "password" => $password,
            "kode_member" => $kode
        ]);


        // redirect back dengan registrasi success
        return back()->with("accRegistrasiSuccess", "Berhasil Menambahkan Member Baru");
    }

    public function tolak(Request $request) {
        // ambil data request nya
        $idregistrasi = $request->id;
        $registrasi = Registrasi::find($idregistrasi);
        // ubah status nya jadil ditolak
        if($registrasi) {
            $registrasi->update(['acc' => 'ditolak']);
        }
        // return redirect with accRegistrasiNotSuccess
        return back()->with("accRegistrasiNotSuccess", "Registrasi tidak disetujui, Member tidak ditambahkan");
    }
}
