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
        Schema::create('login_streaks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->date('login_date');
            $table->unsignedInteger('current_streak')->default(1);
            $table->unsignedInteger('longest_streak')->default(1);
            $table->timestamps();

            $table->unique(['user_id', 'login_date']);
            $table->index(['user_id', 'login_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('login_streaks');
    }
};
