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
        Schema::create('riwayat_petugas', function (Blueprint $table) {
            $table->id();
            $table->integer('users_id');
            $table->string('deskripsi');
            $table->string('jenis_tindakan');
            $table->integer('related_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_petugas');
    }
};
