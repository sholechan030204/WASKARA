<?php

namespace App\Http\Controllers;

use App\Models\Detection;
use App\Models\DetectionSession;
use App\Models\Violation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetectionStorageController extends Controller
{
    /**
     * Menyimpan hasil deteksi YOLOv11
     * ke detection_sessions, detections,
     * dan violations.
     *
     * Controller ini dibuat terpisah agar
     * DetectionController yang sudah berjalan
     * tidak perlu diubah.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'source_type' => 'required|string|max:50',
            'source_name' => 'nullable|string|max:255',
            'detections' => 'required|array',
        ]);

        try {

            $result = DB::transaction(function () use ($validated) {

                // =================================================
                // 1. BUAT SESSION DETEKSI
                // =================================================

                $session = DetectionSession::create([
                    'user_id' => auth()->id(),
                    'source_type' =>
                        $validated['source_type'],
                    'source_name' =>
                        $validated['source_name'] ?? null,
                    'status' => 'completed',
                    'started_at' => now(),
                    'ended_at' => now(),
                ]);


                $totalDetections = 0;
                $totalViolations = 0;


                // =================================================
                // 2. SIMPAN SETIAP HASIL DETEKSI
                // =================================================

                foreach (
                    $validated['detections']
                    as $detectionData
                ) {

                    $className =
                        $detectionData['class_name']
                        ?? $detectionData['class']
                        ?? 'Unknown';


                    $confidence =
                        isset(
                            $detectionData['confidence']
                        )
                            ? (float)
                                $detectionData['confidence']
                            : 0;


                    $detection =
                        Detection::create([

                            'detection_session_id' =>
                                $session->id,

                            'class_name' =>
                                $className,

                            'confidence' =>
                                $confidence,

                            'x1' =>
                                $detectionData['x1']
                                ?? null,

                            'y1' =>
                                $detectionData['y1']
                                ?? null,

                            'x2' =>
                                $detectionData['x2']
                                ?? null,

                            'y2' =>
                                $detectionData['y2']
                                ?? null,

                            'image_path' =>
                                $detectionData['image_path']
                                ?? null,

                            'detected_at' =>
                                now(),

                        ]);


                    $totalDetections++;


                    // =================================================
                    // 3. JIKA WITHOUT HELMET
                    //    MAKA SIMPAN SEBAGAI PELANGGARAN
                    // =================================================

                    if (
                        strtolower(
                            trim($className)
                        ) === 'without_helmet'
                    ) {

                        Violation::create([

                            'detection_id' =>
                                $detection->id,

                            'violation_type' =>
                                'without_helmet',

                            'confidence' =>
                                $confidence,

                            'evidence_image' =>
                                $detectionData['image_path']
                                ?? null,

                            'location' =>
                                $validated['source_name']
                                ?? null,

                            'status' =>
                                'detected',

                            'occurred_at' =>
                                now(),

                        ]);


                        $totalViolations++;

                    }

                }


                return [

                    'session_id' =>
                        $session->id,

                    'total_detections' =>
                        $totalDetections,

                    'total_violations' =>
                        $totalViolations,

                ];

            });


            return response()->json([

                'success' => true,

                'message' =>
                    'Hasil deteksi berhasil disimpan.',

                'data' =>
                    $result,

            ]);

        }

        catch (\Throwable $e) {

            return response()->json([

                'success' => false,

                'message' =>
                    'Gagal menyimpan hasil deteksi.',

                'error' =>
                    $e->getMessage(),

            ], 500);

        }
    }
}