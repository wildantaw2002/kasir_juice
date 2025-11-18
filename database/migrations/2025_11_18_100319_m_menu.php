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
        Schema::create('t_menu', function (Blueprint $table) {
            $table->id();
            $table->string('id_menu')->unique();
            $table->string('nama_menu');
            $table->string('kategori');
            $table->decimal('harga', 10, 2);
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_menu');
    }
};
