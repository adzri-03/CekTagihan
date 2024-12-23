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
        Schema::create('pembacaan_meters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelanggan_id')->constrained()->onDelete('cascade');
            $table->integer('meter_aawal');
            $table->integer('meter_akhir');
            $table->integer('pemakaian');
            $table->integer('total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembacaan_meters');
    }
};
