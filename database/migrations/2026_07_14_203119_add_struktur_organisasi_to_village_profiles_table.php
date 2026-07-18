<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*
         * Kolom ini sebenarnya sudah ditambahkan oleh migration:
         * 2026_07_14_030000_add_structure_organisasi_to_
         * village_profiles_table.php
         *
         * Pengaman ini mencegah error duplicate column pada database
         * lokal maupun saat proyek dipasang di hosting.
         */
        if (!Schema::hasColumn(
            'village_profiles',
            'struktur_organisasi'
        )) {
            Schema::table(
                'village_profiles',
                function (Blueprint $table): void {
                    $table
                        ->string('struktur_organisasi')
                        ->nullable()
                        ->after('office_photo');
                }
            );
        }
    }

    public function down(): void
    {
        /*
         * Sengaja tidak menghapus kolom.
         * Kolom struktur_organisasi dimiliki migration yang lebih awal,
         * sehingga rollback migration duplikat ini tidak boleh
         * menghapus kolom tersebut.
         */
    }
};
