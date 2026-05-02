<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('candidates', function (Blueprint $table) {
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
            $table->text('platform');
            $table->string('document');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('remarks')->nullable();
            $table->timestamps();

            // Business rule: one application per user per election
            $table->unique(['user_id', 'election_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('candidates');
    }
};