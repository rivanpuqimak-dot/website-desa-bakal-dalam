<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            if (!Schema::hasColumn('galleries', 'kategori')) {
                $table->string('kategori')->nullable()->after('judul');
            }
            if (!Schema::hasColumn('galleries', 'description')) {
                $table->text('description')->nullable()->after('kategori');
            }
            if (!Schema::hasColumn('galleries', 'featured')) {
                $table->boolean('featured')->default(false)->after('gambar');
            }
            if (!Schema::hasColumn('galleries', 'status')) {
                $table->string('status')->default('Draft')->after('featured');
            }
        });
    }

    public function down(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->dropColumn(['kategori', 'description', 'featured', 'status']);
        });
    }
};
