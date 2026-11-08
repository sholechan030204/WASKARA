<?php

namespace App\Http\Controllers;

use App\Models\DetectionSession;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DetectionSessionController extends Controller
{
    /**
     * Membuat sesi deteksi baru.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'source' => [
                'required',
                'string',
                'in:webcam,cctv,youtube,video',
            ],
        ]);

        $session = DetectionSession::create([
    'source' => $validated['source'],
    'source_type' => $validated['source'],
]);

        return response()->json([
            'success' => true,
            'message' => 'Detection session berhasil dibuat.',
            'data' => $session,
        ], 201);
    }
}