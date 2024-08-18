<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string("kode_petugas")->unique();
            $table->string("nama_lengkap");
            $table->text("alamat");
            $table->string("email");
            $table->string("password");
            $table->string("no_telp");
            $table->boolean("admin")->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}

