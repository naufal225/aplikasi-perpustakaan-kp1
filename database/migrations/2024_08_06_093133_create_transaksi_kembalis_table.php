<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiKembaliTable extends Migration
{
    public function up()
    {
        Schema::create('transaksi_kembali', function (Blueprint $table) {
            $table->id();
            $table->string('kode_kembali')->unique();
            $table->foreignId('id_member')->constrained('members')->onDelete('cascade');
            $table->foreignId('book_id')->constrained('books')->onDelete('cascade');
            $table->date('tanggal_kembali');
            $table->enum('keadaan_buku', ['hilang', 'rusak']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transaksi_kembali');
    }
}
