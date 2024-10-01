<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Members;
use App\Models\TransaksiKembali;
use App\Models\TransaksiPinjam;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransaksiKembaliController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = TransaksiKembali::select('transaksi_kembali.*', 'transaksi_pinjam.kode_peminjaman', 'buku.judul_buku')
        ->join('transaksi_pinjam', 'transaksi_pinjam.id', '=', 'transaksi_kembali.id_peminjaman')
        ->join('buku', 'transaksi_pinjam.id_buku', '=', 'buku.id')
        ->where(function($q) use ($request) {
            $q->where('transaksi_kembali.kode_pengembalian', 'like', "%$request->s%")
                ->orWhere('transaksi_pinjam.kode_peminjaman', 'like', "%$request->s%")
                ->orWhere('buku.judul_buku', 'like', "%$request->s%");
        });

        if($request->has("tanggal_awal") && $request->has("tanggal_akhir")) {
            $transaksi = $query->whereBetween("transaksi_kembali.tgl_pengembalian", [$request->tanggal_awal, $request->tanggal_akhir]);
        }

        $transaksi = $query->latest()->paginate(5);

        return view('transaksi.kembalibuku', [
            "transaksi" => $transaksi
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('transaksi.tambahtransaksipengembalian');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Check if any books were selected for return
        if (!$request->has(key: 'kembali') || empty($request->input('kembali'))) {
            return redirect()->back()->with("gagal", "Anda tidak mencentang 1 buku pun");
        }

        foreach ($request->input('kembali') as $kode_buku) {
            // Mendapatkan id buku terkait dan id peminjaman terkait
            // dd($request->input('kondisi')[$kode_buku]);

            $id_buku = Buku::where("kode_buku", $kode_buku)->first()->id;
            $transaksiPinjam = TransaksiPinjam::where("kode_peminjaman", $request->kode_peminjaman)
                ->where("id_buku", $id_buku)->first();
    
            if (!$transaksiPinjam) {
                return redirect()->back()->with("gagal", "Data peminjaman tidak ditemukan untuk kode buku: $kode_buku");
            }
    
            $id_peminjaman = $transaksiPinjam->id;
    
            // Menyimpan transaksi pengembalian
            $tgl_default = Carbon::today()->format("ymd");
            $transaksiTerakhir = TransaksiKembali::whereDate("tgl_pengembalian", Carbon::today())->latest()->first() ?? "TRK24" . $tgl_default . "000";
    
            if ($transaksiTerakhir != "TRK" . $tgl_default . "000") {
                $jumlahTransaksiTerakhir = TransaksiKembali::whereDate("tgl_pengembalian", Carbon::today())->count() + 1;
                $jumlahTransaksiTerakhir = str_pad($jumlahTransaksiTerakhir, 3, "0", STR_PAD_LEFT);
                $kodeTransaksi = "TRK" . Carbon::today()->format("ymd") . $jumlahTransaksiTerakhir;
            } else {
                $kodeTransaksi = "TRK" . Carbon::today()->format("ymd") . "001";
            }
    
            $kondisi = $request->input('kondisi')[$kode_buku] ? $request->input('kondisi')[$kode_buku] : "hilang atau rusak";
            $status = $request->input('status');

            // dd($kondisi);
    
            // Simpan transaksi pengembalian
            TransaksiKembali::create([
                "id_buku" => $id_buku,
                "kode_pengembalian" => $kodeTransaksi,
                "tgl_pengembalian" => Carbon::today()->format("ymd"),
                "id_peminjaman" => $id_peminjaman,
                "kondisi" => $kondisi,
                "status" => $status,
            ]);
    
            // Update status transaksi peminjaman
            TransaksiPinjam::where("kode_peminjaman", $request->kode_peminjaman)
                ->where("id_buku", $id_buku)
                ->update([
                    "status" => $status,
                    "keterangan" => "selesai"
                ]);
    
            // Update stok buku jika kondisi baik
            if ($kondisi === 'baik') {
                Buku::where("kode_buku", $kode_buku)
                    ->increment('stok');
            }
    
            // Handle denda jika buku rusak atau hilang
            // if ($kondisi === 'rusak atau hilang') {
            //     // Logika pembayaran denda
            //     // Redirect ke halaman pembayaran denda atau logika lainnya
            //     return view("transaksi.denda");
            // }
        }
    
        // // Generate struk pengembalian
        // $struk = [
        //     'kode_pengembalian' => $kodeTransaksi,
        //     'nama_perpustakaan' => 'Nama Perpustakaan',
        //     'alamat_perpustakaan' => 'Alamat Perpustakaan',
        //     'nama_anggota' => Members::find($transaksiPinjam->id_member)->nama,
        //     'kode_member' => Members::find($transaksiPinjam->id_member)->kode_member,
        //     'buku_dikembalikan' => implode(', ', $request->input('kembali')),
        //     'denda' => $kondisi === 'rusak atau hilang' ? 'Rp. xxxx' : 'Tidak ada denda',
        // ];
    
        // Menyimpan struk atau menampilkan ke user
        // Logika struk
    
        return redirect()->back()->with("success", "Transaksi Peminjaman Berhasil Ditambahkan");

        // return view("")->with([
        //     "success" => true,
        //     "struk" => $struk
        // ]);
    }
    
    public function cetakStruk(Request $request) {

    }


    /**
     * Display the specified resource.
     */
    public function show(TransaksiKembali $transaksiKembali)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TransaksiKembali $transaksiKembali)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TransaksiKembali $transaksiKembali)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TransaksiKembali $transaksiKembali)
    {
        //
    }

    public function cariTransaksiPinjam(Request $request) {
        $transaksiPinjam = TransaksiPinjam::where("kode_peminjaman", $request->kode_peminjaman)->first();
    
        if(!$transaksiPinjam) {
            return redirect()->back()->with("gagal", "Transaksi peminjaman tidak ada");
        }

        $transaksiPinjam = TransaksiPinjam::where("kode_peminjaman", $request->kode_peminjaman)->where("keterangan", "belum selesai")->get();
        
        if(!count($transaksiPinjam)) {
            return redirect()->back()->with("success", "Transaksi peminjaman sudah selesai");
        }
        
        $kode_member = Members::where("id", $transaksiPinjam[0]->id_member)->first()->kode_member;

        $data = [];

        foreach($transaksiPinjam as $transaksi) {
            $buku = Buku::where("id", $transaksi->id_buku)->first();
            $data[] = [
                "kode_buku" => $buku->kode_buku,
                "judul_buku" => $buku->judul_buku,
                "status" => $transaksi->status,
            ];
        }
        
        
        return redirect()->back()->with([
            "kode_peminjaman" => $transaksi->kode_peminjaman,
            "kode_member" => $kode_member,
            "data_peminjaman" => $data
        ]);
    }

    public function reportpdf() {
        // Ambil semua data transaksi
        $data = TransaksiKembali::with(['member', 'buku'])->get();

        // Buat array berisi data
        $dataReport = [
            'nama_perpustakaan' => 'Perpustakaan 123',
            'alamat_perpustakaan' => 'Jl. Meranti Raya No.3, Desa Setia Mekar, Kec. Tambun Selatan, Kab. Bekasi, Jawa Barat, 17510',
            'tanggal_jam' => now(),
            'data' => $data,
        ];

        $pdf = PDF::loadView('transaksi.reportKembali', $dataReport);

        // Return 

        return $pdf->download('laporan-pengembalian.pdf');
    }
}
