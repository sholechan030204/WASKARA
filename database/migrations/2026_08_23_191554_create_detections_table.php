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
        Schema::create('detections', function (Blueprint $table) {
            $table->id();

            // Relasi ke sesi deteksi
            $table->foreignId('detection_session_id')
                ->constrained('detection_sessions')
                ->cascadeOnDelete();

            // Hasil klasifikasi YOLOv11
            $table->string('class_name');

            // Nilai confidence YOLOv11
            $table->decimal('confidence', 5, 4);

            // Koordinat bounding box
            $table->decimal('x1', 10, 2)->nullable();
            $table->decimal('y1', 10, 2)->nullable();
            $table->decimal('x2', 10, 2)->nullable();
            $table->decimal('y2', 10, 2)->nullable();

            // Path gambar/frame bukti
            $table->string('image_path')->nullable();

            // Waktu objek terdeteksi
            $table->timestamp('detected_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detections');
    }
};