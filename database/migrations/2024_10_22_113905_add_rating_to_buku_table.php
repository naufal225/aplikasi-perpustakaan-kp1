<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('buku', function (Blueprint $table) {
            $table->float('rating')->nullable()->default(0); // Kolom rating dengan tipe float
        });
    }

    public function down()
    {
        Schema::table('buku', function (Blueprint $table) {
            $table->dropColumn('rating');
        });
    }
};
