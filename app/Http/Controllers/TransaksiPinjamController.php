<?php

namespace App\Http\Controllers;

use App\Models\TransaksiPinjam;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use App\Models\Buku;
use App\Models\Members;
use Barryvdh\DomPDF\Facade\Pdf;
use DateTime;
use Illuminate\Support\Facades\Auth;

class TransaksiPinjamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    // Validasi filter tanggal
    $request->validate([
        'tanggal_awal' => 'nullable|date',
        'tanggal_akhir' => 'nullable|date|after_or_equal:tanggal_awal',
    ]);

    // Query untuk mendapatkan transaksi
    $query = TransaksiPinjam::query();

    // Filter berdasarkan kata kunci pencarian
    if ($request->s) {
        $query->where(function ($q) use ($request) {
            $q->where('kode_peminjaman', 'like', '%' . $request->s . '%')
                ->orWhereHas('member', function ($q) use ($request) {
                    $q->where('nama_lengkap', 'like', '%' . $request->s . '%');
                })
                ->orWhereHas('buku', function ($q) use ($request) {
                    $q->where('judul_buku', 'like', '%' . $request->s . '%');
                });
        });
    }

    // Filter berdasarkan tanggal
    if ($request->tanggal_awal && $request->tanggal_akhir) {
        $query->whereBetween('tgl_peminjaman', [$request->tanggal_awal, $request->tanggal_akhir]);
    }

    // Ambil data transaksi yang difilter
    $transaksi = $query->latest()->paginate(5);

    return view('transaksi.pinjambuku', compact('transaksi'));
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

        // Find the last transaction code for today
        $transaksiTerakhir = TransaksiPinjam::whereDate('tgl_peminjaman', Carbon::today())
            ->latest('kode_peminjaman')
            ->first();

        if ($transaksiTerakhir) {
            // Extract the last 3 digits from the last transaction code
            $lastNumber = (int)substr($transaksiTerakhir->kode_peminjaman, -3);
            // Increment the last number by 1
            $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
            $kodeTransaksi = "TRP" . $tgl_default . $newNumber;
        } else {
            // If no transactions exist today, start with "001"
            $kodeTransaksi = "TRP" . $tgl_default . "001";
        }

        return view('transaksi.tambahtransaksipinjam', [
            'kode_peminjaman' => $kodeTransaksi
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
                    "tgl_peminjaman" => now()->format('Y-m-d H:i:s'),
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
    
        // Ambil data transaksi untuk PDF
        $transaksi = TransaksiPinjam::where('kode_peminjaman', $kode_transaksi)->with('member', 'buku')->get();
        
        if ($transaksi->isEmpty()) {
            return redirect()->back()->with('gagal', 'Transaksi tidak ditemukan.');
        }
    
        $data = [
            'nama_perpustakaan' => 'PERPUSTAKAAN CENDIKIA NUSANTARA',
            'alamat_perpustakaan' => 'Jl. Meranti Raya No.3, Desa Setia Mekar, Kec. Tambun Selatan, Kab. Bekasi, Jawa Barat, 17510',
            'tanggal_jam' => now(),
            'kode_transaksi' => $kode_transaksi,
            'nama_member' => $transaksi->first()->member->nama_lengkap,
            'daftar_buku' => $transaksi->map(function ($item) {
                return $item->buku->judul_buku;
            }),
        ];
    
        // Generate PDF
        $pdf = Pdf::loadView('transaksi.strukPinjam', $data)
           ->setPaper('a4', 'portrait') // Set ukuran kertas
           ->setOption('margin-top', 0)
           ->setOption('margin-bottom', 0)
           ->setOption('margin-left', 0)
           ->setOption('margin-right', 0);
        $pdfPath = 'struk_peminjaman_'.$kode_transaksi.'.pdf';
        $pdf->save(storage_path('app/public/'.$pdfPath));
    
        // Hapus data session untuk cart
        session()->forget(['kode_member', 'kode_buku', 'kode_peminjaman']);
    
        // Redirect dengan JSON response
        return response()->json([
            'pdf_url' => asset('storage/'.$pdfPath),
            'redirect_url' => url('/transaksi/pinjam-buku'),
        ]);
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

    public function reportpdf(Request $request)
    {
        // Filter ulang sesuai inputan sebelumnya
        $query = TransaksiPinjam::query();
    
        if ($request->s) {
            $query->where(function ($q) use ($request) {
                $q->where('kode_peminjaman', 'like', '%' . $request->s . '%')
                    ->orWhereHas('member', function ($q) use ($request) {
                        $q->where('nama_lengkap', 'like', '%' . $request->s . '%');
                    })
                    ->orWhereHas('buku', function ($q) use ($request) {
                        $q->where('judul_buku', 'like', '%' . $request->s . '%');
                    });
            });
        }
    
        if ($request->tanggal_awal && $request->tanggal_akhir) {
            $query->whereBetween('tgl_peminjaman', [
                Carbon::parse($request->tanggal_awal)->startOfDay(), 
                Carbon::parse($request->tanggal_akhir)->endOfDay()
            ]);
        }
    
        $transaksi = $query->get();
    
        // Data untuk ditampilkan di laporan
        $data = [
            'transaksi' => $transaksi,
            'pustakawan' => Auth::user()->nama_lengkap,
            'nama_perpustakaan' => "PERPUSTAKAAN CENDIKIA NUSANTARA",
            'alamat_perpustakaan' => 'Jl. Meranti Raya No.3, RT 3 RW 14, Desa Setia Mekar, Kec. Tambun Selatan, Kab. Bekasi 17510',
            'tanggal_jam' => Carbon::now()->format("d-m-Y H:m:s")
        ];
    
        // Render PDF dengan Snappy
    $pdf = PDF::loadView('transaksi.reportPinjam', $data);
    $pdf->setPaper('A4', 'portrait');

    // Output untuk mendapatkan konten dan menghitung total halaman
    $pdfContent = $pdf->output();
    $totalPages = $pdf->getCanvas()->get_page_count(); // Hitung total halaman

    // Set data untuk halaman
    $data['totalPages'] = $totalPages; // Total halaman
    $data['page'] = 1; // Untuk halaman pertama, bisa Anda atur jika Anda mengatur halaman
    $data['chunksCount'] = ceil($transaksi->count() / 15); // Jika setiap halaman 15 item
    // Memuat ulang tampilan dengan data halaman
    $pdf = PDF::loadView('transaksi.reportPinjam', $data);
    return $pdf->stream('laporan_transaksi_peminjaman.pdf');
    }

}
