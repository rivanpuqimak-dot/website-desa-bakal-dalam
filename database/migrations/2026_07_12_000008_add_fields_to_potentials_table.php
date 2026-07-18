<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('potentials', function (Blueprint $table) {
            if (!Schema::hasColumn('potentials', 'slug')) {
                $table->string('slug')->nullable()->after('nama');
            }
            if (!Schema::hasColumn('potentials', 'lokasi')) {
                $table->string('lokasi')->nullable()->after('kategori');
            }
            if (!Schema::hasColumn('potentials', 'excerpt')) {
                $table->text('excerpt')->after('lokasi');
            }
            if (!Schema::hasColumn('potentials', 'status')) {
                $table->string('status')->default('Publik')->after('gambar');
            }
            if (!Schema::hasColumn('potentials', 'featured')) {
                $table->boolean('featured')->default(false)->after('status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('potentials', function (Blueprint $table) {
            $table->dropColumn(['slug', 'lokasi', 'excerpt', 'status', 'featured']);
        });
    }
};
