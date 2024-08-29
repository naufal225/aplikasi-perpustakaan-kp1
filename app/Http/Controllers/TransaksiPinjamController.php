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
        ->where(function($query) use($request) {
            $query->where("transaksi_pinjam.kode_peminjaman", "like", "%$request->s%")
                  ->where("members.nama_lengkap", "like", "%$request->s%")
                  ->where("buku.judul_buku", "like", "%$request->s%");
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

        $transaksiTerakhir = TransaksiPinjam::whereDate("tgl_peminjaman", Carbon::today())->latest()->first() ?? "TRP240826000";
        
        if($transaksiTerakhir) {
            if($transaksiTerakhir != "TRP240826000") {
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
        //
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
        $validate = $request->validate([
            "kode_member" => "required",
            "kode_buku" => "required",
        ]);
        
        if(count(session("kode_buku", [])) > 2) {
            return redirect()->back()->with("gagal", "Buku sudah ada 2 yang di cart");
        }
        
        // Ambil data buku dari database
        $buku = Buku::where('kode_buku', $request->kode_buku)->first();
        // Mengecek jika buku tidak ada
        if(!$buku) {
            return redirect()->back()->with("gagal", "Gagal, Buku tidak ditemukan");
        }
        // Mengecek jika member tidak ada
        $member = Members::where("kode_member", $request->kode_member)->first();
        if(!$member) {
            return redirect()->back()->with("gagal", "Gagal, Member tidak ditemukan");
        }

        foreach(session("kode_buku") as $buku) {
            if($request->kode_buku == $buku->kode_buku) {
                return redirect()->back()->with("gagal", "Gagal, Buku sudah ada di cart");
            }
        }
    
        // Simpan kode member dalam session
        session()->put("kode_member", $request->kode_member);
    
        // Simpan data buku lengkap dalam session
        session()->push("kode_buku", $buku);
        
        return redirect("/transaksi/tambah-transaksi-pinjam");
    }

    public function hapusItem($kode_buku)
    {
        $items = session()->get('kode_buku', []);
        $filtered = array_filter($items, function ($item) use ($kode_buku) {
            return $item->kode_buku != $kode_buku;
        });
        
        session()->put('kode_buku', $filtered);
        
        return redirect()->back()->with('success', 'Item berhasil dihapus dari keranjang.');
    }
    
}
