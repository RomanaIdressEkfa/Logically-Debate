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
        Schema::create('debates', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->foreignId('pro_user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('con_user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('judge_id')->nullable()->constrained('users')->onDelete('set null');
            $table->enum('status', ['pending', 'active', 'completed'])->default('pending');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->foreignId('winner_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('debates');
    }
};
