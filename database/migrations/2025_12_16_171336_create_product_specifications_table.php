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
       Schema::create('product_specifications', function (Blueprint $table) {
    $table->id();
    $table->foreignId('product_id')->constrained()->cascadeOnDelete();

    // Deskripsi spesifikasi (non TOPSIS)
    $table->string('material');
    $table->string('size');
    $table->string('finishing');

    // === KRITERIA TOPSIS (NUMERIK) ===
    $table->integer('harga');              // cost
    $table->integer('kualitas_warna');     // benefit
    $table->integer('daya_tahan');         // benefit
    $table->integer('tekstur_bahan');      // benefit
    $table->integer('ukuran_cetak');       // benefit

    $table->timestamps();
});


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_specifications');
    }
};
