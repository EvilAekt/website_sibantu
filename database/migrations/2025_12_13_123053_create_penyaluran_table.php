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
        Schema::create('penyaluran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_laporan')->constrained('laporan')->onDelete('cascade');
            $table->foreignId('id_bantuan')->constrained('bantuan')->onDelete('cascade');
            $table->date('tanggal_penyaluran');
            $table->string('petugas');
            $table->integer('jumlah')->default(1);
            $table->enum('status', ['dijadwalkan', 'dalam_perjalanan', 'tersalurkan'])->default('dijadwalkan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penyaluran');
    }
};
