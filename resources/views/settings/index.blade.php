@extends('layouts.app')

@section('content')

<div class="w-full space-y-6">

    {{-- HEADER --}}
    <div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
            Pengaturan
        </h1>

        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Informasi dan konfigurasi dasar sistem WASKARA.
        </p>
    </div>


    {{-- INFORMASI SISTEM --}}
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
                Informasi Sistem
            </h2>

            <p
                class="mt-1 text-sm
                       text-gray-500 dark:text-gray-400"
            >
                Informasi dasar aplikasi yang sedang digunakan.
            </p>

        </div>


        <div class="grid gap-5 sm:grid-cols-2">

            {{-- NAMA SISTEM --}}
            <div>

                <label
                    class="text-xs font-semibold uppercase
                           tracking-wide text-gray-500"
                >
                    Nama Sistem
                </label>

                <div
                    class="mt-2 rounded-xl border
                           border-gray-200 bg-gray-50
                           px-4 py-3 text-sm font-medium
                           text-gray-800
                           dark:border-gray-700
                           dark:bg-gray-800
                           dark:text-gray-200"
                >
                    WASKARA
                </div>

            </div>


            {{-- MODEL --}}
            <div>

                <label
                    class="text-xs font-semibold uppercase
                           tracking-wide text-gray-500"
                >
                    Model Deteksi
                </label>

                <div
                    class="mt-2 rounded-xl border
                           border-gray-200 bg-gray-50
                           px-4 py-3 text-sm font-medium
                           text-gray-800
                           dark:border-gray-700
                           dark:bg-gray-800
                           dark:text-gray-200"
                >
                    YOLOv11
                </div>

            </div>


            {{-- OBJEK --}}
            <div>

                <label
                    class="text-xs font-semibold uppercase
                           tracking-wide text-gray-500"
                >
                    Objek Deteksi
                </label>

                <div
                    class="mt-2 rounded-xl border
                           border-gray-200 bg-gray-50
                           px-4 py-3 text-sm font-medium
                           text-gray-800
                           dark:border-gray-700
                           dark:bg-gray-800
                           dark:text-gray-200"
                >
                    Helm Pengendara Motor
                </div>

            </div>


            {{-- STATUS --}}
            <div>

                <label
                    class="text-xs font-semibold uppercase
                           tracking-wide text-gray-500"
                >
                    Status Sistem
                </label>

                <div
                    class="mt-2 flex items-center gap-2
                           rounded-xl border
                           border-green-200
                           bg-green-50
                           px-4 py-3
                           text-sm font-medium
                           text-green-700
                           dark:border-green-900
                           dark:bg-green-950/20
                           dark:text-green-400"
                >

                    <span
                        class="h-2 w-2 rounded-full
                               bg-green-500"
                    ></span>

                    Sistem Aktif

                </div>

            </div>

        </div>

    </div>


    {{-- KONFIGURASI DETEKSI --}}
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
                Konfigurasi Deteksi
            </h2>

            <p
                class="mt-1 text-sm
                       text-gray-500 dark:text-gray-400"
            >
                Informasi konfigurasi deteksi yang digunakan
                oleh sistem.
            </p>

        </div>


        {{-- CONFIDENCE --}}
        <div
            class="rounded-xl border
                   border-gray-200
                   bg-gray-50 p-5
                   dark:border-gray-700
                   dark:bg-gray-800/50"
        >

            <div
                class="flex items-center
                       justify-between gap-4"
            >

                <div>

                    <h3
                        class="font-semibold
                               text-gray-900
                               dark:text-white"
                    >
                        Confidence Threshold
                    </h3>

                    <p
                        class="mt-1 text-xs
                               text-gray-500
                               dark:text-gray-400"
                    >
                        Nilai minimum confidence yang digunakan
                        dalam proses deteksi.
                    </p>

                </div>


                <div
                    class="rounded-xl
                           bg-white px-4 py-2
                           text-lg font-bold
                           text-gray-900
                           shadow-sm
                           dark:bg-gray-900
                           dark:text-white"
                >
                    0.50
                </div>

            </div>


            <div
                class="mt-4 rounded-lg
                       border border-yellow-200
                       bg-yellow-50 p-3
                       dark:border-yellow-900
                       dark:bg-yellow-950/20"
            >

                <p
                    class="text-xs leading-relaxed
                           text-yellow-700
                           dark:text-yellow-400"
                >
                    Nilai ini ditampilkan sebagai informasi.
                    Pengaturan threshold belum diubah secara
                    langsung dari halaman ini.
                </p>

            </div>

        </div>

    </div>


    {{-- INFORMASI KELAS --}}
    <div
        class="rounded-2xl border border-gray-200
               bg-white p-6 shadow-sm
               dark:border-gray-800 dark:bg-gray-900"
    >

        <div class="mb-5">

            <h2
                class="text-xl font-semibold
                       text-gray-900 dark:text-white"
            >
                Kelas Deteksi
            </h2>

            <p
                class="mt-1 text-sm
                       text-gray-500 dark:text-gray-400"
            >
                Kelas objek yang digunakan dalam model YOLOv11.
            </p>

        </div>


        <div class="grid gap-4 sm:grid-cols-2">

            {{-- WITH HELMET --}}
            <div
                class="rounded-xl border
                       border-green-200
                       bg-green-50 p-5
                       dark:border-green-900
                       dark:bg-green-950/20"
            >

                <div class="flex items-center gap-3">

                    <span
                        class="flex h-10 w-10
                               items-center justify-center
                               rounded-xl bg-green-100
                               text-green-700
                               dark:bg-green-900/40
                               dark:text-green-400"
                    >
                        ✓
                    </span>

                    <div>

                        <p
                            class="font-semibold
                                   text-green-800
                                   dark:text-green-300"
                        >
                            With_helmet
                        </p>

                        <p
                            class="mt-1 text-xs
                                   text-green-700
                                   dark:text-green-400"
                        >
                            Pengendara menggunakan helm
                        </p>

                    </div>

                </div>

            </div>


            {{-- WITHOUT HELMET --}}
            <div
                class="rounded-xl border
                       border-red-200
                       bg-red-50 p-5
                       dark:border-red-900
                       dark:bg-red-950/20"
            >

                <div class="flex items-center gap-3">

                    <span
                        class="flex h-10 w-10
                               items-center justify-center
                               rounded-xl bg-red-100
                               text-red-700
                               dark:bg-red-900/40
                               dark:text-red-400"
                    >
                        !
                    </span>

                    <div>

                        <p
                            class="font-semibold
                                   text-red-800
                                   dark:text-red-300"
                        >
                            without_helmet
                        </p>

                        <p
                            class="mt-1 text-xs
                                   text-red-700
                                   dark:text-red-400"
                        >
                            Pengendara tanpa helm
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- TENTANG SISTEM --}}
    <div
        class="rounded-2xl border border-blue-200
               bg-blue-50 p-6
               dark:border-blue-900
               dark:bg-blue-950/20"
    >

        <h2
            class="text-lg font-semibold
                   text-blue-800
                   dark:text-blue-300"
        >
            Tentang WASKARA
        </h2>

        <p
            class="mt-2 text-sm leading-relaxed
                   text-blue-700
                   dark:text-blue-400"
        >
            WASKARA merupakan sistem deteksi penggunaan helm
            pada pengendara sepeda motor yang menggunakan
            algoritma YOLOv11 untuk membantu proses pemantauan
            keselamatan lalu lintas.
        </p>

    </div>

</div>

@endsection