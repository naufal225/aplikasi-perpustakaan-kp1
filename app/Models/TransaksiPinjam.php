<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiPinjam extends Model
{
    use HasFactory;

    
    protected $table = "transaksi_pinjam";
    protected $guarded = ['id'];
    public function buku() {
        return $this->belongsTo(Buku::class, "id_buku");
    }
    public function member() {
        return $this->belongsTo(Members::class, "id_member");
    }

    public function transaksiKembali() {
        return $this->hasMany(TransaksiKembali::class);
    }
}
