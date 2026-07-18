<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            if (! Schema::hasColumn('contacts', 'whatsapp')) {
                $table->string('whatsapp')->nullable()->after('telepon');
            }

            if (! Schema::hasColumn('contacts', 'website')) {
                $table->string('website')->nullable()->after('email');
            }

            if (! Schema::hasColumn('contacts', 'tiktok')) {
                $table->string('tiktok')->nullable()->after('youtube');
            }

            if (! Schema::hasColumn('contacts', 'jam_operasional')) {
                $table->string('jam_operasional')->nullable()->after('alamat');
            }

            if (! Schema::hasColumn('contacts', 'google_maps')) {
                $table->string('google_maps')->nullable()->after('jam_operasional');
            }

            if (! Schema::hasColumn('contacts', 'google_maps_embed')) {
                $table->longText('google_maps_embed')->nullable()->after('google_maps');
            }
        });
    }

    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            if (Schema::hasColumn('contacts', 'google_maps_embed')) {
                $table->dropColumn('google_maps_embed');
            }
            if (Schema::hasColumn('contacts', 'google_maps')) {
                $table->dropColumn('google_maps');
            }
            if (Schema::hasColumn('contacts', 'jam_operasional')) {
                $table->dropColumn('jam_operasional');
            }
            if (Schema::hasColumn('contacts', 'tiktok')) {
                $table->dropColumn('tiktok');
            }
            if (Schema::hasColumn('contacts', 'website')) {
                $table->dropColumn('website');
            }
            if (Schema::hasColumn('contacts', 'whatsapp')) {
                $table->dropColumn('whatsapp');
            }
        });
    }
};
