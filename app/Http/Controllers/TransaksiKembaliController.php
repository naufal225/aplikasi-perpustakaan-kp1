<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Members;
use App\Models\TransaksiKembali;
use App\Models\TransaksiPinjam;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Number;

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

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween("tgl_peminjaman", [$request->tanggal_awal, $request->tanggal_akhir]);
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

        $kodeTransaksi = "";

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

        foreach ($request->input('kembali') as $kode_buku) {
            // Mendapatkan id buku terkait dan id peminjaman terkait
            // dd($request->input('kondisi')[$kode_buku]);
            $denda_hilang_atau_rusak = 0;
            $denda_keterlambatan = 0;

            $id_buku = Buku::where("kode_buku", $kode_buku)->first()->id;
            $transaksiPinjam = TransaksiPinjam::where("kode_peminjaman", $request->kode_peminjaman)
                ->where("id_buku", $id_buku)->first();
    
            if (!$transaksiPinjam) {
                return redirect()->back()->with("gagal", "Data peminjaman tidak ditemukan untuk kode buku: $kode_buku");
            }
    
            $id_peminjaman = $transaksiPinjam->id;
    
            $kondisi = $request->input('kondisi')[$kode_buku] ? $request->input('kondisi')[$kode_buku] : "hilang atau rusak";
            $status = $request->input('status');

            // dd($kondisi);

            // Mengecek telat atau tidak dengan melihat status nya
            if($status != "belum telat") {
                // Menghitung denda keterlambatan
                $tanggalSekarang = Carbon::now(); // Mendapatkan tanggal sekarang
                $estimasiKembali = Carbon::parse($transaksiPinjam->estimasi_tgl_kembali); // Mengonversi string ke objek Carbon
                
                // Menghitung selisih hari
                $selisihHari = $tanggalSekarang->diffInDays($estimasiKembali);

                if($selisihHari > 0) {
                    $denda_keterlambatan = $selisihHari * 1000;
                }
            }

            // Mengecek kondisi
            if($kondisi != "baik") {
                // Menghitung denda hilang atau rusak
                $denda_hilang_atau_rusak = Buku::find($id_buku)->harga;
            }

    
            // Simpan transaksi pengembalian
            TransaksiKembali::create([
                "id_buku" => $id_buku,
                "kode_pengembalian" => $kodeTransaksi,
                "tgl_pengembalian" => now()->format('Y-m-d H:i:s'),
                "id_peminjaman" => $id_peminjaman,
                "kondisi" => $kondisi,
                "denda_keterlambatan" => $denda_keterlambatan,
                "denda_hilang_atau_rusak" => $denda_hilang_atau_rusak,
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

        // Ambil data transaksi untuk PDF
        $transaksi = TransaksiKembali::where('kode_pengembalian', $kodeTransaksi)->with('buku')->get();
        
        if ($transaksi->isEmpty()) {
            return redirect()->back()->with('gagal', 'Transaksi tidak ditemukan.');
        }
    
        $transaksi_data = $transaksi->map(function($item) {
            return [
                'judul_buku' => $item->buku->judul_buku,
                'kondisi' => $item->kondisi,
                'status' => $item->status,
                'denda_total' => $item->denda_hilang_atau_rusak + $item->denda_keterlambatan,
                'tgl_peminjaman' => $item->transaksi_pinjam->created_at->format('d-m-Y H:m:s')
            ];
        });
        
        $data = [
            'nama_perpustakaan' => 'PERPUSTAKAAN ABC',
            'alamat_perpustakaan' => 'Jl. Meranti Raya No.3, RT 3 RW 14, Desa Setia Mekar, Kec. Tambun Selatan, Kab. Bekasi 17510',
            'tanggal_jam' => Carbon::now()->format("d-m-Y H:i:s"),
            'kode_transaksi' => $kodeTransaksi,
            'nama_member' => $transaksi->first()->transaksi_pinjam->member->nama_lengkap,
            'transaksi_data' => $transaksi_data,  // Gantikan 'daftar_buku' dengan 'transaksi_data'
        ];
        
    
        // Generate PDF
        $pdf = Pdf::loadView('transaksi.strukKembali', $data)
           ->setPaper('a4', 'portrait') // Set ukuran kertas
           ->setOption('margin-top', 0)
           ->setOption('margin-bottom', 0)
           ->setOption('margin-left', 0)
           ->setOption('margin-right', 0);
        $pdfPath = 'struk_peminjaman_'.$kodeTransaksi.'.pdf';
        $pdf->save(storage_path('app/public/'.$pdfPath));
    
        // Redirect dengan JSON response
        return response()->json([
            'pdf_url' => asset('storage/'.$pdfPath),
            'redirect_url' => url('/transaksi/kembali-buku'),
        ]);

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

        $telat = $transaksiPinjam[0]->status == "telat" ? true : false;
        $jumlahDendaTelat = 0;

        if ($telat) {
            // Menggunakan Carbon untuk mendapatkan tanggal saat ini
            $tanggalSekarang = Carbon::now(); // Mendapatkan tanggal sekarang
            $estimasiKembali = Carbon::parse($transaksiPinjam->estimasi_tgl_kembali); // Mengonversi string ke objek Carbon
        
            // Menghitung selisih hari
            $selisihHari = $tanggalSekarang->diffInDays($estimasiKembali);
        
            // Pastikan selisih hari positif (hanya menghitung denda jika telat)
            if ($selisihHari > 0) {
                // denda per hari adalah 1000
                $jumlahDendaTelat = $selisihHari * 1000; // Ubah sesuai jumlah denda per hari
            }
        }
        
        $kode_member = Members::where("id", $transaksiPinjam[0]->id_member)->first()->kode_member;

        $data = [];

        foreach($transaksiPinjam as $transaksi) {
            $buku = Buku::where("id", $transaksi->id_buku)->first();
            $data[] = [
                "kode_buku" => $buku->kode_buku,
                "judul_buku" => $buku->judul_buku,
                "status" => $transaksi->status,
                "harga_buku" => $buku->harga,
                "jumlah_denda_telat" => $jumlahDendaTelat,
            ];
        }
        
        
        return redirect()->back()->with([
            "kode_peminjaman" => $transaksi->kode_peminjaman,
            "kode_member" => $kode_member,
            "data_peminjaman" => $data
        ]);
    }

    public function reportpdf(Request $request)
{
    // Filter ulang sesuai inputan sebelumnya
    $query = TransaksiKembali::query();

    if ($request->s) {
        $query->where(function ($q) use ($request) {
            $q->where('kode_pengembalian', 'like', '%' . $request->s . '%')
                ->orWhereHas('member', function ($q) use ($request) {
                    $q->where('nama_lengkap', 'like', '%' . $request->s . '%');
                })
                ->orWhereHas('buku', function ($q) use ($request) {
                    $q->where('judul_buku', 'like', '%' . $request->s . '%');
                })
                ->orWhereHas('transaksiPinjam', function ($q) use ($request) {
                    $q->where('kode_peminjaman', 'like', '%' . $request->s . '%');
                });
        });
    }

    if ($request->tanggal_awal && $request->tanggal_akhir) {
        $query->whereBetween('tgl_pengembalian', [$request->tanggal_awal, $request->tanggal_akhir]);
    }

    $transaksi = $query->get();

    // Data untuk ditampilkan di laporan
    $data = [
        'transaksi' => $transaksi,
        'pustakawan' => Auth::user()->nama_lengkap,
        'nama_perpustakaan' => "PERPUSTAKAAN ABC",
        'alamat_perpustakaan' => "Jl. Meranti Raya No.3, RT 3 RW 14, Desa Setia Mekar, Kec. Tambun Selatan, Kab. Bekasi 17510",
        'tanggal_jam' => Carbon::now()->format("d-m-Y H:m:s")
    ];

    // Render PDF untuk menghitung total halaman
    $pdf = PDF::loadView('transaksi.reportKembali', $data);
    $pdf->setPaper('A4', 'portrait');

    // Output untuk mendapatkan konten dan menghitung total halaman
    $pdfContent = $pdf->output();
    $totalPages = $pdf->getCanvas()->get_page_count(); // Hitung total halaman

    // Set data untuk halaman
    $data['totalPages'] = $totalPages; // Total halaman
    $data['page'] = 1; // Untuk halaman pertama, bisa Anda atur jika Anda mengatur halaman
    $data['chunksCount'] = ceil($transaksi->count() / 15); // Jika setiap halaman 15 item

    // Memuat ulang tampilan dengan data halaman
    $pdf = PDF::loadView('transaksi.reportKembali', $data);
    return $pdf->stream('laporan_transaksi_pengembalian.pdf');
}

}
