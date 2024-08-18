<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiKembali extends Model
{
    use HasFactory;

    public function transaksiPinjam() {
        return $this->belongsTo(TransaksiPinjam::class, "id_peminjaman");
    }
}
