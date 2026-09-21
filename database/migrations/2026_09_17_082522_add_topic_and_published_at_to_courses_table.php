<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->string('topic')->nullable()->after('skill_level')->index();
            $table->timestamp('published_at')->nullable()->after('topic')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropIndex(['topic']);
            $table->dropIndex(['published_at']);
            $table->dropColumn(['topic', 'published_at']);
        });
    }
};
