@extends('layouts.app')

@section('content')

<div class="w-full space-y-6">

    {{-- HEADER --}}
    <div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
            Tentang WASKARA
        </h1>

        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Informasi mengenai sistem deteksi helm WASKARA.
        </p>
    </div>


    {{-- IDENTITAS SISTEM --}}
    <div
        class="rounded-2xl border border-gray-200
               bg-white p-6 shadow-sm
               dark:border-gray-800 dark:bg-gray-900"
    >

        <div class="flex items-start gap-4">

            <div
                class="flex h-14 w-14 shrink-0
                       items-center justify-center
                       rounded-2xl bg-blue-50
                       dark:bg-blue-950/40"
            >

                <svg
                    class="h-7 w-7 text-blue-600
                           dark:text-blue-400"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 3l8 4v5c0 5-3.5 8-8 9-4.5-1-8-4-8-9V7l8-4z"
                    />

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M9 12l2 2 4-4"
                    />
                </svg>

            </div>


            <div>

                <h2
                    class="text-2xl font-bold
                           text-gray-900 dark:text-white"
                >
                    WASKARA
                </h2>

                <p
                    class="mt-1 text-sm font-medium
                           text-blue-600 dark:text-blue-400"
                >
                    Helmet Safety Detection System
                </p>

                <p
                    class="mt-3 max-w-3xl
                           text-sm leading-relaxed
                           text-gray-500 dark:text-gray-400"
                >
                    WASKARA merupakan sistem berbasis computer
                    vision yang digunakan untuk mendeteksi
                    penggunaan helm pada pengendara sepeda motor
                    menggunakan algoritma YOLOv11.
                </p>

            </div>

        </div>

    </div>


    {{-- TENTANG SISTEM --}}
    <div
        class="rounded-2xl border border-gray-200
               bg-white p-6 shadow-sm
               dark:border-gray-800 dark:bg-gray-900"
    >

        <h2
            class="text-xl font-semibold
                   text-gray-900 dark:text-white"
        >
            Tentang Sistem
        </h2>

        <p
            class="mt-3 text-sm leading-relaxed
                   text-gray-500 dark:text-gray-400"
        >
            Sistem WASKARA dirancang untuk membantu proses
            pemantauan penggunaan helm pada pengendara sepeda
            motor. Sistem melakukan deteksi terhadap objek
            pengendara dan mengelompokkan hasil deteksi ke dalam
            kelas penggunaan helm.
        </p>

    </div>


    {{-- TEKNOLOGI --}}
    <div
        class="rounded-2xl border border-gray-200
               bg-white p-6 shadow-sm
               dark:border-gray-800 dark:bg-gray-900"
    >

        <h2
            class="mb-5 text-xl font-semibold
                   text-gray-900 dark:text-white"
        >
            Teknologi yang Digunakan
        </h2>


        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">

            {{-- YOLO --}}
            <div
                class="rounded-xl border
                       border-gray-200 p-5
                       dark:border-gray-700"
            >

                <div
                    class="mb-3 flex h-10 w-10
                           items-center justify-center
                           rounded-xl bg-blue-50
                           text-blue-600
                           dark:bg-blue-950/40
                           dark:text-blue-400"
                >
                    AI
                </div>

                <h3
                    class="font-semibold
                           text-gray-900 dark:text-white"
                >
                    YOLOv11
                </h3>

                <p
                    class="mt-1 text-xs leading-relaxed
                           text-gray-500 dark:text-gray-400"
                >
                    Algoritma object detection yang digunakan
                    untuk mendeteksi penggunaan helm.
                </p>

            </div>


            {{-- COMPUTER VISION --}}
            <div
                class="rounded-xl border
                       border-gray-200 p-5
                       dark:border-gray-700"
            >

                <div
                    class="mb-3 flex h-10 w-10
                           items-center justify-center
                           rounded-xl bg-purple-50
                           text-purple-600
                           dark:bg-purple-950/40
                           dark:text-purple-400"
                >
                    CV
                </div>

                <h3
                    class="font-semibold
                           text-gray-900 dark:text-white"
                >
                    Computer Vision
                </h3>

                <p
                    class="mt-1 text-xs leading-relaxed
                           text-gray-500 dark:text-gray-400"
                >
                    Digunakan untuk melakukan proses analisis
                    visual terhadap gambar dan video.
                </p>

            </div>


            {{-- WEB --}}
            <div
                class="rounded-xl border
                       border-gray-200 p-5
                       dark:border-gray-700"
            >

                <div
                    class="mb-3 flex h-10 w-10
                           items-center justify-center
                           rounded-xl bg-green-50
                           text-green-600
                           dark:bg-green-950/40
                           dark:text-green-400"
                >
                    WEB
                </div>

                <h3
                    class="font-semibold
                           text-gray-900 dark:text-white"
                >
                    Web Application
                </h3>

                <p
                    class="mt-1 text-xs leading-relaxed
                           text-gray-500 dark:text-gray-400"
                >
                    Digunakan sebagai antarmuka untuk menjalankan
                    dan memantau hasil deteksi.
                </p>

            </div>

        </div>

    </div>


    {{-- KELAS DETEKSI --}}
    <div
        class="rounded-2xl border border-gray-200
               bg-white p-6 shadow-sm
               dark:border-gray-800 dark:bg-gray-900"
    >

        <h2
            class="mb-5 text-xl font-semibold
                   text-gray-900 dark:text-white"
        >
            Kelas Deteksi
        </h2>


        <div class="grid gap-4 sm:grid-cols-2">

            {{-- WITH HELMET --}}
            <div
                class="rounded-xl border
                       border-green-200
                       bg-green-50 p-5
                       dark:border-green-900
                       dark:bg-green-950/20"
            >

                <p
                    class="font-semibold
                           text-green-800
                           dark:text-green-300"
                >
                    With_helmet
                </p>

                <p
                    class="mt-1 text-sm
                           text-green-700
                           dark:text-green-400"
                >
                    Pengendara terdeteksi menggunakan helm.
                </p>

            </div>


            {{-- WITHOUT HELMET --}}
            <div
                class="rounded-xl border
                       border-red-200
                       bg-red-50 p-5
                       dark:border-red-900
                       dark:bg-red-950/20"
            >

                <p
                    class="font-semibold
                           text-red-800
                           dark:text-red-300"
                >
                    without_helmet
                </p>

                <p
                    class="mt-1 text-sm
                           text-red-700
                           dark:text-red-400"
                >
                    Pengendara terdeteksi tidak menggunakan helm.
                </p>

            </div>

        </div>

    </div>


    {{-- TUJUAN --}}
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
            Tujuan Sistem
        </h2>

        <p
            class="mt-2 text-sm leading-relaxed
                   text-blue-700
                   dark:text-blue-400"
        >
            WASKARA dikembangkan sebagai implementasi algoritma
            YOLOv11 untuk membantu mendeteksi penggunaan helm
            pada pengendara motor sebagai salah satu upaya
            mendukung peningkatan keselamatan lalu lintas.
        </p>

    </div>


    {{-- VERSI --}}
    <div class="pb-4 text-center">

        <p
            class="text-xs text-gray-400
                   dark:text-gray-500"
        >
            WASKARA • YOLOv11 Helmet Safety Detection System
        </p>

    </div>

</div>

@endsection