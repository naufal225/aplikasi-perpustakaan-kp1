<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PustakawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('pustakawan.datapustakawan', [
            "pustakawan" => User::where('admin', 0)
                ->where(function ($query) use ($request) {
                    $query->where('nama_lengkap', 'like', "%{$request->s}%")
                          ->orWhere('kode_petugas', 'like', "%{$request->s}%")
                          ->orWhere('email', 'like', "%{$request->s}%");
                })
                ->latest()
                ->paginate(5)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // membuat kode pustakawan

        $pustakawanTerakhir = User::where('admin', 0)->latest()->first()->kode_petugas ?? "P000";

        if($pustakawanTerakhir) {
            $kodePustakawan = preg_filter('/\D/', '', $pustakawanTerakhir);
            $kodePustakawan = intval($kodePustakawan) + 1;
            $kodePustakawan = str_pad($kodePustakawan, 3, '0', STR_PAD_LEFT);
            $kodePustakawan = "P" . $kodePustakawan;

            return view('pustakawan.tambahpustakawan', [
                'kodePustakawan' => $kodePustakawan
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'kode_petugas' => 'required|unique:users',
            'nama_lengkap' => 'required',
            'alamat' => 'required',
            'no_telp' => 'required',
            'email' => 'required|email:dns',
            'password' => 'required|confirmed'
        ]);

        User::create($validate);

        return redirect('/kelola-data-pustakawan')->with('success', 'Pustakawan baru berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view("edit.editpustakawan", [
            "pustakawan" => $user->first()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
