<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;
    use Sluggable;

    protected $guarded = ['id'];

    protected $table = 'buku';

    public function kategori() {
        return $this->belongsTo(Kategori::class, "id_kategori");
    }

    public function transaksi_pinjam() {
        return $this->hasMany(TransaksiPinjam::class);
    }
    public function transaksi_kembali() {
        return $this->hasMany(TransaksiKembali::class);
    }

    public function rate_buku()
    {
        return $this->hasMany(RateBuku::class, 'id_buku');
    }

    public function getRouteKeyName() {
        return "slug";
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'judul_buku'
            ]
        ];
    }

    public function calculateRating()
    {
        $averageRating = RateBuku::where('id_buku', $this->id)->avg('rating');

        // Update kolom rating di tabel buku
        $this->rating = $averageRating;
        $this->save();
    }
}
