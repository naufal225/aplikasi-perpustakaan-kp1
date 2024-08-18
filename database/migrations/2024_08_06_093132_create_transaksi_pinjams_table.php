<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiPinjamTable extends Migration
{
    public function up()
    {
        Schema::create('transaksi_pinjam', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pinjam')->unique();
            $table->foreignId('id_member')->constrained('members')->onDelete('cascade');
            $table->date('tanggal_pinjam');
            $table->timestamps();
        });

        Schema::create('book_transaksi_pinjam', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained('books')->onDelete('cascade');
            $table->foreignId('transaksi_pinjam_id')->constrained('transaksi_pinjam')->onDelete('cascade');
            $table->date('masa_pinjam');
            $table->integer('telat')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('book_transaksi_pinjam');
        Schema::dropIfExists('transaksi_pinjam');
    }
}

