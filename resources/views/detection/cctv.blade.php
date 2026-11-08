@extends('layouts.app')

@section('content')

<div class="w-full space-y-6">

    {{-- =====================================================
        HEADER
    ====================================================== --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div class="flex items-center gap-4">

            <div class="flex h-14 w-14 shrink-0 items-center justify-center
                        rounded-2xl bg-blue-600 text-white shadow-lg
                        shadow-blue-600/20">

                <svg class="h-7 w-7"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="1.8">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M15 10l4.5-2.5v9L15 14"/>

                    <rect x="3"
                          y="6"
                          width="12"
                          height="12"
                          rx="2"/>

                </svg>

            </div>

            <div>

                <h1 class="text-3xl font-bold tracking-tight
                           text-gray-900 dark:text-white">

                    Live CCTV / ATCS

                </h1>

                <p class="mt-1 text-sm text-gray-500
                          dark:text-gray-400">

                    Deteksi helm secara realtime dari sumber CCTV atau ATCS

                </p>

            </div>

        </div>


        {{-- STATUS --}}
        <div id="connection-status"
             class="inline-flex w-fit items-center gap-2
                    rounded-full border border-gray-200
                    bg-gray-50 px-4 py-2
                    text-sm font-semibold text-gray-600
                    dark:border-gray-700
                    dark:bg-gray-800
                    dark:text-gray-300">

            <span id="status-dot"
                  class="h-2.5 w-2.5 rounded-full bg-gray-400">
            </span>

            <span id="status-text">
                Belum Terhubung
            </span>

        </div>

    </div>


    {{-- =====================================================
        SOURCE CARD
    ====================================================== --}}
    <div class="rounded-2xl border border-gray-200
                bg-white p-6 shadow-sm
                dark:border-gray-800
                dark:bg-gray-900">

        <div class="mb-5">

            <h2 class="text-lg font-semibold
                       text-gray-900 dark:text-white">

                Sumber Kamera

            </h2>

            <p class="mt-1 text-sm text-gray-500
                      dark:text-gray-400">

                Masukkan URL stream CCTV/ATCS yang dapat diakses oleh sistem.

            </p>

        </div>


        {{-- JENIS SUMBER --}}
        <div>

            <label
                for="source-type"
                class="mb-2 block text-sm font-medium
                       text-gray-700 dark:text-gray-300">

                Jenis Sumber Live

            </label>

            <select
                id="source-type"
                class="w-full rounded-xl border
                       border-gray-300 bg-white
                       px-4 py-3 text-sm
                       text-gray-900 outline-none
                       transition
                       focus:border-blue-500
                       focus:ring-4
                       focus:ring-blue-500/10
                       dark:border-gray-700
                       dark:bg-gray-800
                       dark:text-white">

                <option value="direct">
                    CCTV / ATCS Web (RTSP / HTTP)
                </option>

                <option value="youtube">
                    YouTube Live
                </option>

            </select>

        </div>


        {{-- URL --}}
        <div class="mt-5">

            <label
                for="stream-url"
                class="mb-2 block text-sm font-medium
                       text-gray-700 dark:text-gray-300">

                URL Sumber Live

            </label>

            <input
                id="stream-url"
                type="text"
                autocomplete="off"
                placeholder="Contoh: rtsp://192.168.1.10:554/stream"
                class="w-full rounded-xl border
                       border-gray-300 bg-white
                       px-4 py-3 text-sm
                       text-gray-900 outline-none
                       transition
                       focus:border-blue-500
                       focus:ring-4
                       focus:ring-blue-500/10
                       dark:border-gray-700
                       dark:bg-gray-800
                       dark:text-white">

            <p
                id="source-help"
                class="mt-2 text-xs text-gray-500
                       dark:text-gray-400">

                Masukkan URL stream langsung RTSP/HTTP yang dapat diakses sistem.

            </p>

        </div>


        {{-- BUTTONS --}}
        <div class="mt-5 flex flex-wrap gap-3">

            <button
                id="connect-button"
                type="button"
                class="inline-flex items-center gap-2
                       rounded-xl bg-blue-600
                       px-5 py-3 text-sm
                       font-semibold text-white
                       transition hover:bg-blue-700
                       disabled:cursor-not-allowed
                       disabled:opacity-50">

                <svg class="h-5 w-5"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="1.8">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M13 10V3L4 14h7v7l9-11h-7z"/>

                </svg>

                Hubungkan Kamera

            </button>


            <button
                id="disconnect-button"
                type="button"
                disabled
                class="inline-flex items-center gap-2
                       rounded-xl bg-red-600
                       px-5 py-3 text-sm
                       font-semibold text-white
                       transition hover:bg-red-700
                       disabled:cursor-not-allowed
                       disabled:opacity-40">

                <svg class="h-5 w-5"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="1.8">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M6 6l12 12M18 6L6 18"/>

                </svg>

                Putuskan

            </button>

        </div>

    </div>


    {{-- =====================================================
        ERROR
    ====================================================== --}}
    <div id="error-box"
         class="hidden rounded-xl
                border border-red-200
                bg-red-50 p-4
                dark:border-red-900
                dark:bg-red-950/30">

        <p class="text-sm font-semibold
                  text-red-700
                  dark:text-red-400">

            Koneksi gagal

        </p>

        <p id="error-message"
           class="mt-1 text-xs
                  text-red-600
                  dark:text-red-400">
        </p>

    </div>


    {{-- =====================================================
        VIDEO AREA
    ====================================================== --}}
    <div class="overflow-hidden rounded-2xl
                border border-gray-200
                bg-white shadow-sm
                dark:border-gray-800
                dark:bg-gray-900">

        <div class="border-b border-gray-200
                    px-6 py-4
                    dark:border-gray-800">

            <div class="flex items-center justify-between">

                <div>

                    <h2 class="text-lg font-semibold
                               text-gray-900 dark:text-white">

                        Live Detection

                    </h2>

                    <p class="mt-1 text-xs text-gray-500
                              dark:text-gray-400">

                        YOLOv11

                    </p>

                </div>

                <div class="rounded-lg bg-gray-100
                            px-3 py-1.5 text-xs
                            font-semibold text-gray-600
                            dark:bg-gray-800
                            dark:text-gray-300">

                    CCTV / ATCS

                </div>

            </div>

        </div>


        {{-- VIDEO --}}
        <div class="relative flex min-h-[520px]
                    items-center justify-center
                    bg-gray-950">

            {{-- PLACEHOLDER --}}
            <div id="video-placeholder"
                 class="flex flex-col items-center
                        justify-center px-6 text-center">

                <div class="flex h-20 w-20
                            items-center justify-center
                            rounded-2xl bg-gray-800
                            text-gray-400">

                    <svg class="h-10 w-10"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="1.5">

                        <rect x="3"
                              y="5"
                              width="18"
                              height="14"
                              rx="2"/>

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M8 12h.01M12 12h.01M16 12h.01"/>

                    </svg>

                </div>

                <p class="mt-5 text-base
                          font-semibold text-gray-300">

                    Kamera belum terhubung

                </p>

                <p class="mt-2 max-w-md text-sm
                          text-gray-500">

                    Masukkan URL stream CCTV/ATCS
                    kemudian klik "Hubungkan Kamera".

                </p>

            </div>


            {{-- VIDEO --}}
            <img
                id="cctv-video"
                src=""
                alt="Live CCTV"
                class="hidden max-h-[720px]
                       max-w-full object-contain">


            {{-- LOADING --}}
            <div id="video-loading"
                 class="absolute inset-0 hidden
                        items-center justify-center
                        bg-gray-950/80">

                <div class="text-center">

                    <div class="mx-auto h-10 w-10
                                animate-spin rounded-full
                                border-4 border-gray-700
                                border-t-blue-500">
                    </div>

                    <p class="mt-4 text-sm
                              font-medium text-gray-300">

                        Menghubungkan kamera...

                    </p>

                </div>

            </div>

        </div>

    </div>


    {{-- =====================================================
        STATISTICS
    ====================================================== --}}
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">


        {{-- FPS --}}
        <div class="rounded-2xl border
                    border-gray-200
                    bg-white p-5 shadow-sm
                    dark:border-gray-800
                    dark:bg-gray-900">

            <p class="text-xs font-medium
                      uppercase tracking-wider
                      text-gray-500
                      dark:text-gray-400">

                FPS

            </p>

            <p id="fps-value"
               class="mt-2 text-3xl font-bold
                      text-gray-900 dark:text-white">

                0

            </p>

        </div>


        {{-- WITH HELMET --}}
        <div class="rounded-2xl border
                    border-green-200
                    bg-green-50 p-5
                    dark:border-green-900
                    dark:bg-green-950/20">

            <p class="text-xs font-medium
                      uppercase tracking-wider
                      text-green-700
                      dark:text-green-400">

                With Helmet

            </p>

            <p id="helmet-value"
               class="mt-2 text-3xl font-bold
                      text-green-700
                      dark:text-green-400">

                0

            </p>

        </div>


        {{-- WITHOUT HELMET --}}
        <div class="rounded-2xl border
                    border-red-200
                    bg-red-50 p-5
                    dark:border-red-900
                    dark:bg-red-950/20">

            <p class="text-xs font-medium
                      uppercase tracking-wider
                      text-red-700
                      dark:text-red-400">

                Without Helmet

            </p>

            <p id="without-helmet-value"
               class="mt-2 text-3xl font-bold
                      text-red-700
                      dark:text-red-400">

                0

            </p>

        </div>


        {{-- TOTAL --}}
        <div class="rounded-2xl border
                    border-gray-200
                    bg-white p-5 shadow-sm
                    dark:border-gray-800
                    dark:bg-gray-900">

            <p class="text-xs font-medium
                      uppercase tracking-wider
                      text-gray-500
                      dark:text-gray-400">

                Total Deteksi

            </p>

            <p id="total-value"
               class="mt-2 text-3xl font-bold
                      text-gray-900 dark:text-white">

                0

            </p>

        </div>

    </div>


    {{-- =====================================================
        INFORMATION
    ====================================================== --}}
    <div class="rounded-2xl border
                border-blue-200
                bg-blue-50 p-5
                dark:border-blue-900
                dark:bg-blue-950/20">

        <div class="flex gap-3">

            <svg class="mt-0.5 h-5 w-5 shrink-0
                        text-blue-600
                        dark:text-blue-400"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor"
                 stroke-width="1.8">

                <circle cx="12"
                        cy="12"
                        r="9"/>

                <path stroke-linecap="round"
                      d="M12 11v5"/>

                <path stroke-linecap="round"
                      d="M12 8h.01"/>

            </svg>

            <div>

                <p class="text-sm font-semibold
                          text-blue-800
                          dark:text-blue-300">

                    Sumber Live CCTV / ATCS

                </p>

                <p class="mt-1 text-sm
                          text-blue-700
                          dark:text-blue-400">

                    Sistem mendukung dua sumber live:
                    stream langsung RTSP/HTTP dan YouTube Live publik.
                    Keduanya diproses oleh YOLOv11.

                </p>

            </div>

        </div>

    </div>

</div>


{{-- =========================================================
    JAVASCRIPT
========================================================= --}}
@push('scripts')

<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {

        // =====================================================
        // ELEMENT
        // =====================================================

        const streamUrl =
            document.getElementById('stream-url');

        const sourceType =
            document.getElementById('source-type');

        const sourceHelp =
            document.getElementById('source-help');

        const connectButton =
            document.getElementById('connect-button');

        const disconnectButton =
            document.getElementById('disconnect-button');

        const connectionStatus =
            document.getElementById('connection-status');

        const statusDot =
            document.getElementById('status-dot');

        const statusText =
            document.getElementById('status-text');

        const video =
            document.getElementById('cctv-video');

        const placeholder =
            document.getElementById('video-placeholder');

        const loading =
            document.getElementById('video-loading');

        const errorBox =
            document.getElementById('error-box');

        const errorMessage =
            document.getElementById('error-message');

        const fpsValue =
            document.getElementById('fps-value');

        const helmetValue =
            document.getElementById('helmet-value');

        const withoutHelmetValue =
            document.getElementById(
                'without-helmet-value'
            );

        const totalValue =
            document.getElementById(
                'total-value'
            );


        // =====================================================
        // FASTAPI CCTV
        // =====================================================

        const API_URL =
            'http://127.0.0.1:8002';


        // =====================================================
        // STATISTICS INTERVAL
        // =====================================================

        let statisticsInterval = null;


        // =====================================================
        // UPDATE SOURCE INPUT
        // =====================================================

        sourceType.addEventListener(
            'change',
            updateSourceInput
        );


        function updateSourceInput() {

            if (
                sourceType.value === 'youtube'
            ) {

                streamUrl.placeholder =
                    'Contoh: https://www.youtube.com/watch?v=...';

                sourceHelp.textContent =
                    'Masukkan URL YouTube Live publik. Sistem akan mengambil stream video secara otomatis.';

            }
            else {

                streamUrl.placeholder =
                    'Contoh: rtsp://192.168.1.10:554/stream';

                sourceHelp.textContent =
                    'Masukkan URL stream langsung RTSP/HTTP yang dapat diakses sistem.';

            }

        }


        updateSourceInput();


        // =====================================================
        // CONNECT BUTTON
        // =====================================================

        connectButton.addEventListener(
            'click',
            connectCamera
        );


        async function connectCamera() {

            const url =
                streamUrl.value.trim();


            // -------------------------------------------------
            // VALIDASI
            // -------------------------------------------------

            if (!url) {

                showError(
                    sourceType.value === 'youtube'
                        ? 'Masukkan URL YouTube Live terlebih dahulu.'
                        : 'Masukkan URL stream CCTV terlebih dahulu.'
                );

                return;

            }


            hideError();


            // -------------------------------------------------
            // LOADING
            // -------------------------------------------------

            loading.classList.remove(
                'hidden'
            );

            loading.classList.add(
                'flex'
            );


            connectButton.disabled =
                true;

            disconnectButton.disabled =
                true;


            setStatus(
                'connecting',
                'Menghubungkan...'
            );


            try {

                // =================================================
                // CONNECT KE FASTAPI :8002
                // =================================================

                const response =
                    await fetch(
                        API_URL +
                        '/cctv/connect',
                        {
                            method: 'POST',

                            headers: {
                                'Content-Type':
                                    'application/json'
                            },

                            body: JSON.stringify({
                                url: url,

                                source_type:
                                    sourceType.value
                            })
                        }
                    );


                // =================================================
                // CEK RESPONSE
                // =================================================

                if (!response.ok) {

                    let message =
                        'Sumber live tidak dapat dihubungkan.';

                    try {

                        const data =
                            await response.json();

                        if (data.message) {

                            message =
                                data.message;

                        }

                    }
                    catch (e) {

                        // Tidak melakukan apa-apa.
                        // Error utama tetap ditampilkan.

                    }


                    throw new Error(
                        message
                    );

                }


                // =================================================
                // RESPONSE JSON
                // =================================================

                const data =
                    await response.json();


                if (!data.success) {

                    throw new Error(
                        data.message ||
                        'Sumber live tidak dapat dihubungkan.'
                    );

                }


                // =================================================
                // CONNECTED
                // =================================================

                setStatus(
                    'connected',

                    data.source_type === 'youtube'
                        ? 'YouTube Live Terhubung'
                        : 'CCTV Terhubung'
                );


                // =================================================
                // VIDEO
                // =================================================

                placeholder.classList.add(
                    'hidden'
                );

                video.classList.remove(
                    'hidden'
                );


                // =================================================
                // STREAM
                // =================================================

                if (
                    data.stream_url
                ) {

                    video.src =
                        API_URL +
                        data.stream_url;

                }


                // =================================================
                // STATISTICS
                // =================================================

                startStatistics();


                // =================================================
                // BUTTON
                // =================================================

                disconnectButton.disabled =
                    false;


            }
            catch (error) {

                console.error(
                    'CCTV ERROR:',
                    error
                );


                setStatus(
                    'error',
                    'Gagal Terhubung'
                );


                showError(
                    error.message ||
                    'Tidak dapat terhubung ke sumber live.'
                );


                connectButton.disabled =
                    false;

                disconnectButton.disabled =
                    true;

            }
            finally {

                loading.classList.add(
                    'hidden'
                );

                loading.classList.remove(
                    'flex'
                );

            }

        }


        // =====================================================
        // STATISTICS
        // =====================================================

        function startStatistics() {

            // Hentikan interval sebelumnya
            if (
                statisticsInterval
            ) {

                clearInterval(
                    statisticsInterval
                );

            }


            // Ambil data pertama
            updateStatistics();


            // Update setiap 500 ms
            statisticsInterval =
                setInterval(
                    updateStatistics,
                    500
                );

        }


        async function updateStatistics() {

            try {

                const response =
                    await fetch(
                        API_URL +
                        '/cctv/stats'
                    );


                // Jika endpoint statistik belum tersedia,
                // jangan membuat halaman menjadi error.

                if (
                    !response.ok
                ) {

                    return;

                }


                const data =
                    await response.json();


                if (
                    !data ||
                    !data.success
                ) {

                    return;

                }


                // =================================================
                // FPS
                // =================================================

                if (
                    data.fps !== undefined &&
                    data.fps !== null
                ) {

                    fpsValue.textContent =
                        Number(
                            data.fps
                        ).toFixed(2);

                }


                // =================================================
                // WITH HELMET
                // =================================================

                if (
                    data.with_helmet !== undefined
                ) {

                    helmetValue.textContent =
                        data.with_helmet;

                }


                // =================================================
                // WITHOUT HELMET
                // =================================================

                if (
                    data.without_helmet !== undefined
                ) {

                    withoutHelmetValue.textContent =
                        data.without_helmet;

                }


                // =================================================
                // TOTAL
                // =================================================

                if (
                    data.total !== undefined
                ) {

                    totalValue.textContent =
                        data.total;

                }

            }
            catch (error) {

                // Statistik gagal bukan berarti
                // koneksi CCTV gagal.
                console.warn(
                    'Statistik CCTV belum tersedia:',
                    error
                );

            }

        }


        // =====================================================
        // DISCONNECT
        // =====================================================

        disconnectButton.addEventListener(
            'click',
            disconnectCamera
        );


        async function disconnectCamera() {

            try {

                await fetch(
                    API_URL +
                    '/cctv/disconnect',
                    {
                        method: 'POST'
                    }
                );

            }
            catch (error) {

                console.warn(
                    'Gagal disconnect:',
                    error
                );

            }


            // =================================================
            // STOP STATISTICS
            // =================================================

            if (
                statisticsInterval
            ) {

                clearInterval(
                    statisticsInterval
                );

                statisticsInterval =
                    null;

            }


            // =================================================
            // STOP VIDEO
            // =================================================

            video.src =
                '';

            video.classList.add(
                'hidden'
            );

            placeholder.classList.remove(
                'hidden'
            );


            // =================================================
            // BUTTON
            // =================================================

            connectButton.disabled =
                false;

            disconnectButton.disabled =
                true;


            // =================================================
            // STATUS
            // =================================================

            setStatus(
                'disconnected',
                'Belum Terhubung'
            );


            // =================================================
            // RESET
            // =================================================

            resetStatistics();

        }


        // =====================================================
        // STATUS
        // =====================================================

        function setStatus(
            type,
            text
        ) {

            statusText.textContent =
                text;


            statusDot.className =
                'h-2.5 w-2.5 rounded-full';


            connectionStatus.className =
                'inline-flex w-fit items-center gap-2 rounded-full border px-4 py-2 text-sm font-semibold';


            if (
                type === 'connected'
            ) {

                statusDot.classList.add(
                    'bg-green-500'
                );

                connectionStatus.classList.add(
                    'border-green-200',
                    'bg-green-50',
                    'text-green-700'
                );

            }

            else if (
                type === 'connecting'
            ) {

                statusDot.classList.add(
                    'animate-pulse',
                    'bg-yellow-500'
                );

                connectionStatus.classList.add(
                    'border-yellow-200',
                    'bg-yellow-50',
                    'text-yellow-700'
                );

            }

            else if (
                type === 'error'
            ) {

                statusDot.classList.add(
                    'bg-red-500'
                );

                connectionStatus.classList.add(
                    'border-red-200',
                    'bg-red-50',
                    'text-red-700'
                );

            }

            else {

                statusDot.classList.add(
                    'bg-gray-400'
                );

                connectionStatus.classList.add(
                    'border-gray-200',
                    'bg-gray-50',
                    'text-gray-600'
                );

            }

        }


        // =====================================================
        // ERROR
        // =====================================================

        function showError(
            message
        ) {

            errorMessage.textContent =
                message;

            errorBox.classList.remove(
                'hidden'
            );

        }


        function hideError() {

            errorBox.classList.add(
                'hidden'
            );

            errorMessage.textContent =
                '';

        }


        // =====================================================
        // RESET STATISTICS
        // =====================================================

        function resetStatistics() {

            fpsValue.textContent =
                '0';

            helmetValue.textContent =
                '0';

            withoutHelmetValue.textContent =
                '0';

            totalValue.textContent =
                '0';

        }

    }

);

</script>

@endpush

@endsection