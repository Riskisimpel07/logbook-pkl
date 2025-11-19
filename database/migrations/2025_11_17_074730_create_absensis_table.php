<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('absensis', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('peserta_id'); // relasi ke identitas
        $table->date('tanggal');
        $table->string('jam_masuk')->nullable();
        $table->string('jam_pulang')->nullable();
        $table->text('kegiatan')->nullable();
        $table->timestamps();

        $table->foreign('peserta_id')->references('id')->on('identitas')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};
