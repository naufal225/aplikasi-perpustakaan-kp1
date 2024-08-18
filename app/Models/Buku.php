<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    public function kategori() {
        return $this->belongsTo(Kategori::class, "id_kategori");
    }

    public function transaksiPinjam() {
        return $this->hasMany(TransaksiPinjam::class);
    }
    public function transaksiKembali() {
        return $this->hasMany(TransaksiKembali::class);
    }
}
