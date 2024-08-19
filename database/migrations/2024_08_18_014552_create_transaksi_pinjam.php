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
        Schema::create('transaksi_pinjam', function (Blueprint $table) {
            $table->id();
            $table->string("kode_peminjaman")->unique();
            $table->foreignId("id_buku");
            $table->foreignId("id_member");
            $table->date("tgl_peminjaman");
            $table->date("estimasi_tgl_kembali");
            $table->enum("status", ["belum telat", "telat"])->default("belum telat");
            $table->enum("keterangan", ["belum selesai", "selesai"])->default("belum selesai");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_pinjam');
    }
};
