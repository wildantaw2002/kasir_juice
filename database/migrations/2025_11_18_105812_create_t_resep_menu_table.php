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
        Schema::create('t_resep_menu', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_menu')->constrained('t_menu')->onDelete('cascade');
            $table->foreignId('id_bahan')->constrained('t_bahan')->onDelete('cascade');
            $table->decimal('jumlah_bahan', 8, 2); // Jumlah bahan yang dibutuhkan per menu
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_resep_menu');
    }
};
