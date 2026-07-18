<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            if (! Schema::hasColumn('settings', 'slogan')) {
                $table->string('slogan')->nullable()->after('nama_website');
            }

            if (! Schema::hasColumn('settings', 'meta_title')) {
                $table->string('meta_title')->nullable()->after('footer');
            }

            if (! Schema::hasColumn('settings', 'maintenance_mode')) {
                $table->boolean('maintenance_mode')->default(false)->after('meta_keywords');
            }
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            if (Schema::hasColumn('settings', 'maintenance_mode')) {
                $table->dropColumn('maintenance_mode');
            }
            if (Schema::hasColumn('settings', 'meta_title')) {
                $table->dropColumn('meta_title');
            }
            if (Schema::hasColumn('settings', 'slogan')) {
                $table->dropColumn('slogan');
            }
        });
    }
};
