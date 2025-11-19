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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('role', ['admin', 'mahasiswa', 'pembimbing'])->default('mahasiswa');
            $table->string('nim_nis')->unique();
            $table->string('email')->nullable();
            $table->string('password');
            $table->string('foto')->nullable();
            $table->string('sekolah_kampus')->nullable();
            $table->string('jurusan')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
