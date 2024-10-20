<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Members extends Authenticatable
{
    use HasFactory;

    protected $table = "members";

    protected $guarded = ['id'];

    public function getRouteKeyName() {
        return "kode_member";
    }

    public function rate_buku() {
        return $this->hasMany(RateBuku::class);
    }
}
