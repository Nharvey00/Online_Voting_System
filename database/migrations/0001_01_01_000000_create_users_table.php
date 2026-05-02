<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');

            // Personal Info
            $table->date('birthdate');
            $table->string('address');
            $table->string('barangay');
            $table->string('city');
            $table->string('province');

            // ID Credentials
            $table->string('id_type');
            $table->string('id_number');
            $table->string('id_photo');
            $table->string('profile_photo');

            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};