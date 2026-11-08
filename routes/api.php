<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DetectionController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/


// =========================================================
// USER
// =========================================================

Route::get('/user', function (Request $request) {

    return $request->user();

})->middleware('auth:sanctum');


// =========================================================
// DETEKSI GAMBAR
// =========================================================

Route::post(
    '/detect-image',
    [DetectionController::class, 'detectImage']
);


// =========================================================
// SIMPAN SEMUA HASIL DETEKSI GAMBAR
// =========================================================
//
// With_helmet
//      -> detections
//
// without_helmet
//      -> detections
//      -> violations
//

Route::post(
    '/store-detection-results',
    [DetectionController::class, 'storeDetectionResults']
);


// =========================================================
// SIMPAN PELANGGARAN
// =========================================================
//
// Route lama tetap dipertahankan
// agar tidak mengganggu sistem yang sudah berjalan.
//

Route::post(
    '/store-violation',
    [DetectionController::class, 'storeViolation']
);