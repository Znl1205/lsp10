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
        Schema::create('kelas', function (Blueprint $table) {
            $table->id();
            $table->enum('kelas', ['10', '11', '12', '13']);
            $table->enum('jurusan', ['DKV', 'DPIB', 'BKP', 'RPL', 'SIJA', 'TKJ', 'TKR', 'TP', 'TFLM', 'TOI']);
            $table->enum('rombel', ['1', '2', '3', '4']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};
