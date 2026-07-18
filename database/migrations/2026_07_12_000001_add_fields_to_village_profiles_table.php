<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('village_profiles', function (Blueprint $table) {
            $table->string('village_slogan')->nullable()->after('nama_desa');
            $table->string('whatsapp')->nullable()->after('telepon');
            $table->string('hero_image')->nullable()->after('website');
            $table->string('cover_image')->nullable()->after('hero_image');
            $table->string('office_photo')->nullable()->after('cover_image');
            $table->string('latitude')->nullable()->after('office_photo');
            $table->string('longitude')->nullable()->after('latitude');
        });
    }

    public function down(): void
    {
        Schema::table('village_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'village_slogan',
                'whatsapp',
                'hero_image',
                'cover_image',
                'office_photo',
                'latitude',
                'longitude',
            ]);
        });
    }
};
