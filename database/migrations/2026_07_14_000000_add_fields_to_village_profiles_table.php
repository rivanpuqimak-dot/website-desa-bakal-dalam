<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('village_profiles', function (Blueprint $table) {
            // Karena migration terdahulu sudah menambah kolom yang sama,
            // maka pada environment tertentu kolom bisa sudah ada.
            // Gunakan raw check agar tidak gagal saat deploy ulang.

            if (!Schema::hasColumn('village_profiles', 'hero_image')) {
                $table->string('hero_image')->nullable();
            }

            if (!Schema::hasColumn('village_profiles', 'cover_image')) {
                $table->string('cover_image')->nullable();
            }

            if (!Schema::hasColumn('village_profiles', 'office_photo')) {
                $table->string('office_photo')->nullable();
            }

            if (!Schema::hasColumn('village_profiles', 'latitude')) {
                $table->decimal('latitude', 10, 7)->nullable();
            }

            if (!Schema::hasColumn('village_profiles', 'longitude')) {
                $table->decimal('longitude', 10, 7)->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('village_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'hero_image',
                'cover_image',
                'office_photo',
                'latitude',
                'longitude',
            ]);
        });
    }
};

