<?php

namespace App\Http\Controllers;

use App\Models\Detection;
use App\Models\DetectionSession;

class AnalyticsController extends Controller
{
    public function index()
    {
        // =====================================================
        // TOTAL DETEKSI
        // =====================================================

        $totalDetections = Detection::count();

        $withHelmet = Detection::where(
            'class_name',
            'With_helmet'
        )->count();

        $withoutHelmet = Detection::where(
            'class_name',
            'without_helmet'
        )->count();


        // =====================================================
        // PERSENTASE
        // =====================================================

        $helmetPercentage = $totalDetections > 0
            ? round(($withHelmet / $totalDetections) * 100, 1)
            : 0;

        $withoutHelmetPercentage = $totalDetections > 0
            ? round(($withoutHelmet / $totalDetections) * 100, 1)
            : 0;


        // =====================================================
        // TOTAL SESSION
        // =====================================================

        $totalSessions = DetectionSession::count();


        // =====================================================
        // CONFIDENCE RATA-RATA
        // =====================================================

        $averageConfidence = Detection::avg('confidence') ?? 0;

        $averageConfidence = round(
            $averageConfidence * 100,
            1
        );


        // =====================================================
        // DETEKSI TERBARU
        // =====================================================

        $recentDetections = Detection::latest()
            ->take(10)
            ->get();


        // =====================================================
        // DATA GRAFIK 7 HARI TERAKHIR
        // =====================================================

        $dailyLabels = [];
        $dailyWithHelmet = [];
        $dailyWithoutHelmet = [];

        for ($i = 6; $i >= 0; $i--) {

            $date = now()->subDays($i);

            $dailyLabels[] = $date->format('d M');

            $dailyWithHelmet[] = Detection::where(
                'class_name',
                'With_helmet'
            )
                ->whereDate(
                    'created_at',
                    $date->toDateString()
                )
                ->count();

            $dailyWithoutHelmet[] = Detection::where(
                'class_name',
                'without_helmet'
            )
                ->whereDate(
                    'created_at',
                    $date->toDateString()
                )
                ->count();
        }


        // =====================================================
        // RETURN VIEW
        // =====================================================

        return view(
            'analytics.index',
            compact(
                'totalDetections',
                'withHelmet',
                'withoutHelmet',
                'helmetPercentage',
                'withoutHelmetPercentage',
                'totalSessions',
                'averageConfidence',
                'recentDetections',
                'dailyLabels',
                'dailyWithHelmet',
                'dailyWithoutHelmet'
            )
        );
    }
}