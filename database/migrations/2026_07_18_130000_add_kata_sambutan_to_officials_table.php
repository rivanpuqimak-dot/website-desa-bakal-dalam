<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('officials', 'kata_sambutan')) {
            Schema::table(
                'officials',
                function (Blueprint $table): void {
                    $table
                        ->text('kata_sambutan')
                        ->nullable()
                        ->after('deskripsi');
                }
            );
        }

        /*
         * Data lama Kepala Desa sebelumnya memakai kolom deskripsi
         * sebagai sambutan. Salin sekali ke kolom baru agar sambutan
         * yang sudah ada tidak hilang setelah migration.
         */
        if (
            Schema::hasColumn('officials', 'kata_sambutan') &&
            Schema::hasColumn('officials', 'deskripsi')
        ) {
            DB::table('officials')
                ->where(
                    'jabatan',
                    'like',
                    '%Kepala Desa%'
                )
                ->whereNull('kata_sambutan')
                ->whereNotNull('deskripsi')
                ->update([
                    'kata_sambutan' => DB::raw('deskripsi'),
                ]);
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('officials', 'kata_sambutan')) {
            Schema::table(
                'officials',
                function (Blueprint $table): void {
                    $table->dropColumn('kata_sambutan');
                }
            );
        }
    }
};
