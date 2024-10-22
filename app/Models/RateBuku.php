<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RateBuku extends Model
{
    use HasFactory;

    protected $table = 'rate_buku';

    protected $fillable = [
        'id_member',
        'id_buku',
        'rating',
    ];

    // Relasi ke model Member
    public function member()
    {
        return $this->belongsTo(Members::class, 'id_member');
    }

    // Relasi ke model Buku
    public function buku()
    {
        return $this->belongsTo(Buku::class, 'id_buku');
    }
}
