<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response;

class EvaluationController extends Controller
{
    /**
     * Menampilkan halaman evaluasi model YOLOv11.
     */
    public function index()
    {
        $results = [];

        // =====================================================
        // HASIL TRAINING
        // =====================================================

        $resultsFile = base_path(
            'storage/app/evaluation/results.csv'
        );

        if (file_exists($resultsFile)) {

            $csv = file_get_contents($resultsFile);

            if ($csv !== false) {

                $lines = preg_split(
                    "/\r\n|\n|\r/",
                    trim($csv)
                );

                if (count($lines) >= 2) {

                    $headers = str_getcsv(
                        array_shift($lines)
                    );

                    foreach ($lines as $line) {

                        if (trim($line) === '') {
                            continue;
                        }

                        $values = str_getcsv($line);

                        if (
                            count($values)
                            !== count($headers)
                        ) {
                            continue;
                        }

                        $row = array_combine(
                            $headers,
                            $values
                        );

                        if ($row !== false) {
                            $results[] = $row;
                        }
                    }
                }
            }
        }


        // =====================================================
        // AMBIL EPOCH TERAKHIR
        // =====================================================

        $latest = null;

        if (!empty($results)) {
            $latest = end($results);
        }


        // =====================================================
        // METRIK EVALUASI
        // =====================================================

        $metrics = [

    'precision' => $latest
        ? (float) (
            $latest['metrics/precision(B)']
            ?? 0
        )
        : null,

    'recall' => $latest
        ? (float) (
            $latest['metrics/recall(B)']
            ?? 0
        )
        : null,

    'map50' => $latest
        ? (float) (
            $latest['metrics/mAP50(B)']
            ?? 0
        )
        : null,

    'map5095' => $latest
        ? (float) (
            $latest['metrics/mAP50-95(B)']
            ?? 0
        )
        : null,

    'epoch' => $latest
        ? (
            $latest['epoch']
            ?? null
        )
        : null,

    // ==========================================
    // HASIL BENCHMARK YOLOv11
    // ==========================================

    'inference_speed' => 106.30,

    'fps' => 9.41,

];


        // =====================================================
        // CONFUSION MATRIX
        // =====================================================

       $confusionMatrixFile = base_path(
    'storage/app/evaluation/confusion_matrix_normalized.png'
);

        $confusionMatrixExists = file_exists(
            $confusionMatrixFile
        );


        // =====================================================
        // KIRIM DATA KE VIEW
        // =====================================================

        return view(
            'evaluation.index',
            compact(
                'metrics',
                'results',
                'confusionMatrixExists'
            )
        );
    }


    /**
     * Menampilkan file confusion matrix.
     */
    public function confusionMatrix()
{
    $file = base_path('storage/app/evaluation/confusion_matrix_normalized.png');

    if (!file_exists($file)) {
        abort(404, 'Confusion matrix tidak ditemukan.');
    }

    return response()->file($file);
}
}