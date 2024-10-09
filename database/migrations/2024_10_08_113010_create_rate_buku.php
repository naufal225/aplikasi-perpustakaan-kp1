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
        Schema::create('rate_buku', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_member')->constrained("members")->onDelete('cascade');;
            $table->foreignId('id_buku')->constrained("buku")->onDelete('cascade');;
            $table->integer('rating');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rate_buku');
    }
};
