<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use App\Models\Detection;
use App\Models\DetectionSession;
use App\Models\Violation;

class DetectionController extends Controller
{
    /**
     * =========================================================
     * DETEKSI GAMBAR
     * =========================================================
     */
    public function detectImage(Request $request)
    {
        $request->validate([
            'image' =>
                'required|image|mimes:jpg,jpeg,png|max:10240',
        ]);

        $image =
            $request->file('image');

        try {

            $response =
                Http::timeout(30)
                    ->attach(
                        'file',
                        file_get_contents(
                            $image->getRealPath()
                        ),
                        $image->getClientOriginalName()
                    )
                    ->post(
                        'http://127.0.0.1:8001/detect'
                    );

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' =>
                    'Tidak dapat terhubung ke Python YOLOv11.',
                'error' =>
                    $e->getMessage(),
            ], 500);
        }

        if (!$response->successful()) {

            return response()->json([
                'success' => false,
                'message' =>
                    'Python YOLOv11 mengembalikan error.',
                'python_response' =>
                    $response->json(),
            ], 500);
        }

        $result =
            $response->json();

        return response()->json([
            'success' => true,
            'message' =>
                'Deteksi berhasil.',
            'total_detections' =>
                count(
                    $result['detections'] ?? []
                ),
            'detections' =>
                $result['detections'] ?? [],
            'performance' =>
                $result['performance'] ?? null,
        ]);
    }


    /**
     * =========================================================
     * SIMPAN HASIL DETEKSI
     * =========================================================
     *
     * Endpoint ini mempertahankan route lama:
     * /api/store-violation
     *
     * Sekarang dapat menerima dua class:
     *
     * With_helmet
     * without_helmet
     *
     * Keduanya disimpan ke tabel detections.
     *
     * Hanya without_helmet yang dibuatkan Violation.
     */
    public function storeViolation(Request $request)
    {
        // =====================================================
        // 1. VALIDASI
        // =====================================================

        $request->validate([

            'class_name' =>
                'required|string|in:With_helmet,without_helmet',

            'confidence' =>
                'required|numeric|min:0|max:1',

            'x1' =>
                'nullable|numeric',

            'y1' =>
                'nullable|numeric',

            'x2' =>
                'nullable|numeric',

            'y2' =>
                'nullable|numeric',

        ]);


        // =====================================================
        // 2. AMBIL DATA
        // =====================================================

        $className =
            $request->class_name;

        $confidence =
            (float) $request->confidence;


        // =====================================================
        // 3. SIMPAN GAMBAR
        // =====================================================

        $imagePath =
            null;

        if (
            $request->hasFile('image')
        ) {

            $image =
                $request->file('image');

            if (
                $image->isValid()
            ) {

                try {

                    $extension =
                        strtolower(
                            $image
                                ->getClientOriginalExtension()
                        );

                    if (
                        !in_array(
                            $extension,
                            [
                                'jpg',
                                'jpeg',
                                'png'
                            ],
                            true
                        )
                    ) {
                        $extension =
                            'jpg';
                    }

                    $fileName =
                        'detection_' .
                        time() .
                        '_' .
                        uniqid() .
                        '.' .
                        $extension;

                    $imagePath =
                        $image->storeAs(
                            'detections',
                            $fileName,
                            'public'
                        );

                } catch (\Exception $e) {

                    $imagePath =
                        null;
                }
            }
        }


        // =====================================================
        // 4. BUAT DETECTION SESSION
        // =====================================================

        try {

            $session =
                new DetectionSession();

            $session->source =
                'image';

            $session->source_type =
                'image';

            $session->source_name =
                'Upload Gambar';

            $session->status =
                'completed';

            $session->started_at =
                now();

            $session->ended_at =
                now();

            $session->save();

        } catch (\Exception $e) {

            return response()->json([

                'success' => false,

                'message' =>
                    'Gagal membuat Detection Session.',

                'error' =>
                    $e->getMessage(),

            ], 500);
        }


        // =====================================================
        // 5. SIMPAN DETECTION
        // =====================================================

        try {

            $detection =
                new Detection();

            $detection->detection_session_id =
                $session->id;

            $detection->class_name =
                $className;

            $detection->confidence =
                $confidence;

            $detection->x1 =
                $request->x1;

            $detection->y1 =
                $request->y1;

            $detection->x2 =
                $request->x2;

            $detection->y2 =
                $request->y2;

            $detection->image_path =
                $imagePath;

            $detection->detected_at =
                now();

            $detection->save();

        } catch (\Exception $e) {

            return response()->json([

                'success' => false,

                'message' =>
                    'Gagal menyimpan Detection.',

                'error' =>
                    $e->getMessage(),

            ], 500);
        }


        // =====================================================
        // 6. VIOLATION HANYA UNTUK WITHOUT HELMET
        // =====================================================

        $violation =
            null;

        if (
            $className ===
            'without_helmet'
        ) {

            try {

                $violation =
                    new Violation();

                $violation->detection_id =
                    $detection->id;

                $violation->violation_type =
                    'without_helmet';

                $violation->confidence =
                    $confidence;

                $violation->evidence_image =
                    $imagePath;

                $violation->location =
                    'Upload Gambar';

                $violation->status =
                    'detected';

                $violation->occurred_at =
                    now();

                $violation->save();

            } catch (\Exception $e) {

                return response()->json([

                    'success' => false,

                    'message' =>
                        'Gagal menyimpan Violation.',

                    'error' =>
                        $e->getMessage(),

                ], 500);
            }
        }


        // =====================================================
        // 7. RESPONSE
        // =====================================================

        return response()->json([

            'success' =>
                true,

            'message' =>
                $className === 'without_helmet'
                    ? 'Pelanggaran berhasil disimpan.'
                    : 'Deteksi With Helmet berhasil disimpan.',

            'class_name' =>
                $className,

            'detection_id' =>
                $detection->id,

            'session_id' =>
                $session->id,

            'violation_id' =>
                $violation?->id,

            'confidence' =>
                $confidence,

            'image_path' =>
                $imagePath,

        ]);
    }
}