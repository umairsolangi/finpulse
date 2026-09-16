<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('role_change_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('target_user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('changed_by_user_id')->constrained('users')->cascadeOnDelete();
            $table->enum('action', ['assigned', 'removed']);
            $table->string('role', 64);
            $table->timestamp('created_at')->useCurrent()->index();

            $table->index(['target_user_id', 'created_at']);
            $table->index('changed_by_user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('role_change_logs');
    }
};
