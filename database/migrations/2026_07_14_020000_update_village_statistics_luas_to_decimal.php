<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Ubah kolom luas agar bisa menyimpan desimal (misal 1,5 -> 1.5)
        Schema::table('village_statistics', function (Blueprint $table) {
            $table->decimal('luas_wilayah', 12, 2)->default(0)->change();
            $table->decimal('luas_sawah', 12, 2)->default(0)->change();
            $table->decimal('luas_perkebunan', 12, 2)->default(0)->change();
        });
    }

    public function down(): void
    {
        // Kembalikan ke integer jika rollback (Catatan: desimal akan hilang)
        Schema::table('village_statistics', function (Blueprint $table) {
            $table->unsignedInteger('luas_wilayah')->default(0)->change();
            $table->unsignedInteger('luas_sawah')->default(0)->change();
            $table->unsignedInteger('luas_perkebunan')->default(0)->change();
        });
    }
};

