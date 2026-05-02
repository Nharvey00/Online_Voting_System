<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');
            $table->foreignId('election_id')
                  ->constrained('elections')
                  ->onDelete('cascade');
            $table->foreignId('position_id')
                  ->constrained('positions')
                  ->onDelete('cascade');
            $table->foreignId('candidate_id')
                  ->constrained('candidates')
                  ->onDelete('cascade');
            $table->timestamps();

            // Business rule: one vote per user per position
            $table->unique(['user_id', 'position_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('votes');
    }
};