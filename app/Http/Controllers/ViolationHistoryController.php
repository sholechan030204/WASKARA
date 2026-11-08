<?php

namespace App\Http\Controllers;

use App\Models\Violation;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ViolationHistoryController extends Controller
{
    /**
     * =========================================================
     * RIWAYAT PELANGGARAN
     * =========================================================
     */
    public function index(Request $request)
    {
        // =====================================================
        // 1. AMBIL FILTER TANGGAL
        // =====================================================

        $selectedDate = $request->input('date');


        // =====================================================
        // 2. QUERY DATA PELANGGARAN
        // =====================================================

        $query = Violation::query()
            ->where(
                'violation_type',
                'without_helmet'
            );


        // =====================================================
        // 3. FILTER TANGGAL
        // =====================================================

        if (!empty($selectedDate)) {

            $query->whereDate(
                'occurred_at',
                $selectedDate
            );
        }


        // =====================================================
        // 4. AMBIL DATA
        // =====================================================

        $violations = $query
            ->latest('occurred_at')
            ->get();


        // =====================================================
        // 5. TOTAL PELANGGARAN
        // =====================================================

        $totalViolations = $violations->count();


        // =====================================================
        // 6. RATA-RATA CONFIDENCE
        // =====================================================

        $averageConfidence = 0;

        if ($totalViolations > 0) {

            $averageConfidence = $violations->avg(
                'confidence'
            );
        }


        // =====================================================
        // 7. PELANGGARAN HARI INI
        // =====================================================

        $todayViolations = Violation::query()
            ->where(
                'violation_type',
                'without_helmet'
            )
            ->whereDate(
                'occurred_at',
                Carbon::today()
            )
            ->count();


        // =====================================================
        // 8. KIRIM KE VIEW
        // =====================================================

        return view(
            'violations.index',
            compact(
                'violations',
                'totalViolations',
                'todayViolations',
                'averageConfidence',
                'selectedDate'
            )
        );
    }


    /**
     * =========================================================
     * HALAMAN EXPORT DATA
     * =========================================================
     */
    public function exportPage()
    {
        // =====================================================
        // STATISTIK EXPORT
        // =====================================================

        $totalViolations = Violation::query()
            ->where(
                'violation_type',
                'without_helmet'
            )
            ->count();

        $todayViolations = Violation::query()
            ->where(
                'violation_type',
                'without_helmet'
            )
            ->whereDate(
                'occurred_at',
                Carbon::today()
            )
            ->count();

        $lastViolation = Violation::query()
            ->where(
                'violation_type',
                'without_helmet'
            )
            ->latest('occurred_at')
            ->first();


        // =====================================================
        // TAMPILKAN HALAMAN
        // =====================================================

        return view(
            'export.index',
            compact(
                'totalViolations',
                'todayViolations',
                'lastViolation'
            )
        );
    }


    /**
     * =========================================================
     * EXPORT DATA PELANGGARAN KE CSV
     * =========================================================
     */
    public function export()
    {
        // =====================================================
        // AMBIL DATA
        // =====================================================

        $violations = Violation::query()
            ->where(
                'violation_type',
                'without_helmet'
            )
            ->latest('occurred_at')
            ->get();


        // =====================================================
        // NAMA FILE
        // =====================================================

        $filename =
            'data-pelanggaran-' .
            now()->format('Y-m-d-His') .
            '.csv';


        // =====================================================
        // DOWNLOAD CSV
        // =====================================================

        return response()->streamDownload(
            function () use ($violations) {

                $handle = fopen(
                    'php://output',
                    'w'
                );


                // BOM UTF-8
                fprintf(
                    $handle,
                    chr(0xEF) .
                    chr(0xBB) .
                    chr(0xBF)
                );


                // HEADER
                fputcsv(
                    $handle,
                    [
                        'ID',
                        'Jenis Pelanggaran',
                        'Confidence',
                        'Lokasi',
                        'Status',
                        'Waktu Kejadian'
                    ]
                );


                // DATA
                foreach ($violations as $violation) {

                    fputcsv(
                        $handle,
                        [
                            $violation->id,
                            $violation->violation_type,
                            $violation->confidence,
                            $violation->location,
                            $violation->status,
                            $violation->occurred_at,
                        ]
                    );
                }


                fclose($handle);
            },
            $filename,
            [
                'Content-Type' =>
                    'text/csv; charset=UTF-8',
            ]
        );
    }
}