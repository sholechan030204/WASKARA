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
                Dashboard
            </h1>

            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                Ringkasan sistem deteksi penggunaan helm.
            </p>

        </div>


        {{-- STATUS SISTEM --}}

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
        STATISTIC CARDS
    ====================================================== --}}

    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">


        {{-- TOTAL DETEKSI --}}

        <div
            class="rounded-2xl border border-gray-200 bg-white p-5
                   shadow-sm transition hover:-translate-y-0.5 hover:shadow-md
                   dark:border-gray-800 dark:bg-gray-900"
        >

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        Total Deteksi
                    </p>

                    <p class="mt-3 text-3xl font-bold text-gray-900 dark:text-white">
                        {{ number_format($totalDetections) }}
                    </p>

                </div>

                <div
                    class="flex h-11 w-11 items-center justify-center
                           rounded-xl bg-blue-50 text-blue-600
                           dark:bg-blue-950/40 dark:text-blue-400"
                >

                    <svg
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                        />
                    </svg>

                </div>

            </div>

            <p class="mt-4 text-xs text-gray-500 dark:text-gray-400">
                Seluruh hasil deteksi YOLOv11
            </p>

        </div>


        {{-- WITH HELMET --}}

        <div
            class="rounded-2xl border border-gray-200 bg-white p-5
                   shadow-sm transition hover:-translate-y-0.5 hover:shadow-md
                   dark:border-gray-800 dark:bg-gray-900"
        >

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        With Helmet
                    </p>

                    <p class="mt-3 text-3xl font-bold text-gray-900 dark:text-white">
                        {{ number_format($withHelmet) }}
                    </p>

                </div>

                <div
                    class="flex h-11 w-11 items-center justify-center
                           rounded-xl bg-green-50 text-green-600
                           dark:bg-green-950/40 dark:text-green-400"
                >

                    <svg
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M5 13l4 4L19 7"
                        />
                    </svg>

                </div>

            </div>

            <div class="mt-4 flex items-center justify-between">

                <span class="text-xs text-gray-500 dark:text-gray-400">
                    Pengendara memakai helm
                </span>

                <span class="text-xs font-semibold text-green-600 dark:text-green-400">
                    {{ $helmetPercentage }}%
                </span>

            </div>

        </div>


        {{-- WITHOUT HELMET --}}

        <div
            class="rounded-2xl border border-gray-200 bg-white p-5
                   shadow-sm transition hover:-translate-y-0.5 hover:shadow-md
                   dark:border-gray-800 dark:bg-gray-900"
        >

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        Without Helmet
                    </p>

                    <p class="mt-3 text-3xl font-bold text-gray-900 dark:text-white">
                        {{ number_format($withoutHelmet) }}
                    </p>

                </div>

                <div
                    class="flex h-11 w-11 items-center justify-center
                           rounded-xl bg-red-50 text-red-600
                           dark:bg-red-950/40 dark:text-red-400"
                >

                    <svg
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>

                </div>

            </div>

            <div class="mt-4 flex items-center justify-between">

                <span class="text-xs text-gray-500 dark:text-gray-400">
                    Pengendara tanpa helm
                </span>

                <span class="text-xs font-semibold text-red-600 dark:text-red-400">
                    {{ $withoutHelmetPercentage }}%
                </span>

            </div>

        </div>


        {{-- TOTAL SESSION --}}

        <div
            class="rounded-2xl border border-gray-200 bg-white p-5
                   shadow-sm transition hover:-translate-y-0.5 hover:shadow-md
                   dark:border-gray-800 dark:bg-gray-900"
        >

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        Detection Session
                    </p>

                    <p class="mt-3 text-3xl font-bold text-gray-900 dark:text-white">
                        {{ number_format($totalSessions) }}
                    </p>

                </div>

                <div
                    class="flex h-11 w-11 items-center justify-center
                           rounded-xl bg-purple-50 text-purple-600
                           dark:bg-purple-950/40 dark:text-purple-400"
                >

                    <svg
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M12 8v4l3 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z"
                        />
                    </svg>

                </div>

            </div>

            <p class="mt-4 text-xs text-gray-500 dark:text-gray-400">
                Total sesi deteksi
            </p>

        </div>

    </div>


    {{-- =====================================================
        STATISTIK PELANGGARAN
    ====================================================== --}}

    <div class="grid grid-cols-1 gap-5 md:grid-cols-3">


        {{-- TOTAL PELANGGARAN --}}

        <div
            class="rounded-2xl border border-red-200 bg-red-50 p-6
                   shadow-sm dark:border-red-900/40 dark:bg-red-950/20"
        >

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-sm font-medium text-red-600 dark:text-red-400">
                        Total Pelanggaran
                    </p>

                    <p class="mt-3 text-3xl font-bold text-red-700 dark:text-red-300">
                        {{ number_format($totalViolations) }}
                    </p>

                </div>

                <div
                    class="flex h-11 w-11 items-center justify-center
                           rounded-xl bg-red-100 text-red-600
                           dark:bg-red-900/40 dark:text-red-400"
                >

                    <svg
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M12 9v4m0 4h.01M10.3 3.7l-8 14A2 2 0 004 20.7h16a2 2 0 001.7-3l-8-14a2 2 0 00-3.4 0z"
                        />
                    </svg>

                </div>

            </div>

            <p class="mt-4 text-xs text-red-600 dark:text-red-400">
                Pelanggaran tanpa helm tersimpan
            </p>

        </div>


        {{-- PELANGGARAN HARI INI --}}

        <div
            class="rounded-2xl border border-orange-200 bg-orange-50 p-6
                   shadow-sm dark:border-orange-900/40 dark:bg-orange-950/20"
        >

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-sm font-medium text-orange-600 dark:text-orange-400">
                        Pelanggaran Hari Ini
                    </p>

                    <p class="mt-3 text-3xl font-bold text-orange-700 dark:text-orange-300">
                        {{ number_format($todayViolations) }}
                    </p>

                </div>

                <div
                    class="flex h-11 w-11 items-center justify-center
                           rounded-xl bg-orange-100 text-orange-600
                           dark:bg-orange-900/40 dark:text-orange-400"
                >

                    <svg
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M12 6v6l4 2m5-2a9 9 0 11-18 0 9 9 0 0118 0z"
                        />
                    </svg>

                </div>

            </div>

            <p class="mt-4 text-xs text-orange-600 dark:text-orange-400">
                Berdasarkan waktu kejadian
            </p>

        </div>


        {{-- RATA-RATA CONFIDENCE --}}

        <div
            class="rounded-2xl border border-blue-200 bg-blue-50 p-6
                   shadow-sm dark:border-blue-900/40 dark:bg-blue-950/20"
        >

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-sm font-medium text-blue-600 dark:text-blue-400">
                        Rata-rata Confidence
                    </p>

                    <p class="mt-3 text-3xl font-bold text-blue-700 dark:text-blue-300">
                        {{ number_format($averageViolationConfidence, 2) }}%
                    </p>

                </div>

                <div
                    class="flex h-11 w-11 items-center justify-center
                           rounded-xl bg-blue-100 text-blue-600
                           dark:bg-blue-900/40 dark:text-blue-400"
                >

                    <svg
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M12 6v6l4 2m5-2a9 9 0 11-18 0 9 9 0 0118 0z"
                        />
                    </svg>

                </div>

            </div>

            <p class="mt-4 text-xs text-blue-600 dark:text-blue-400">
                Rata-rata confidence pelanggaran
            </p>

        </div>

    </div>


    {{-- =====================================================
        DISTRIBUSI + STATUS SISTEM
    ====================================================== --}}

    <div class="grid grid-cols-1 gap-5 xl:grid-cols-3">


        {{-- DISTRIBUSI DETEKSI --}}

        <div
            class="rounded-2xl border border-gray-200 bg-white p-6
                   shadow-sm xl:col-span-2
                   dark:border-gray-800 dark:bg-gray-900"
        >

            <div class="flex items-center justify-between">

                <div>

                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Distribusi Deteksi
                    </h2>

                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Perbandingan penggunaan helm.
                    </p>

                </div>

                <span
                    class="rounded-lg bg-gray-100 px-3 py-1.5
                           text-xs font-medium text-gray-600
                           dark:bg-gray-800 dark:text-gray-300"
                >
                    YOLOv11
                </span>

            </div>


            <div class="mt-8 space-y-6">

                {{-- WITH HELMET --}}

                <div>

                    <div class="mb-2 flex items-center justify-between">

                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                            With Helmet
                        </span>

                        <span class="text-sm font-semibold text-gray-900 dark:text-white">
                            {{ $withHelmet }}
                        </span>

                    </div>

                    <div class="h-3 overflow-hidden rounded-full bg-gray-100 dark:bg-gray-800">

                        <div
                            class="h-full rounded-full bg-green-500 transition-all duration-700"
                            style="width: {{ $helmetPercentage }}%"
                        ></div>

                    </div>

                </div>


                {{-- WITHOUT HELMET --}}

                <div>

                    <div class="mb-2 flex items-center justify-between">

                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                            Without Helmet
                        </span>

                        <span class="text-sm font-semibold text-gray-900 dark:text-white">
                            {{ $withoutHelmet }}
                        </span>

                    </div>

                    <div class="h-3 overflow-hidden rounded-full bg-gray-100 dark:bg-gray-800">

                        <div
                            class="h-full rounded-full bg-red-500 transition-all duration-700"
                            style="width: {{ $withoutHelmetPercentage }}%"
                        ></div>

                    </div>

                </div>

            </div>


            {{-- PERCENTAGE --}}

            <div class="mt-8 grid grid-cols-2 gap-4">

                <div
                    class="rounded-xl border border-green-100 bg-green-50 p-4
                           dark:border-green-900/40 dark:bg-green-950/20"
                >

                    <p class="text-xs font-medium text-green-600 dark:text-green-400">
                        Menggunakan Helm
                    </p>

                    <p class="mt-1 text-2xl font-bold text-green-700 dark:text-green-300">
                        {{ $helmetPercentage }}%
                    </p>

                </div>


                <div
                    class="rounded-xl border border-red-100 bg-red-50 p-4
                           dark:border-red-900/40 dark:bg-red-950/20"
                >

                    <p class="text-xs font-medium text-red-600 dark:text-red-400">
                        Tanpa Helm
                    </p>

                    <p class="mt-1 text-2xl font-bold text-red-700 dark:text-red-300">
                        {{ $withoutHelmetPercentage }}%
                    </p>

                </div>

            </div>

        </div>


        {{-- STATUS SISTEM --}}

        <div
            class="rounded-2xl border border-gray-200 bg-white p-6
                   shadow-sm dark:border-gray-800 dark:bg-gray-900"
        >

            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                Status Sistem
            </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Komponen utama WASKARA.
            </p>


            <div class="mt-6 space-y-4">

                {{-- YOLO --}}

                <div
                    class="flex items-center justify-between rounded-xl
                           bg-gray-50 p-4 dark:bg-gray-800/60"
                >

                    <div class="flex items-center gap-3">

                        <span class="h-3 w-3 rounded-full bg-green-500"></span>

                        <div>

                            <p class="text-sm font-medium text-gray-800 dark:text-gray-200">
                                YOLOv11
                            </p>

                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                Detection Model
                            </p>

                        </div>

                    </div>

                    <span class="text-xs font-semibold text-green-600 dark:text-green-400">
                        AKTIF
                    </span>

                </div>


                {{-- REALTIME --}}

                <div
                    class="flex items-center justify-between rounded-xl
                           bg-gray-50 p-4 dark:bg-gray-800/60"
                >

                    <div class="flex items-center gap-3">

                        <span class="h-3 w-3 rounded-full bg-green-500"></span>

                        <div>

                            <p class="text-sm font-medium text-gray-800 dark:text-gray-200">
                                Real-Time
                            </p>

                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                Detection Service
                            </p>

                        </div>

                    </div>

                    <span class="text-xs font-semibold text-green-600 dark:text-green-400">
                        READY
                    </span>

                </div>


                {{-- DATABASE --}}

                <div
                    class="flex items-center justify-between rounded-xl
                           bg-gray-50 p-4 dark:bg-gray-800/60"
                >

                    <div class="flex items-center gap-3">

                        <span class="h-3 w-3 rounded-full bg-green-500"></span>

                        <div>

                            <p class="text-sm font-medium text-gray-800 dark:text-gray-200">
                                Database
                            </p>

                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                Detection Records
                            </p>

                        </div>

                    </div>

                    <span class="text-xs font-semibold text-green-600 dark:text-green-400">
                        AKTIF
                    </span>

                </div>

            </div>


            {{-- BUTTON --}}

            <a
                href="{{ route('detection.index') }}"
                class="mt-6 flex w-full items-center justify-center
                       rounded-xl bg-blue-600 px-4 py-3
                       text-sm font-semibold text-white
                       transition hover:bg-blue-700"
            >
                Buka Deteksi Real-Time
            </a>

        </div>

    </div>


    {{-- =====================================================
        DETEKSI TERBARU
    ====================================================== --}}

    <div
        class="overflow-hidden rounded-2xl border border-gray-200
               bg-white shadow-sm
               dark:border-gray-800 dark:bg-gray-900"
    >

        <div
            class="border-b border-gray-200 px-6 py-5
                   dark:border-gray-800"
        >

            <div class="flex items-center justify-between">

                <div>

                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Deteksi Terbaru
                    </h2>

                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Lima hasil deteksi terakhir.
                    </p>

                </div>

                <a
                    href="{{ route('detection.index') }}"
                    class="text-sm font-semibold text-blue-600
                           hover:text-blue-700 dark:text-blue-400"
                >
                    Deteksi →
                </a>

            </div>

        </div>


        <div class="overflow-x-auto">

            <table class="w-full min-w-[600px] text-left">

                <thead class="bg-gray-50 dark:bg-gray-800/50">

                    <tr>

                        <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Class
                        </th>

                        <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Confidence
                        </th>

                        <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Waktu
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">

                    @forelse($recentDetections as $detection)

                        <tr class="transition hover:bg-gray-50 dark:hover:bg-gray-800/40">

                            <td class="px-6 py-4">

                                @if($detection->class_name === 'With_helmet')

                                    <span
                                        class="inline-flex rounded-full bg-green-50 px-3 py-1
                                               text-xs font-semibold text-green-700
                                               dark:bg-green-950/30 dark:text-green-400"
                                    >
                                        With Helmet
                                    </span>

                                @else

                                    <span
                                        class="inline-flex rounded-full bg-red-50 px-3 py-1
                                               text-xs font-semibold text-red-700
                                               dark:bg-red-950/30 dark:text-red-400"
                                    >
                                        Without Helmet
                                    </span>

                                @endif

                            </td>


                            <td class="px-6 py-4 text-sm font-medium text-gray-700 dark:text-gray-300">

                                {{ number_format($detection->confidence * 100, 1) }}%

                            </td>


                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">

                                {{ $detection->created_at?->format('d M Y, H:i') ?? '-' }}

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="3"
                                class="px-6 py-10 text-center text-sm text-gray-500 dark:text-gray-400"
                            >
                                Belum ada data deteksi.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>


    {{-- =====================================================
        PELANGGARAN TERBARU
    ====================================================== --}}

    <div
        class="overflow-hidden rounded-2xl border border-red-100
               bg-white shadow-sm
               dark:border-red-900/30 dark:bg-gray-900"
    >

        <div
            class="border-b border-red-100 px-6 py-5
                   dark:border-red-900/30"
        >

            <div class="flex items-center justify-between">

                <div>

                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Pelanggaran Terbaru
                    </h2>

                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Lima pelanggaran tanpa helm terakhir.
                    </p>

                </div>

                <a
                    href="{{ route('violations.index') }}"
                    class="text-sm font-semibold text-red-600
                           hover:text-red-700 dark:text-red-400"
                >
                    Lihat Semua →
                </a>

            </div>

        </div>


        <div class="overflow-x-auto">

            <table class="w-full min-w-[700px] text-left">

                <thead class="bg-red-50/50 dark:bg-red-950/10">

                    <tr>

                        <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">
                            No
                        </th>

                        <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Waktu
                        </th>

                        <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Sumber
                        </th>

                        <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Confidence
                        </th>

                        <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Status
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">

                    @forelse($recentViolations as $index => $violation)

                        <tr class="transition hover:bg-red-50/30 dark:hover:bg-red-950/10">

                            <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">
                                {{ $index + 1 }}
                            </td>


                            <td class="px-6 py-4">

                                <p class="text-sm font-semibold text-gray-800 dark:text-gray-200">
                                    {{ $violation->occurred_at?->format('d/m/Y') ?? '-' }}
                                </p>

                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $violation->occurred_at?->format('H:i:s') ?? '-' }}
                                </p>

                            </td>


                            <td class="px-6 py-4">

                                <p class="text-sm font-semibold text-gray-800 dark:text-gray-200">
                                    {{ $violation->location ?? '-' }}
                                </p>

                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $violation->violation_type ?? '-' }}
                                </p>

                            </td>


                            <td class="px-6 py-4 text-sm font-semibold text-red-600 dark:text-red-400">

                                {{ number_format($violation->confidence * 100, 2) }}%

                            </td>


                            <td class="px-6 py-4">

                                <span
                                    class="inline-flex rounded-full
                                           bg-green-50 px-3 py-1
                                           text-xs font-semibold text-green-700
                                           dark:bg-green-950/30 dark:text-green-400"
                                >
                                    {{ ucfirst($violation->status ?? 'detected') }}
                                </span>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="5"
                                class="px-6 py-10 text-center"
                            >

                                <div class="text-sm font-medium text-gray-600 dark:text-gray-400">
                                    Belum ada pelanggaran.
                                </div>

                                <div class="mt-1 text-xs text-gray-400 dark:text-gray-500">
                                    Hasil deteksi without_helmet akan muncul di sini.
                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>


</div>

@endsection