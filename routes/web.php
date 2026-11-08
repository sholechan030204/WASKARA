<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DetectionPageController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\ViolationHistoryController;


/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/', [DashboardController::class, 'index'])
    ->name('dashboard');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard.index');


/*
|--------------------------------------------------------------------------
| Detection
|--------------------------------------------------------------------------
*/

Route::get('/detection', [DetectionPageController::class, 'index'])
    ->name('detection.index');


/*
|--------------------------------------------------------------------------
| Video
|--------------------------------------------------------------------------
*/

Route::get('/video', function () {
    return view('detection.video');
})->name('video');


/*
|--------------------------------------------------------------------------
| Image / Gambar
|--------------------------------------------------------------------------
*/

Route::get('/image', function () {
    return view('detection.image');
})->name('image');


/*
|--------------------------------------------------------------------------
| CCTV / ATCS
|--------------------------------------------------------------------------
*/

Route::get('/cctv', function () {
    return view('detection.cctv');
})->name('cctv');


/*
|--------------------------------------------------------------------------
| Analytics
|--------------------------------------------------------------------------
*/

Route::get('/analytics', [AnalyticsController::class, 'index'])
    ->name('analytics.index');


/*
|--------------------------------------------------------------------------
| Evaluation
|--------------------------------------------------------------------------
*/

Route::get('/evaluation', [EvaluationController::class, 'index'])
    ->name('evaluation.index');


/*
|--------------------------------------------------------------------------
| Evaluation - Confusion Matrix
|--------------------------------------------------------------------------
*/

Route::get(
    '/evaluation/confusion-matrix',
    [EvaluationController::class, 'confusionMatrix']
)->name('evaluation.confusion-matrix');


/*
|--------------------------------------------------------------------------
| Riwayat Pelanggaran
|--------------------------------------------------------------------------
*/

Route::get(
    '/violations',
    [ViolationHistoryController::class, 'index']
)->name('violations.index');


/*
|--------------------------------------------------------------------------
| Export Data - Halaman
|--------------------------------------------------------------------------
*/

Route::get(
    '/export-data',
    [ViolationHistoryController::class, 'exportPage']
)->name('export.index');


/*
|--------------------------------------------------------------------------
| Export Data - Download CSV
|--------------------------------------------------------------------------
*/

Route::get(
    '/violations/export',
    [ViolationHistoryController::class, 'export']
)->name('violations.export');


/*
|--------------------------------------------------------------------------
| Pengaturan
|--------------------------------------------------------------------------
*/

Route::get('/pengaturan', function () {
    return view('settings.index');
})->name('settings.index');

/*
|--------------------------------------------------------------------------
| Tentang WASKARA
|--------------------------------------------------------------------------
*/

Route::get('/tentang-waskara', function () {
    return view('about.index');
})->name('about.index');