<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table
                ->date('tanggal_kegiatan')
                ->nullable()
                ->after('kategori');

            $table->index(
                ['tanggal_kegiatan', 'kategori'],
                'galleries_date_category_index'
            );
        });

        /*
         * Foto lama otomatis memakai tanggal dibuatnya data.
         * Dengan demikian data lama langsung masuk ke kelompok tahun.
         */
        DB::statement(
            'UPDATE galleries
             SET tanggal_kegiatan = DATE(created_at)
             WHERE tanggal_kegiatan IS NULL'
        );
    }

    public function down(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->dropIndex('galleries_date_category_index');
            $table->dropColumn('tanggal_kegiatan');
        });
    }
};
