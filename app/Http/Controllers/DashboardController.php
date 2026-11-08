<?php

namespace App\Http\Controllers;

use App\Models\Detection;
use App\Models\DetectionSession;
use App\Models\Violation;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // =====================================================
        // =====================================================
        // STATISTIK DETEKSI YOLOv11
        // =====================================================
        // =====================================================

        /*
        |--------------------------------------------------------------------------
        | WITH HELMET
        |--------------------------------------------------------------------------
        | Mengambil jumlah deteksi yang benar-benar tersimpan
        | di tabel detections dengan class_name = With_helmet.
        */

        $withHelmet = Detection::where(
            'class_name',
            'With_helmet'
        )->count();


        /*
        |--------------------------------------------------------------------------
        | WITHOUT HELMET
        |--------------------------------------------------------------------------
        | Mengambil jumlah deteksi yang benar-benar tersimpan
        | di tabel detections dengan class_name = without_helmet.
        */

        $withoutHelmet = Detection::where(
            'class_name',
            'without_helmet'
        )->count();


        /*
        |--------------------------------------------------------------------------
        | TOTAL DETEKSI
        |--------------------------------------------------------------------------
        | Karena model WASKARA memiliki 2 kelas:
        |
        | 1. With_helmet
        | 2. without_helmet
        |
        | Maka total deteksi dibuat dari jumlah kedua kelas tersebut.
        |
        | Dengan demikian:
        |
        | Total Deteksi = With Helmet + Without Helmet
        */

        $totalDetections =
            $withHelmet + $withoutHelmet;


        // =====================================================
        // TOTAL SESSION
        // =====================================================

        $totalSessions =
            DetectionSession::count();


        // =====================================================
        // PERSENTASE WITH HELMET
        // =====================================================

        $helmetPercentage =
            $totalDetections > 0
                ? round(
                    ($withHelmet / $totalDetections) * 100,
                    1
                )
                : 0;


        // =====================================================
        // PERSENTASE WITHOUT HELMET
        // =====================================================

        $withoutHelmetPercentage =
            $totalDetections > 0
                ? round(
                    ($withoutHelmet / $totalDetections) * 100,
                    1
                )
                : 0;


        // =====================================================
        // STATISTIK PELANGGARAN
        // Sumber: tabel violations
        // =====================================================

        $totalViolations =
            Violation::where(
                'violation_type',
                'without_helmet'
            )->count();


        // =====================================================
        // PELANGGARAN HARI INI
        // =====================================================

        $todayViolations =
            Violation::where(
                'violation_type',
                'without_helmet'
            )
            ->whereDate(
                'occurred_at',
                Carbon::today()
            )
            ->count();


        // =====================================================
        // RATA-RATA CONFIDENCE PELANGGARAN
        // =====================================================

        $averageViolationConfidence =
            Violation::where(
                'violation_type',
                'without_helmet'
            )
            ->avg('confidence');


        $averageViolationConfidence =
            $averageViolationConfidence !== null
                ? round(
                    $averageViolationConfidence * 100,
                    2
                )
                : 0;


        // =====================================================
        // DETEKSI TERBARU
        // =====================================================

        $recentDetections =
            Detection::latest()
                ->take(5)
                ->get();


        // =====================================================
        // PELANGGARAN TERBARU
        // =====================================================

        $recentViolations =
            Violation::latest(
                'occurred_at'
            )
            ->take(5)
            ->get();


        // =====================================================
        // KIRIM DATA KE DASHBOARD
        // =====================================================

        return view(
            'dashboard.index',
            compact(
                'totalDetections',
                'withHelmet',
                'withoutHelmet',
                'totalSessions',
                'helmetPercentage',
                'withoutHelmetPercentage',
                'recentDetections',

                // Statistik pelanggaran
                'totalViolations',
                'todayViolations',
                'averageViolationConfidence',
                'recentViolations'
            )
        );
    }
}