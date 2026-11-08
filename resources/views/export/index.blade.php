@extends('layouts.app')

@section('content')

<div class="w-full space-y-6">

    {{-- HEADER --}}
    <div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
            Export Data
        </h1>

        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Export data pelanggaran hasil deteksi YOLOv11.
        </p>
    </div>


    {{-- INFORMASI --}}
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">

        {{-- TOTAL PELANGGARAN --}}
        <div
            class="rounded-2xl border border-gray-200
                   bg-white p-6 shadow-sm
                   dark:border-gray-800 dark:bg-gray-900"
        >

            <p class="text-sm text-gray-500 dark:text-gray-400">
                Total Pelanggaran
            </p>

            <p
                class="mt-3 text-3xl font-bold
                       text-gray-900 dark:text-white"
            >
                {{ $totalViolations }}
            </p>

            <p class="mt-2 text-xs text-gray-500">
                Data tanpa helm
            </p>

        </div>


        {{-- HARI INI --}}
        <div
            class="rounded-2xl border border-gray-200
                   bg-white p-6 shadow-sm
                   dark:border-gray-800 dark:bg-gray-900"
        >

            <p class="text-sm text-gray-500 dark:text-gray-400">
                Pelanggaran Hari Ini
            </p>

            <p
                class="mt-3 text-3xl font-bold
                       text-gray-900 dark:text-white"
            >
                {{ $todayViolations }}
            </p>

            <p class="mt-2 text-xs text-gray-500">
                Pelanggaran pada hari ini
            </p>

        </div>


        {{-- TERAKHIR --}}
        <div
            class="rounded-2xl border border-gray-200
                   bg-white p-6 shadow-sm
                   dark:border-gray-800 dark:bg-gray-900"
        >

            <p class="text-sm text-gray-500 dark:text-gray-400">
                Pelanggaran Terakhir
            </p>

            <p
                class="mt-3 text-lg font-bold
                       text-gray-900 dark:text-white"
            >
                @if($lastViolation)

                    {{ $lastViolation->occurred_at }}

                @else

                    Belum ada data

                @endif
            </p>

            <p class="mt-2 text-xs text-gray-500">
                Waktu pelanggaran terakhir
            </p>

        </div>

    </div>


    {{-- EXPORT CARD --}}
    <div
        class="rounded-2xl border border-gray-200
               bg-white p-6 shadow-sm
               dark:border-gray-800 dark:bg-gray-900"
    >

        <div class="mb-6">

            <h2
                class="text-xl font-semibold
                       text-gray-900 dark:text-white"
            >
                Export Data Pelanggaran
            </h2>

            <p
                class="mt-1 text-sm
                       text-gray-500 dark:text-gray-400"
            >
                Download seluruh data pelanggaran tanpa helm
                dalam format CSV.
            </p>

        </div>


        {{-- DOWNLOAD BUTTON --}}
        <a
            href="{{ route('violations.export') }}"
            class="inline-flex items-center gap-2
                   rounded-xl bg-blue-600
                   px-5 py-3
                   text-sm font-semibold
                   text-white
                   transition
                   hover:bg-blue-700"
        >

            <svg
                class="h-5 w-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="1.8"
            >

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M12 3v12"
                />

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M8 11l4 4 4-4"
                />

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M5 21h14"
                />

            </svg>

            Download CSV

        </a>

    </div>


    {{-- INFORMASI FORMAT --}}
    <div
        class="rounded-2xl border border-blue-200
               bg-blue-50 p-5
               dark:border-blue-900
               dark:bg-blue-950/20"
    >

        <p
            class="text-sm font-semibold
                   text-blue-800 dark:text-blue-300"
        >
            Informasi Export
        </p>

        <p
            class="mt-1 text-sm
                   text-blue-700 dark:text-blue-400"
        >
            File yang diunduh berisi data pelanggaran
            tanpa helm yang tersimpan pada sistem WASKARA.
        </p>

        <p
            class="mt-2 text-xs
                   text-blue-600 dark:text-blue-400"
        >
            Format file: CSV
        </p>

    </div>

</div>

@endsection