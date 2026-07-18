<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Hapus RT/RW dari tabel yang menyimpannya.
        // Catatan: kolom RT/RW kemungkinan berada di `regions`.
        Schema::table('regions', function (Blueprint $table) {
            if (Schema::hasColumn('regions', 'jumlah_rt')) {
                $table->dropColumn('jumlah_rt');
            }

            if (Schema::hasColumn('regions', 'jumlah_rw')) {
                $table->dropColumn('jumlah_rw');
            }
        });
    }

    public function down(): void
    {
        Schema::table('regions', function (Blueprint $table) {
            if (!Schema::hasColumn('regions', 'jumlah_rt')) {
                $table->integer('jumlah_rt')->nullable();
            }
            if (!Schema::hasColumn('regions', 'jumlah_rw')) {
                $table->integer('jumlah_rw')->nullable();
            }
        });

        Schema::table('village_profiles', function (Blueprint $table) {
            if (!Schema::hasColumn('village_profiles', 'rt')) {
                $table->integer('rt')->nullable();
            }
            if (!Schema::hasColumn('village_profiles', 'rw')) {
                $table->integer('rw')->nullable();
            }
        });
    }
};

