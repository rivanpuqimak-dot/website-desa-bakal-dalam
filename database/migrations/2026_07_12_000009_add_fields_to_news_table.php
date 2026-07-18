<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('news', function (Blueprint $table) {
            if (!Schema::hasColumn('news', 'excerpt')) {
                $table->text('excerpt')->after('slug');
            }
            if (!Schema::hasColumn('news', 'kategori')) {
                $table->string('kategori')->after('excerpt');
            }
            if (!Schema::hasColumn('news', 'penulis')) {
                $table->string('penulis')->after('kategori');
            }
            if (!Schema::hasColumn('news', 'published_at')) {
                $table->timestamp('published_at')->nullable()->after('penulis');
            }
            if (!Schema::hasColumn('news', 'status')) {
                $table->string('status')->default('Draft')->after('published_at');
            }
            if (!Schema::hasColumn('news', 'featured')) {
                $table->boolean('featured')->default(false)->after('status');
            }
            if (!Schema::hasColumn('news', 'views')) {
                $table->integer('views')->default(0)->after('featured');
            }
        });
    }

    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn(['excerpt', 'kategori', 'penulis', 'published_at', 'status', 'featured', 'views']);
        });
    }
};
