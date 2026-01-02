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
        Schema::create('laporan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pelapor');
            $table->string('lokasi');
            $table->text('deskripsi');
            $table->enum('jenis_bantuan', ['pangan', 'sandang', 'papan', 'kesehatan', 'pendidikan', 'lainnya']);
            $table->string('foto')->nullable();
            $table->enum('status', ['baru', 'diproses', 'selesai'])->default('baru');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('laporan');
    }
};
