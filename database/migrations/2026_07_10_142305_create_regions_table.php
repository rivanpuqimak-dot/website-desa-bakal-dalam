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
    Schema::create('regions', function (Blueprint $table) {

        $table->id();

        $table->text('deskripsi')->nullable();

        $table->string('luas_wilayah')->nullable();

        $table->integer('jumlah_dusun')->nullable();

        $table->string('batas_utara')->nullable();

        $table->string('batas_selatan')->nullable();

        $table->string('batas_timur')->nullable();

        $table->string('batas_barat')->nullable();

        $table->string('google_maps')->nullable();

        $table->timestamps();

    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('regions');
    }
};
