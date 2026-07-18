<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('regions', function (Blueprint $table) {
            $table->integer('jumlah_rt')->nullable()->after('jumlah_dusun');
            $table->integer('jumlah_rw')->nullable()->after('jumlah_rt');
            $table->longText('google_maps_embed')->nullable()->after('google_maps');
            $table->string('map_image')->nullable()->after('google_maps_embed');
        });
    }

    public function down(): void
    {
        Schema::table('regions', function (Blueprint $table) {
            $table->dropColumn(['jumlah_rt', 'jumlah_rw', 'google_maps_embed', 'map_image']);
        });
    }
};
