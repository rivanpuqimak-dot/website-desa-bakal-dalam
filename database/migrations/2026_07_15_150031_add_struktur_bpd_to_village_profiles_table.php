<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('village_profiles', function (Blueprint $table) {
            if (!Schema::hasColumn('village_profiles', 'struktur_bpd')) {
                $table
                    ->string('struktur_bpd')
                    ->nullable()
                    ->after('struktur_organisasi');
            }
        });
    }

    public function down(): void
    {
        Schema::table('village_profiles', function (Blueprint $table) {
            if (Schema::hasColumn('village_profiles', 'struktur_bpd')) {
                $table->dropColumn('struktur_bpd');
            }
        });
    }
};