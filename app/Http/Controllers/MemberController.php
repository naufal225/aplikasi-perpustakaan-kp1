<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Members;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('member.datamember', [
            "member" => Members::whereraw(
                "nama_lengkap like ? or
                kode_member like ?
                ", ["%$request->s%", "%$request->s%"]
            )->latest()->paginate(5)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // membuat kode member

        $memberTerakhir = Members::latest()->first()->kode_member ?? "M000";

        if($memberTerakhir) {
            $kodeMember = preg_replace('/\D/', "", $memberTerakhir);
            $kodeMember = intval($kodeMember) + 1;
            $kodeMember = str_pad($kodeMember, 3, "0", STR_PAD_LEFT);
            $kode = "M" . $kodeMember;

            return view('member.tambahmember', [
                "kodeMember" => $kode
            ]);
        }
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validate = $request->validate([
            'kode_member' =>'required',
            'nama_lengkap' => "required",
            'alamat' => 'required',
            'no_telp' => 'required',
            'email' => 'required|email:dns'
        ], [
            'kode_member.required' => 'Masukan kode member',
            'nama_lengkap.required' => 'Masukan nama member',
            'alamat.required' => 'Masukan alamat member',
            'no_telp.required' => 'Masukan no. Telp member',
            'email.required' => 'Masukan email member',
            'email.email' => 'Masukan email yang valid',
        ]);
        

        Members::create($validate);

        return redirect('/kelola-data-member')->with("success", 'Data Member Baru Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Members $members)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Members $members)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Members $members)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Members $members)
    {
        //
    }

    
}
