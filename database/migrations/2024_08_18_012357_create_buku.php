<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('buku', function (Blueprint $table) {
            $table->id();
            $table->foreignId("id_kategori");
            $table->string("kode_buku")->unique();
            $table->string("judul_buku");
            $table->string("slug")->unique();
            $table->string("isbn");
            $table->text("gambar");
            $table->string("penulis");
            $table->string("penerbit");
            $table->bigInteger("harga");
            $table->integer("stok");
            $table->text("sinopsis");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buku');
    }
};
