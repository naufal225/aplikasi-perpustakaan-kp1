<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    public function transaksiPinjam() {
        return $this->hasMany(TransaksiPinjam::class);
    }
    public function transaksiKembali() {
        return $this->hasMany(TransaksiKembali::class);
    }
}
