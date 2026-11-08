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
        Schema::create('violations', function (Blueprint $table) {
            $table->id();

            // Relasi ke hasil deteksi YOLOv11
            $table->foreignId('detection_id')
                ->constrained('detections')
                ->cascadeOnDelete();

            // Jenis pelanggaran
            $table->string('violation_type')->default('without_helmet');

            // Confidence dari deteksi YOLOv11
            $table->decimal('confidence', 5, 4);

            // Bukti pelanggaran
            $table->string('evidence_image')->nullable();

            // Sumber/lokasi kejadian
            $table->string('location')->nullable();

            // Status pelanggaran
            $table->string('status')->default('detected');

            // Waktu kejadian
            $table->timestamp('occurred_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('violations');
    }
};