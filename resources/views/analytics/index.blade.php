@extends('layouts.app')

@section('content')

<div class="space-y-6">

    {{-- =====================================================
        HEADER
    ====================================================== --}}

    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>

            <p class="text-sm font-semibold text-blue-600 dark:text-blue-400">
                WASKARA • YOLOv11
            </p>

            <h1 class="mt-1 text-3xl font-bold tracking-tight text-gray-900 dark:text-white">
                Analytics
            </h1>

            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                Analisis hasil deteksi penggunaan helm.
            </p>

        </div>


        <div
            class="inline-flex w-fit items-center gap-2 rounded-full
                   border border-green-200 bg-green-50 px-4 py-2
                   text-sm font-semibold text-green-700
                   dark:border-green-900/50
                   dark:bg-green-950/30
                   dark:text-green-400"
        >

            <span class="h-2.5 w-2.5 rounded-full bg-green-500"></span>

            Sistem Aktif

        </div>

    </div>


    {{-- =====================================================
        STATISTICS
    ====================================================== --}}

    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">


        {{-- TOTAL DETEKSI --}}

        <div
            class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm
                   dark:border-gray-800 dark:bg-gray-900"
        >

            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                Total Deteksi
            </p>

            <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                {{ number_format($totalDetections) }}
            </p>

            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                Seluruh objek terdeteksi
            </p>

        </div>


        {{-- WITH HELMET --}}

        <div
            class="rounded-2xl border border-green-100 bg-green-50 p-5 shadow-sm
                   dark:border-green-900/40 dark:bg-green-950/20"
        >

            <p class="text-sm font-medium text-green-700 dark:text-green-400">
                With Helmet
            </p>

            <p class="mt-2 text-3xl font-bold text-green-800 dark:text-green-300">
                {{ number_format($withHelmet) }}
            </p>

            <p class="mt-2 text-xs text-green-600 dark:text-green-400">
                {{ $helmetPercentage }}% dari total deteksi
            </p>

        </div>


        {{-- WITHOUT HELMET --}}

        <div
            class="rounded-2xl border border-red-100 bg-red-50 p-5 shadow-sm
                   dark:border-red-900/40 dark:bg-red-950/20"
        >

            <p class="text-sm font-medium text-red-700 dark:text-red-400">
                Without Helmet
            </p>

            <p class="mt-2 text-3xl font-bold text-red-800 dark:text-red-300">
                {{ number_format($withoutHelmet) }}
            </p>

            <p class="mt-2 text-xs text-red-600 dark:text-red-400">
                {{ $withoutHelmetPercentage }}% dari total deteksi
            </p>

        </div>


        {{-- CONFIDENCE --}}

        <div
            class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm
                   dark:border-gray-800 dark:bg-gray-900"
        >

            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                Rata-rata Confidence
            </p>

            <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                {{ $averageConfidence }}%
            </p>

            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                Confidence hasil deteksi
            </p>

        </div>

    </div>


    {{-- =====================================================
        CHARTS
    ====================================================== --}}

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">


        {{-- PIE CHART --}}

        <div
            class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm
                   dark:border-gray-800 dark:bg-gray-900"
        >

            <div>

                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Distribusi Penggunaan Helm
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Perbandingan pengendara dengan dan tanpa helm.
                </p>

            </div>


            <div class="mx-auto mt-6 max-w-[360px]">

                <canvas id="helmetChart"></canvas>

            </div>

        </div>


        {{-- BAR CHART --}}

        <div
            class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm
                   dark:border-gray-800 dark:bg-gray-900"
        >

            <div>

                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Deteksi 7 Hari Terakhir
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Jumlah deteksi berdasarkan tanggal.
                </p>

            </div>


            <div class="mt-8">

                <canvas id="dailyChart"></canvas>

            </div>

        </div>

    </div>


    {{-- =====================================================
        SESSION + RECENT DETECTION
    ====================================================== --}}

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">


        {{-- SESSION --}}

        <div
            class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm
                   dark:border-gray-800 dark:bg-gray-900"
        >

            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                Detection Session
            </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Total sesi deteksi.
            </p>


            <p class="mt-8 text-5xl font-bold text-gray-900 dark:text-white">
                {{ number_format($totalSessions) }}
            </p>


            <div
                class="mt-6 rounded-xl bg-gray-50 p-4
                       dark:bg-gray-800/60"
            >

                <p class="text-xs text-gray-500 dark:text-gray-400">
                    Sistem menggunakan
                </p>

                <p class="mt-1 font-semibold text-gray-900 dark:text-white">
                    YOLOv11
                </p>

            </div>

        </div>


        {{-- RECENT DETECTIONS --}}

        <div
            class="overflow-hidden rounded-2xl border border-gray-200
                   bg-white shadow-sm xl:col-span-2
                   dark:border-gray-800 dark:bg-gray-900"
        >

            <div
                class="border-b border-gray-200 px-6 py-5
                       dark:border-gray-800"
            >

                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Deteksi Terbaru
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Sepuluh hasil deteksi terakhir.
                </p>

            </div>


            <div class="overflow-x-auto">

                <table class="w-full min-w-[500px]">

                    <thead class="bg-gray-50 dark:bg-gray-800/50">

                        <tr>

                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-500">
                                Class
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-500">
                                Confidence
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-500">
                                Waktu
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">

                        @forelse($recentDetections as $detection)

                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40">

                                <td class="px-6 py-4">

                                    @if($detection->class_name === 'With_helmet')

                                        <span
                                            class="rounded-full bg-green-50 px-3 py-1
                                                   text-xs font-semibold text-green-700
                                                   dark:bg-green-950/30
                                                   dark:text-green-400"
                                        >
                                            With Helmet
                                        </span>

                                    @else

                                        <span
                                            class="rounded-full bg-red-50 px-3 py-1
                                                   text-xs font-semibold text-red-700
                                                   dark:bg-red-950/30
                                                   dark:text-red-400"
                                        >
                                            Without Helmet
                                        </span>

                                    @endif

                                </td>


                                <td class="px-6 py-4 text-sm font-semibold text-gray-700 dark:text-gray-300">

                                    {{ number_format($detection->confidence * 100, 1) }}%

                                </td>


                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">

                                    {{ $detection->created_at?->format('d M Y H:i') ?? '-' }}

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="3"
                                    class="px-6 py-10 text-center text-sm text-gray-500"
                                >
                                    Belum ada data deteksi.
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>


