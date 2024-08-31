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
        Schema::create('transaksi_kembali', function (Blueprint $table) {
            $table->id();
            $table->string("kode_pengembalian");
            $table->foreignId("id_peminjaman")->constrained('transaksi_pinjam')->onDelete('cascade');
            $table->date("tgl_pengembalian");
            $table->enum("kondisi", ['hilang atau rusak', 'baik']);
            $table->enum("status", ['telat', 'belum telat']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_kembali');
    }
};
