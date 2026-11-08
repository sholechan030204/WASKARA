@extends('layouts.app')

@section('content')

<div class="w-full space-y-6">

    {{-- =====================================================
         HEADER
    ====================================================== --}}
    <div>

        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
            Evaluasi Model YOLOv11
        </h1>

        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Hasil evaluasi model berdasarkan results.csv hasil training YOLOv11.
        </p>

    </div>


    {{-- =====================================================
         STATUS
    ====================================================== --}}

    @if($metrics['epoch'] !== null)

        <div class="rounded-2xl border border-green-200 bg-green-50 p-5
                    dark:border-green-900 dark:bg-green-950/20">

            <p class="text-sm font-semibold text-green-800 dark:text-green-300">
                Data evaluasi berhasil dimuat
            </p>

            <p class="mt-1 text-sm text-green-700 dark:text-green-400">
                Data berasal dari hasil training pada epoch
                {{ $metrics['epoch'] }}.
            </p>

        </div>

    @else

        <div class="rounded-2xl border border-yellow-200 bg-yellow-50 p-5">

            <p class="text-sm font-semibold text-yellow-800">
                Data evaluasi belum tersedia
            </p>

        </div>

    @endif


    {{-- =====================================================
         INFORMASI MODEL
    ====================================================== --}}

    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm
                dark:border-gray-800 dark:bg-gray-900">

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">

            <div>

                <p class="text-xs font-semibold uppercase text-gray-500">
                    Model
                </p>

                <p class="mt-2 text-xl font-bold text-gray-900 dark:text-white">
                    YOLOv11
                </p>

            </div>


            <div>

                <p class="text-xs font-semibold uppercase text-gray-500">
                    Dataset
                </p>

                <p class="mt-2 text-xl font-bold text-gray-900 dark:text-white">
                    Helmet Detection
                </p>

            </div>


            <div>

                <p class="text-xs font-semibold uppercase text-gray-500">
                    Epoch
                </p>

                <p class="mt-2 text-xl font-bold text-gray-900 dark:text-white">
                    {{ $metrics['epoch'] ?? '—' }}
                </p>

            </div>

        </div>

    </div>


    {{-- =====================================================
         METRICS
    ====================================================== --}}

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">

        {{-- =================================================
             PRECISION
        ================================================== --}}

        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm
                    dark:border-gray-800 dark:bg-gray-900">

            <p class="text-sm text-gray-500">
                Precision
            </p>

            <p class="mt-3 text-3xl font-bold text-gray-900 dark:text-white">

                @if($metrics['precision'] !== null)

                    {{ number_format(
                        $metrics['precision'] * 100,
                        2
                    ) }}%

                @else

                    —

                @endif

            </p>

            <p class="mt-2 text-xs text-gray-500">
                Ketepatan prediksi positif
            </p>

        </div>


        {{-- =================================================
             RECALL
        ================================================== --}}

        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm
                    dark:border-gray-800 dark:bg-gray-900">

            <p class="text-sm text-gray-500">
                Recall
            </p>

            <p class="mt-3 text-3xl font-bold text-gray-900 dark:text-white">

                @if($metrics['recall'] !== null)

                    {{ number_format(
                        $metrics['recall'] * 100,
                        2
                    ) }}%

                @else

                    —

                @endif

            </p>

            <p class="mt-2 text-xs text-gray-500">
                Kemampuan menemukan objek
            </p>

        </div>


        {{-- =================================================
             MAP50
        ================================================== --}}

        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm
                    dark:border-gray-800 dark:bg-gray-900">

            <p class="text-sm text-gray-500">
                mAP@50
            </p>

            <p class="mt-3 text-3xl font-bold text-gray-900 dark:text-white">

                @if($metrics['map50'] !== null)

                    {{ number_format(
                        $metrics['map50'] * 100,
                        2
                    ) }}%

                @else

                    —

                @endif

            </p>

            <p class="mt-2 text-xs text-gray-500">
                Mean Average Precision IoU 0.50
            </p>

        </div>


        {{-- =================================================
             MAP50-95
        ================================================== --}}

        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm
                    dark:border-gray-800 dark:bg-gray-900">

            <p class="text-sm text-gray-500">
                mAP@50-95
            </p>

            <p class="mt-3 text-3xl font-bold text-gray-900 dark:text-white">

                @if($metrics['map5095'] !== null)

                    {{ number_format(
                        $metrics['map5095'] * 100,
                        2
                    ) }}%

                @else

                    —

                @endif

            </p>

            <p class="mt-2 text-xs text-gray-500">
                Mean Average Precision IoU 0.50–0.95
            </p>

        </div>

    </div>


    {{-- =====================================================
         INFERENCE SPEED & FPS
    ====================================================== --}}

    <div class="grid gap-4 sm:grid-cols-2">


        {{-- =================================================
             INFERENCE SPEED
        ================================================== --}}

        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm
                    dark:border-gray-800 dark:bg-gray-900">

            <p class="text-sm text-gray-500">
                Inference Speed
            </p>

            <p class="mt-3 text-3xl font-bold text-gray-900 dark:text-white">

                {{ number_format(
                    $metrics['inference_speed'],
                    2,
                    ',',
                    '.'
                ) }}

                <span class="text-lg">
                    ms
                </span>

            </p>

            <p class="mt-2 text-xs text-gray-500">
                Rata-rata waktu pemrosesan satu frame
            </p>

        </div>


        {{-- =================================================
             FPS
        ================================================== --}}

        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm
                    dark:border-gray-800 dark:bg-gray-900">

            <p class="text-sm text-gray-500">
                FPS
            </p>

            <p class="mt-3 text-3xl font-bold text-gray-900 dark:text-white">

                @if(isset($metrics['fps']))

                    {{ number_format(
                        $metrics['fps'],
                        2,
                        ',',
                        '.'
                    ) }}

                    <span class="text-lg">
                        FPS
                    </span>

                @else

                    —

                @endif

            </p>

            <p class="mt-2 text-xs text-gray-500">
                Berdasarkan rata-rata inference speed
            </p>

        </div>

    </div>


    {{-- =========================================================
         CONFUSION MATRIX
    ========================================================= --}}

    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm
                dark:border-gray-800 dark:bg-gray-900">

        <div class="mb-5">

            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                Confusion Matrix
            </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Confusion matrix hasil evaluasi model YOLOv11.
            </p>

        </div>


        @if($confusionMatrixExists)

            {{-- =================================================
                 GAMBAR CONFUSION MATRIX ASLI
            ================================================== --}}

            <div class="rounded-xl bg-gray-50 p-5
                        dark:bg-gray-800/50">

                <div class="flex justify-center">

                    <img
                        src="{{ route('evaluation.confusion-matrix') }}"
                        alt="Confusion Matrix YOLOv11"
                        class="max-w-full rounded-xl shadow-sm"
                    >

                </div>

                <div class="mt-5 text-center">

                    <p class="text-sm font-semibold
                              text-gray-700 dark:text-gray-300">

                        Confusion Matrix YOLOv11

                    </p>

                    <p class="mt-1 text-xs
                              text-gray-500 dark:text-gray-400">

                        Gambar berasal dari hasil evaluasi model YOLOv11.

                    </p>

                </div>

            </div>

        @else

            {{-- =================================================
                 JIKA FILE TIDAK DITEMUKAN
            ================================================== --}}

            <div class="flex min-h-[280px]
                        items-center justify-center
                        rounded-xl bg-gray-50
                        dark:bg-gray-800/50">

                <div class="text-center">

                    <p class="text-sm font-semibold
                              text-red-600">

                        Confusion Matrix belum ditemukan.

                    </p>

                    <p class="mt-2 text-xs text-gray-500">

                        Pastikan file berada di:

                    </p>

                    <p class="mt-1 text-xs font-mono text-gray-600">

                        storage/app/evaluation/confusion_matrix_normalized.png

                    </p>

                </div>

            </div>

        @endif

    </div>


    {{-- =========================================================
         RIWAYAT TRAINING
    ========================================================= --}}

    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm
                dark:border-gray-800 dark:bg-gray-900">

        <div class="mb-5">

            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                Riwayat Training
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Data berasal dari results.csv.
            </p>

        </div>


        <div class="overflow-x-auto">

            <table class="w-full text-left text-sm">

                <thead>

                    <tr class="border-b border-gray-200 dark:border-gray-800">

                        <th class="px-4 py-3 font-semibold text-gray-600">
                            Epoch
                        </th>

                        <th class="px-4 py-3 font-semibold text-gray-600">
                            Precision
                        </th>

                        <th class="px-4 py-3 font-semibold text-gray-600">
                            Recall
                        </th>

                        <th class="px-4 py-3 font-semibold text-gray-600">
                            mAP50
                        </th>

                        <th class="px-4 py-3 font-semibold text-gray-600">
                            mAP50-95
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse(
                        array_reverse(
                            array_slice(
                                $results,
                                -10
                            )
                        ) as $row
                    )

                        <tr class="border-b border-gray-100
                                   dark:border-gray-800">

                            <td class="px-4 py-3 font-medium">
                                {{ $row['epoch'] ?? '—' }}
                            </td>


                            <td class="px-4 py-3">

                                @if(isset($row['metrics/precision(B)']))

                                    {{ number_format(
                                        (float)$row['metrics/precision(B)'] * 100,
                                        2
                                    ) }}%

                                @else

                                    —

                                @endif

                            </td>


                            <td class="px-4 py-3">

                                @if(isset($row['metrics/recall(B)']))

                                    {{ number_format(
                                        (float)$row['metrics/recall(B)'] * 100,
                                        2
                                    ) }}%

                                @else

                                    —

                                @endif

                            </td>


                            <td class="px-4 py-3">

                                @if(isset($row['metrics/mAP50(B)']))

                                    {{ number_format(
                                        (float)$row['metrics/mAP50(B)'] * 100,
                                        2
                                    ) }}%

                                @else

                                    —

                                @endif

                            </td>


                            <td class="px-4 py-3">

                                @if(isset($row['metrics/mAP50-95(B)']))

                                    {{ number_format(
                                        (float)$row['metrics/mAP50-95(B)'] * 100,
                                        2
                                    ) }}%

                                @else

                                    —

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="5"
                                class="px-4 py-10 text-center text-gray-500"
                            >

                                Data training belum tersedia.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>


    {{-- =====================================================
         SUMBER DATA
    ====================================================== --}}

    <div class="rounded-2xl border border-blue-200 bg-blue-50 p-5">

        <p class="text-sm font-semibold text-blue-800">
            Sumber Data Evaluasi
        </p>

        <p class="mt-1 text-sm text-blue-700">

            Precision, Recall, mAP@50, dan mAP@50-95
            berasal dari results.csv hasil training YOLOv11.

            Confusion Matrix berasal dari
            confusion_matrix_normalized.png hasil evaluasi YOLOv11.

        </p>

    </div>

</div>

@endsection