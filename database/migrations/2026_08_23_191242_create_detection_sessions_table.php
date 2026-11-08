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
        Schema::create('detection_sessions', function (Blueprint $table) {
    $table->id();

    // User yang menjalankan sesi deteksi
    $table->foreignId('user_id')
        ->nullable()
        ->constrained('users')
        ->nullOnDelete();

    // Sumber deteksi: webcam, CCTV Dishub, video, atau gambar
    $table->string('source_type');

    // Nama sumber, misalnya "Webcam Laptop" atau "CCTV Simpang Lima"
    $table->string('source_name')->nullable();

    // Status sesi
    $table->string('status')->default('active');

    // Waktu mulai dan selesai deteksi
    $table->timestamp('started_at')->nullable();
    $table->timestamp('ended_at')->nullable();

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detection_sessions');
    }
};
