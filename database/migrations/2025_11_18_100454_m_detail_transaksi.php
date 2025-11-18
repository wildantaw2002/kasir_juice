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
        Schema::create('t_detail_transaksi', function (Blueprint $table) {
            $table->id();
            $table->string('id_detail')->unique();
            $table->foreignId('id_transaksi')->constrained('t_transaksi')->onDelete('cascade');
            $table->foreignId('id_menu')->constrained('t_menu')->onDelete('cascade');
            $table->integer('ukuran');
            $table->integer('jumlah');
            $table->decimal('subtotal', 12, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_detail_transaksi');
    }
};
