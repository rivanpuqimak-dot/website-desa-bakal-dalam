<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('village_statistics', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('jumlah_penduduk')->default(0);
            $table->unsignedInteger('jumlah_kk')->default(0);
            $table->unsignedInteger('jumlah_dusun')->default(0);
            $table->unsignedInteger('jumlah_rt')->default(0);
            $table->unsignedInteger('jumlah_rw')->default(0);
            $table->unsignedInteger('luas_wilayah')->default(0);
            $table->unsignedInteger('luas_sawah')->default(0);
            $table->unsignedInteger('luas_perkebunan')->default(0);
            $table->unsignedInteger('jumlah_umkm')->default(0);
            $table->unsignedInteger('jumlah_masjid')->default(0);
            $table->unsignedInteger('jumlah_musala')->default(0);
            $table->unsignedInteger('jumlah_sekolah')->default(0);
            $table->unsignedInteger('jumlah_posyandu')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('village_statistics');
    }
};
