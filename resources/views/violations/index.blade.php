@extends('layouts.app')

@section('content')

<div class="w-full space-y-6">

    {{-- =====================================================
        HEADER
    ====================================================== --}}

    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>

            <h1 class="text-3xl font-bold tracking-tight
                       text-gray-900 dark:text-white">

                Riwayat Pelanggaran

            </h1>

            <p class="mt-1 text-sm
                      text-gray-500 dark:text-gray-400">

                Daftar pelanggaran tanpa helm yang terdeteksi oleh YOLOv11.

            </p>

        </div>


        {{-- STATUS SISTEM --}}

        <div
            class="inline-flex w-fit items-center gap-2
                   rounded-full border border-green-200
                   bg-green-50 px-4 py-2
                   text-sm font-semibold text-green-700
                   dark:border-green-900
                   dark:bg-green-950/30
                   dark:text-green-400"
        >

            <span
                class="h-2.5 w-2.5 rounded-full bg-green-500"
            ></span>

            Sistem Aktif

        </div>

    </div>


    {{-- =====================================================
        FILTER TANGGAL
    ====================================================== --}}

    <div
        class="rounded-2xl border border-gray-200
               bg-white p-5 shadow-sm
               dark:border-gray-800
               dark:bg-gray-900"
    >

        <div
            class="flex flex-col gap-4
                   lg:flex-row lg:items-end lg:justify-between"
        >

            <div>

                <h2
                    class="text-lg font-semibold
                           text-gray-900 dark:text-white"
                >
                    Filter Riwayat
                </h2>

                <p
                    class="mt-1 text-sm
                           text-gray-500 dark:text-gray-400"
                >
                    Pilih tanggal untuk menampilkan pelanggaran
                    pada hari tertentu.
                </p>

            </div>


            {{-- FORM FILTER --}}

            <form
                method="GET"
                action="{{ route('violations.index') }}"
                class="flex flex-col gap-3 sm:flex-row sm:items-end"
            >

                {{-- TANGGAL --}}

                <div>

                    <label
                        for="date"
                        class="mb-2 block text-sm font-medium
                               text-gray-700 dark:text-gray-300"
                    >
                        Tanggal
                    </label>

                    <input
                        type="date"
                        id="date"
                        name="date"
                        value="{{ $selectedDate }}"
                        class="w-full rounded-xl border
                               border-gray-300 bg-white
                               px-4 py-2.5 text-sm
                               text-gray-900 outline-none
                               transition
                               focus:border-blue-500
                               focus:ring-4
                               focus:ring-blue-500/10
                               dark:border-gray-700
                               dark:bg-gray-800
                               dark:text-white
                               sm:w-52"
                    >

                </div>


                {{-- TOMBOL FILTER --}}

                <button
                    type="submit"
                    class="inline-flex items-center
                           justify-center gap-2
                           rounded-xl bg-blue-600
                           px-5 py-2.5
                           text-sm font-semibold
                           text-white
                           shadow-sm
                           transition
                           hover:bg-blue-700
                           focus:outline-none
                           focus:ring-4
                           focus:ring-blue-500/20"
                >

                    <svg
                        class="h-4 w-4"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M3 4h18M6 8h12M10 12h4M9 16h6M11 20h2"
                        />
                    </svg>

                    Filter

                </button>


                {{-- RESET --}}

                @if(!empty($selectedDate))

                    <a
                        href="{{ route('violations.index') }}"
                        class="inline-flex items-center
                               justify-center
                               rounded-xl border
                               border-gray-300
                               bg-white px-5 py-2.5
                               text-sm font-semibold
                               text-gray-700
                               transition
                               hover:bg-gray-50
                               dark:border-gray-700
                               dark:bg-gray-800
                               dark:text-gray-300
                               dark:hover:bg-gray-700"
                    >

                        Reset

                    </a>

                @endif

            </form>

        </div>


        {{-- INFORMASI FILTER AKTIF --}}

        @if(!empty($selectedDate))

            <div
                class="mt-4 rounded-xl
                       border border-blue-200
                       bg-blue-50 px-4 py-3
                       text-sm text-blue-700
                       dark:border-blue-900
                       dark:bg-blue-950/30
                       dark:text-blue-300"
            >

                Menampilkan pelanggaran pada tanggal:

                <strong>
                    {{ \Carbon\Carbon::parse($selectedDate)->format('d/m/Y') }}
                </strong>

            </div>

        @endif

    </div>


    {{-- =====================================================
        STATISTIK
    ====================================================== --}}

    <div class="grid gap-6 md:grid-cols-3">


        {{-- TOTAL --}}

        <div
            class="rounded-2xl border border-gray-200
                   bg-white p-6 shadow-sm
                   dark:border-gray-800
                   dark:bg-gray-900"
        >

            <p
                class="text-sm font-medium
                       text-gray-500 dark:text-gray-400"
            >

                @if(!empty($selectedDate))
                    Pelanggaran pada Tanggal
                @else
                    Total Pelanggaran
                @endif

            </p>

            <p
                class="mt-2 text-4xl font-bold
                       text-gray-900 dark:text-white"
            >
                {{ $totalViolations }}
            </p>

        </div>


        {{-- HARI INI --}}

        <div
            class="rounded-2xl border border-red-200
                   bg-red-50 p-6 shadow-sm
                   dark:border-red-900
                   dark:bg-red-950/20"
        >

            <p
                class="text-sm font-medium
                       text-red-600 dark:text-red-400"
            >
                Pelanggaran Hari Ini
            </p>

            <p
                class="mt-2 text-4xl font-bold
                       text-red-700 dark:text-red-400"
            >
                {{ $todayViolations }}
            </p>

        </div>


        {{-- RATA-RATA CONFIDENCE --}}

        <div
            class="rounded-2xl border border-blue-200
                   bg-blue-50 p-6 shadow-sm
                   dark:border-blue-900
                   dark:bg-blue-950/20"
        >

            <p
                class="text-sm font-medium
                       text-blue-600 dark:text-blue-400"
            >
                Rata-rata Confidence
            </p>

            <p
                class="mt-2 text-4xl font-bold
                       text-blue-700 dark:text-blue-400"
            >

                {{ number_format(
                    $averageConfidence * 100,
                    2
                ) }}%

            </p>

        </div>

    </div>


    {{-- =====================================================
        DAFTAR PELANGGARAN
    ====================================================== --}}

    <div
        class="overflow-hidden rounded-2xl
               border border-gray-200
               bg-white shadow-sm
               dark:border-gray-800
               dark:bg-gray-900"
    >

        {{-- HEADER --}}

        <div
            class="border-b border-gray-200
                   px-6 py-5
                   dark:border-gray-800"
        >

            <h2
                class="text-lg font-semibold
                       text-gray-900 dark:text-white"
            >
                Daftar Pelanggaran
            </h2>

            <p
                class="mt-1 text-sm
                       text-gray-500 dark:text-gray-400"
            >
                Pelanggaran tanpa helm yang tersimpan dalam sistem.
            </p>

        </div>


        {{-- =================================================
            TABLE
        ================================================== --}}

        <div class="overflow-x-auto">

            <table class="w-full text-left">

                <thead
                    class="bg-gray-50
                           dark:bg-gray-800/50"
                >

                    <tr>

                        {{-- NO --}}

                        <th
                            class="px-6 py-4 text-xs
                                   font-semibold uppercase
                                   tracking-wider
                                   text-gray-500
                                   dark:text-gray-400"
                        >
                            No
                        </th>


                        {{-- WAKTU --}}

                        <th
                            class="px-6 py-4 text-xs
                                   font-semibold uppercase
                                   tracking-wider
                                   text-gray-500
                                   dark:text-gray-400"
                        >
                            Waktu
                        </th>


                        {{-- SUMBER --}}

                        <th
                            class="px-6 py-4 text-xs
                                   font-semibold uppercase
                                   tracking-wider
                                   text-gray-500
                                   dark:text-gray-400"
                        >
                            Sumber
                        </th>


                        {{-- KELAS --}}

                        <th
                            class="px-6 py-4 text-xs
                                   font-semibold uppercase
                                   tracking-wider
                                   text-gray-500
                                   dark:text-gray-400"
                        >
                            Kelas
                        </th>


                        {{-- CONFIDENCE --}}

                        <th
                            class="px-6 py-4 text-xs
                                   font-semibold uppercase
                                   tracking-wider
                                   text-gray-500
                                   dark:text-gray-400"
                        >
                            Confidence
                        </th>


                        {{-- STATUS --}}

                        <th
                            class="px-6 py-4 text-xs
                                   font-semibold uppercase
                                   tracking-wider
                                   text-gray-500
                                   dark:text-gray-400"
                        >
                            Status
                        </th>

                    </tr>

                </thead>


                <tbody
                    class="divide-y divide-gray-100
                           dark:divide-gray-800"
                >

                    @forelse($violations as $index => $violation)

                        <tr
                            class="transition
                                   hover:bg-gray-50
                                   dark:hover:bg-gray-800/40"
                        >

                            {{-- NO --}}

                            <td
                                class="whitespace-nowrap
                                       px-6 py-5 text-sm
                                       font-medium
                                       text-gray-700
                                       dark:text-gray-300"
                            >

                                {{ $index + 1 }}

                            </td>


                            {{-- WAKTU --}}

                            <td
                                class="whitespace-nowrap
                                       px-6 py-5"
                            >

                                <div
                                    class="text-sm font-semibold
                                           text-gray-900
                                           dark:text-white"
                                >

                                    {{ optional(
                                        $violation->occurred_at
                                    )->format('d/m/Y') }}

                                </div>

                                <div
                                    class="mt-1 text-xs
                                           text-gray-500
                                           dark:text-gray-400"
                                >

                                    {{ optional(
                                        $violation->occurred_at
                                    )->format('H:i:s') }}

                                </div>

                            </td>


                            {{-- SUMBER --}}

                            <td
                                class="px-6 py-5"
                            >

                                <div
                                    class="text-sm font-semibold
                                           text-gray-900
                                           dark:text-white"
                                >

                                    {{ $violation->location
                                        ?: 'Upload Gambar' }}

                                </div>

                                <div
                                    class="mt-1 text-xs
                                           text-gray-500
                                           dark:text-gray-400"
                                >
                                    image
                                </div>

                            </td>


                            {{-- KELAS --}}

                            <td
                                class="px-6 py-5"
                            >

                                <span
                                    class="inline-flex
                                           rounded-full
                                           bg-red-100
                                           px-4 py-1.5
                                           text-sm font-semibold
                                           text-red-700
                                           dark:bg-red-950/40
                                           dark:text-red-400"
                                >

                                    Without Helmet

                                </span>

                            </td>


                            {{-- CONFIDENCE --}}

                            <td
                                class="whitespace-nowrap
                                       px-6 py-5 text-sm
                                       font-semibold
                                       text-gray-900
                                       dark:text-white"
                            >

                                {{ number_format(
                                    $violation->confidence * 100,
                                    2
                                ) }}%

                            </td>


                            {{-- STATUS --}}

                            <td
                                class="px-6 py-5"
                            >

                                <span
                                    class="inline-flex
                                           rounded-full
                                           bg-green-100
                                           px-4 py-1.5
                                           text-sm font-semibold
                                           text-green-700
                                           dark:bg-green-950/40
                                           dark:text-green-400"
                                >

                                    {{ ucfirst(
                                        $violation->status
                                    ) }}

                                </span>

                            </td>

                        </tr>


                    @empty

                        {{-- DATA KOSONG --}}

                        <tr>

                            <td
                                colspan="6"
                                class="px-6 py-20
                                       text-center"
                            >

                                <div
                                    class="mx-auto flex h-14 w-14
                                           items-center justify-center
                                           rounded-full
                                           bg-gray-100
                                           dark:bg-gray-800"
                                >

                                    <svg
                                        class="h-7 w-7
                                               text-gray-400"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                    >

                                        <circle
                                            cx="12"
                                            cy="12"
                                            r="9"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            d="M8 12h8"
                                        />

                                    </svg>

                                </div>


                                <p
                                    class="mt-4 text-base
                                           font-semibold
                                           text-gray-700
                                           dark:text-gray-300"
                                >

                                    @if(!empty($selectedDate))

                                        Tidak ada pelanggaran

                                    @else

                                        Belum ada pelanggaran

                                    @endif

                                </p>


                                <p
                                    class="mt-1 text-sm
                                           text-gray-500
                                           dark:text-gray-400"
                                >

                                    @if(!empty($selectedDate))

                                        Tidak ditemukan pelanggaran
                                        pada tanggal tersebut.

                                    @else

                                        Hasil deteksi without_helmet
                                        akan muncul di sini.

                                    @endif

                                </p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection


