<?php

namespace App\Http\Controllers;

use App\Models\TransaksiPinjam;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use App\Models\Buku;
use App\Models\Members;
class TransaksiPinjamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = TransaksiPinjam::select("transaksi_pinjam.*", "buku.judul_buku", "members.nama_lengkap")
        ->join('buku', 'transaksi_pinjam.id_buku', '=', 'buku.id')
        ->join('members', "transaksi_pinjam.id_member", '=', 'members.id')
        ->where(function($q) use($request) {
            $q->where("transaksi_pinjam.kode_peminjaman", "like", "%$request->s%")
                  ->orWhere("members.nama_lengkap", "like", "%$request->s%")
                  ->orWhere("buku.judul_buku", "like", "%$request->s%");
        });

        if($request->has("tanggal_awal") && $request->has("tanggal_akhir")) {
            $transaksi = $query->whereBetween("tgl_peminjaman", [$request->tanggal_awal, $request->tanggal_akhir]);
        }

        $transaksi = $query->latest()->paginate(5);

        return view('transaksi.pinjambuku', [
            "transaksi" => $transaksi
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!session()->has('kode_buku') || count(session('kode_buku')) === 0) {
            // Hapus session 'kode_member'
            session()->forget('kode_member');
        }

        $tgl_default = Carbon::today()->format("ymd");

        $transaksiTerakhir = TransaksiPinjam::whereDate("tgl_peminjaman", Carbon::today())->latest()->first() ?? "TRP" . $tgl_default . "000";
        
        if($transaksiTerakhir) {
            if($transaksiTerakhir != "TRP" . $tgl_default . "000") {
                $jumlahTransaksiTerakhir = TransaksiPinjam::whereDate("tgl_peminjaman", Carbon::today())->count() + 1;
                $jumlahTransaksiTerakhir = str_pad($jumlahTransaksiTerakhir, 3, "0", STR_PAD_LEFT);
                $kodeTransaksi = "TRP" . Carbon::today()->format("ymd") . $jumlahTransaksiTerakhir;
            } else {
                $kodeTransaksi = "TRP" . Carbon::today()->format("ymd") . "001";
            }
        }

        return view('transaksi.tambahtransaksipinjam', [
            "kode_peminjaman" => $kodeTransaksi
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Ambil nilai kode member dari session
        $kode_member = session("kode_member");
    
        // Ambil id member berdasar kode member
        $id_member = Members::where("kode_member", $kode_member)->first()->id;
    
        // Ambil nilai kode transaksi dari session
        $kode_transaksi = session("kode_peminjaman");
    
        // Insert ke tabel transaksi pinjam dengan perulangan pada session kode buku
        if(session()->has("kode_buku")) {
            foreach(session("kode_buku") as $buku) {
                // Ambil id buku
                $bukuObj = Buku::where("kode_buku", $buku->kode_buku)->first();
            
                // Cek apakah buku ditemukan
                if(!$bukuObj) {
                    return redirect()->back()->with("gagal", "Buku dengan kode $buku->kode_buku tidak ditemukan");
                }
            
                $id_buku = $bukuObj->id;
            
                // Lanjutkan dengan insert ke TransaksiPinjam
                TransaksiPinjam::create([
                    "kode_peminjaman" => $kode_transaksi,
                    "id_member" => $id_member,
                    "id_buku" => $id_buku,
                    "status" => "belum telat",
                    "keterangan" => "belum selesai",
                    "tgl_peminjaman" => date("Y-m-d"),
                    "estimasi_tgl_kembali" => date("Y-m-d", strtotime(date("Y-m-d") . " + 7 days"))
                ]);

                // Mengurangi stok di buku terkait
                $stokSekarang = $bukuObj->stok;
                $stokSekarang--;
                $bukuObj->update([
                    "stok" => $stokSekarang
                ]);
            }
        }

        // Menghapus data session untuk cart

        session()->forget(['kode_member', 'kode_buku', 'kode_peminjaman']);
    
        // Redirect back ke page sebelumnya sambil mengirim pesan sukses
        return redirect("/transaksi/pinjam-buku")->with("success", "Berhasil menambahkan transaksi");
    }
    

    /**
     * Display the specified resource.
     */
    public function show(TransaksiPinjam $transaksiPinjam)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TransaksiPinjam $transaksiPinjam)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TransaksiPinjam $transaksiPinjam)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TransaksiPinjam $transaksiPinjam)
    {
        //
    }

    public function updateStatus() {
        $transaksi = TransaksiPinjam::all();
        $today = now()->toDateString();

        foreach($transaksi as $row) {
            if($row->estimasi_tgl_kembali < $today && $row->keterangan != "selesai") {
                $row->status = "telat";
                $row->save();
            }
        }
    }

    public function tambahTransaksi(Request $request) {
        $rule = [
            "kode_buku" => "required"
        ];
    
        $pesan = [
            "kode_buku.required" => "Masukan kode buku"
        ];
    
        if(!session()->has("kode_member")) {
            $rule += [
                "kode_member" => "required"
            ];
    
            $pesan += [
                "kode_member.required" => "Masukan kode member"
            ];
        }
    
        $validate = $request->validate($rule, $pesan);

        // Mengecek apakah member terkait memiliki transaksi yang belum selesai

        // Mengambil id member

        $id_member = Members::where("kode_member", $request->kode_member)->first();
        $id_member = $id_member->id;

        // di cek dulu gess...
        $transaksi = TransaksiPinjam::where("id_member", $id_member)->where("keterangan", "belum selesai")->latest()->first();

        // kalau ada
        if($transaksi) {
            return redirect()->back()->with("gagal", "Member $request->kode_member memiliki transaksi yang belum selesai");
        }

        // kalau nggak lanjut...

        
        if(count(session("kode_buku", [])) > 2) {
            return redirect()->back()->with("gagal", "Buku sudah ada 2 yang di cart");
        }
        
        // Ambil data buku dari database
        $buku = Buku::where('kode_buku', $request->kode_buku)->first();
        // Mengecek jika buku tidak ada
        if(!$buku) {
            return redirect()->back()->with("gagal", "Gagal, Buku tidak ditemukan");
        }   
    
        // Mengecek jika member tidak ada hanya jika kode_member dikirimkan
        if($request->has("kode_member")) {
            $member = Members::where("kode_member", $request->kode_member)->first();
            if(!$member) {
                return redirect()->back()->with("gagal", "Gagal, Member tidak ditemukan");
            }
            // Simpan kode member dalam session jika valid
            session()->put("kode_member", $request->kode_member);
        }
    
        // Cek jika buku sudah ada di session
        $kodeBukuInSession = array_column(session("kode_buku", []), 'kode_buku');
        if (in_array($request->kode_buku, $kodeBukuInSession)) {
            return redirect()->back()->with("gagal", "Gagal, Buku sudah ada di cart");
        }
    
        // Simpan data buku lengkap dalam session
        session()->push("kode_buku", $buku);

        // Simpan data kode transaksi peminjaman
        session()->put("kode_peminjaman", $request->kode_peminjaman);

        // Simpan data kode member
        session()->put("kode_member", $request->kode_member);
        
        return redirect()->back();
    }
    
    public function hapusItem($kode_buku)
    {
        $items = session()->get('kode_buku', []);
        $filtered = array_filter($items, function ($item) use ($kode_buku) {
            return $item['kode_buku'] != $kode_buku;
        });
        
        session()->put('kode_buku', array_values($filtered));  // Ensure the array is re-indexed
        
        return redirect()->back()->with('success', 'Item berhasil dihapus dari keranjang.');
    }
}
