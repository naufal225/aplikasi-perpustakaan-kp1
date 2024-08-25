<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;
    use Sluggable;
    protected $table = "kategori";

    protected $guarded = ['id'];

    public function buku() {
        return $this->hasMany(Buku::class);
    }

    public function getRouteKeyName() {
        return "slug";
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'kategori'
            ]
        ];
    }
}
