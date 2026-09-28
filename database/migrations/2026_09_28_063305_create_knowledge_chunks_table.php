<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('knowledge_chunks', function (Blueprint $table) {
            $table->id();
            $table->string('source');            // original file name (basename)
            $table->unsignedInteger('page')->nullable(); // PDF page number; null for .md / .txt
            $table->string('title');
            $table->text('content');
            $table->timestamps();
        });

        // MySQL FULLTEXT index for natural-language search.
        // SQLite (used in tests) does not support FULLTEXT — skip it there.
        if (DB::getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE knowledge_chunks ADD FULLTEXT fulltext_title_content (title, content)');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('knowledge_chunks');
    }
};
