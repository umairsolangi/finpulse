<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('live_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->enum('type', ['webinar', 'one_on_one']);
            $table->foreignId('host_id')->constrained('users')->cascadeOnDelete();
            $table->timestamp('scheduled_at');
            $table->unsignedInteger('duration_minutes');
            $table->enum('tier', ['free', 'registered', 'paid'])->default('paid');
            $table->string('meeting_url')->nullable();
            $table->unsignedInteger('max_attendees')->nullable();
            $table->timestamps();

            $table->index(['scheduled_at', 'type']);
            $table->index('host_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('live_sessions');
    }
};
