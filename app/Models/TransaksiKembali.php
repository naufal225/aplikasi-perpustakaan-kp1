<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiKembali extends Model
{
    use HasFactory;

    protected $table = "transaksi_kembali";

    protected $guarded = ['id'];
    
    public function transaksi_pinjam() {
        return $this->belongsTo(TransaksiPinjam::class, "id_peminjaman");
    }

    public function buku() {
        return $this->belongsTo(Buku::class, "id_buku");
    }

    public function member() {
        return $this->belongsTo(Members::class, "id_member");
    }


}
