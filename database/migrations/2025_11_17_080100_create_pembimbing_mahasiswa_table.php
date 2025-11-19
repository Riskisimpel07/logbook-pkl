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
        Schema::create('pembimbing_mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pembimbing_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('mahasiswa_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['pembimbing_id', 'mahasiswa_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembimbing_mahasiswa');
    }
};