{{-- =====================================================
    CHART.JS
====================================================== --}}

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script>

document.addEventListener('DOMContentLoaded', function () {

    // =====================================================
    // PIE CHART
    // =====================================================

    const helmetCanvas =
        document.getElementById('helmetChart');

    if (helmetCanvas) {

        new Chart(helmetCanvas, {

            type: 'doughnut',

            data: {

                labels: [
                    'With Helmet',
                    'Without Helmet'
                ],

                datasets: [{

                    data: [
                        {{ $withHelmet }},
                        {{ $withoutHelmet }}
                    ],

                    backgroundColor: [
                        '#22c55e',
                        '#ef4444'
                    ],

                    borderWidth: 0

                }]

            },

            options: {

                responsive: true,

                plugins: {

                    legend: {

                        position: 'bottom',

                        labels: {

                            padding: 20,

                            usePointStyle: true

                        }

                    }

                }

            }

        });

    }


    // =====================================================
    // DAILY CHART
    // =====================================================

    const dailyCanvas =
        document.getElementById('dailyChart');

    if (dailyCanvas) {

        new Chart(dailyCanvas, {

            type: 'bar',

            data: {

                labels: @json($dailyLabels),

                datasets: [

                    {

                        label: 'With Helmet',

                        data: @json($dailyWithHelmet),

                        backgroundColor: '#22c55e',

                        borderRadius: 6

                    },

                    {

                        label: 'Without Helmet',

                        data: @json($dailyWithoutHelmet),

                        backgroundColor: '#ef4444',

                        borderRadius: 6

                    }

                ]

            },

            options: {

                responsive: true,

                scales: {

                    y: {

                        beginAtZero: true,

                        ticks: {

                            precision: 0

                        }

                    }

                },

                plugins: {

                    legend: {

                        position: 'bottom',

                        labels: {

                            usePointStyle: true,

                            padding: 20

                        }

                    }

                }

            }

        });

    }

});

</script>

@endsection