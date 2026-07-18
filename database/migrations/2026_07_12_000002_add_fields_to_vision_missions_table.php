<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vision_missions', function (Blueprint $table) {
            $table->longText('tujuan')->nullable()->after('misi');
            $table->string('motto')->nullable()->after('tujuan');
        });
    }

    public function down(): void
    {
        Schema::table('vision_missions', function (Blueprint $table) {
            $table->dropColumn(['tujuan', 'motto']);
        });
    }
};
