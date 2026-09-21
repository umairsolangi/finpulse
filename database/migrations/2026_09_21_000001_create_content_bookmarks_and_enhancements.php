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
        Schema::create('content_bookmarks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('content_item_id')->constrained('content_items')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['user_id', 'content_item_id']);
        });

        Schema::table('content_views', function (Blueprint $table) {
            $table->timestamp('completed_at')->nullable()->after('content_item_id');
        });

        Schema::table('content_items', function (Blueprint $table) {
            $table->longText('urdu_body')->nullable()->after('body');
            $table->json('key_takeaways')->nullable()->after('urdu_body');
            $table->json('quiz_data')->nullable()->after('key_takeaways');
        });

        Schema::create('content_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('content_item_id')->constrained('content_items')->cascadeOnDelete();
            $table->text('comment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_comments');

        Schema::table('content_items', function (Blueprint $table) {
            $table->dropColumn(['urdu_body', 'key_takeaways', 'quiz_data']);
        });

        Schema::table('content_views', function (Blueprint $table) {
            $table->dropColumn('completed_at');
        });

        Schema::dropIfExists('content_bookmarks');
    }
};
