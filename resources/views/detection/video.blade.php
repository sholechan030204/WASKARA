@extends('layouts.app')

@section('content')

<div class="space-y-6">

    {{-- =====================================================
        HEADER
    ====================================================== --}}

    <div class="flex items-center justify-between">

        <div>

            <p class="text-sm font-semibold text-blue-600 dark:text-blue-400">
                WASKARA • YOLOv11
            </p>

            <h1 class="mt-1 text-3xl font-bold text-gray-900 dark:text-white">
                Deteksi Video
            </h1>

            <p class="mt-2 text-gray-500 dark:text-gray-400">
                Deteksi penggunaan helm pada video menggunakan YOLOv11.
            </p>

        </div>


        <div
            class="hidden items-center gap-2 rounded-full border
                   border-green-200 bg-green-50 px-4 py-2
                   text-sm font-semibold text-green-700
                   sm:flex dark:border-green-900
                   dark:bg-green-950/30 dark:text-green-400"
        >

            <span
                id="system-dot"
                class="h-2.5 w-2.5 rounded-full bg-green-500"
            ></span>

            <span id="system-text">
                Sistem Aktif
            </span>

        </div>

    </div>


    {{-- =====================================================
        MAIN CARD
    ====================================================== --}}

    <div
        class="overflow-hidden rounded-2xl border border-gray-200
               bg-white shadow-sm dark:border-gray-800
               dark:bg-gray-900"
    >


        {{-- =================================================
            CARD HEADER
        ================================================== --}}

        <div
            class="flex flex-col gap-3 border-b border-gray-200
                   px-6 py-5 sm:flex-row sm:items-center
                   sm:justify-between dark:border-gray-800"
        >

            <div>

                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Video Detection
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Upload video untuk memulai proses deteksi.
                </p>

            </div>


            <div
                class="flex w-fit items-center gap-2 rounded-xl
                       border border-gray-200 bg-gray-50 px-4 py-2
                       text-sm font-semibold text-gray-600
                       dark:border-gray-700 dark:bg-gray-800
                       dark:text-gray-300"
            >

                <span
                    id="status-dot"
                    class="h-2.5 w-2.5 rounded-full bg-gray-400"
                ></span>

                <span id="status-text">
                    OFFLINE
                </span>

            </div>

        </div>


        {{-- =================================================
            VIDEO
        ================================================== --}}

        <div class="p-6">

            <div
                id="video-wrapper"
                class="relative aspect-video w-full overflow-hidden
                       rounded-2xl bg-[#030712]"
            >

                {{-- HASIL VIDEO YOLO --}}

                <img
                    id="result-video"
                    class="absolute inset-0 h-full w-full object-contain"
                    alt="Hasil deteksi YOLOv11"
                >


                {{-- PLACEHOLDER --}}

                <div
                    id="video-placeholder"
                    class="absolute inset-0 flex items-center justify-center"
                >

                    <div class="text-center">

                        <div
                            class="mx-auto flex h-20 w-20 items-center
                                   justify-center rounded-2xl
                                   bg-gray-800 text-gray-400"
                        >

                            <svg
                                class="h-10 w-10"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.7"
                                    d="M15 10l4.5-3A1 1 0 0121 7.8v8.4a1 1 0 01-1.5.8L15 14"
                                />

                                <rect
                                    x="3"
                                    y="6"
                                    width="12"
                                    height="12"
                                    rx="2"
                                />

                            </svg>

                        </div>


                        <h3
                            class="mt-5 text-lg font-semibold text-gray-200"
                        >
                            Belum ada video
                        </h3>


                        <p class="mt-2 text-sm text-gray-500">
                            Pilih video untuk memulai deteksi YOLOv11.
                        </p>

                    </div>

                </div>


                {{-- BRAND --}}

                <div
                    id="video-brand"
                    class="absolute left-5 top-5 z-20 hidden
                           rounded-xl bg-black/70 px-4 py-2
                           text-sm font-semibold text-white
                           backdrop-blur-sm"
                >
                    WASKARA • YOLOv11
                </div>


                {{-- RESOLUTION --}}

                <div
                    id="video-resolution"
                    class="absolute right-5 top-5 z-20 hidden
                           rounded-xl bg-black/70 px-4 py-2
                           text-sm font-semibold text-gray-200
                           backdrop-blur-sm"
                >
                    --
                </div>


                {{-- LOADING --}}

                <div
                    id="video-loading"
                    class="absolute inset-0 z-30 hidden
                           items-center justify-center
                           bg-black/60 backdrop-blur-sm"
                >

                    <div class="text-center">

                        <div
                            class="mx-auto h-10 w-10 animate-spin
                                   rounded-full border-4 border-gray-700
                                   border-t-blue-500"
                        ></div>


                        <p
                            class="mt-4 text-sm font-medium text-gray-200"
                        >
                            Menyiapkan video...
                        </p>

                    </div>

                </div>

            </div>


            {{-- =================================================
                CONTROLS
            ================================================== --}}

            <div class="mt-5 flex flex-wrap items-center gap-3">

                {{-- PILIH VIDEO --}}

                <label
                    for="video-file"
                    class="inline-flex cursor-pointer items-center
                           gap-2 rounded-xl bg-gray-100 px-5 py-3
                           text-sm font-semibold text-gray-700
                           transition hover:bg-gray-200
                           dark:bg-gray-800 dark:text-gray-200
                           dark:hover:bg-gray-700"
                >

                    <svg
                        class="h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M12 4v12m0-12l-4 4m4-4l4 4M5 20h14"
                        />

                    </svg>

                    Pilih Video

                </label>


                <input
                    id="video-file"
                    type="file"
                    accept="video/*"
                    class="hidden"
                >


                {{-- MULAI --}}

                <button
                    id="start-video"
                    type="button"
                    disabled
                    class="inline-flex items-center gap-2
                           rounded-xl bg-blue-600 px-5 py-3
                           text-sm font-semibold text-white
                           transition hover:bg-blue-700
                           disabled:cursor-not-allowed
                           disabled:opacity-40"
                >

                    <svg
                        class="h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M8 5v14l11-7L8 5z"
                        />

                    </svg>

                    Mulai Deteksi

                </button>


                {{-- STOP --}}

                <button
                    id="stop-video"
                    type="button"
                    disabled
                    class="inline-flex items-center gap-2
                           rounded-xl bg-red-600 px-5 py-3
                           text-sm font-semibold text-white
                           transition hover:bg-red-700
                           disabled:cursor-not-allowed
                           disabled:opacity-40"
                >

                    <svg
                        class="h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >

                        <rect
                            x="6"
                            y="6"
                            width="12"
                            height="12"
                            rx="1"
                        />

                    </svg>

                    Hentikan

                </button>

            </div>


            {{-- =================================================
                FILE INFO
            ================================================== --}}

            <div
                id="file-info"
                class="mt-4 hidden rounded-xl border
                       border-gray-200 bg-gray-50 p-4
                       dark:border-gray-800
                       dark:bg-gray-800/50"
            >

                <p class="text-xs font-medium uppercase text-gray-500">
                    Video
                </p>


                <p
                    id="file-name"
                    class="mt-1 break-all text-sm font-semibold
                           text-gray-800 dark:text-gray-200"
                ></p>

            </div>


            {{-- =================================================
                STATISTICS
            ================================================== --}}

            <div class="mt-5 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">


                {{-- STATUS --}}

                <div
                    class="rounded-xl border border-gray-200
                           bg-gray-50 p-5 dark:border-gray-800
                           dark:bg-gray-800/50"
                >

                    <p class="text-xs font-medium uppercase text-gray-500">
                        Status
                    </p>


                    <p
                        id="detection-status"
                        class="mt-2 font-semibold
                               text-gray-900 dark:text-white"
                    >
                        Belum aktif
                    </p>

                </div>


                {{-- WITH HELMET --}}

                <div
                    class="rounded-xl border border-green-200
                           bg-green-50 p-5
                           dark:border-green-900/40
                           dark:bg-green-950/20"
                >

                    <p
                        class="text-xs font-medium uppercase
                               text-green-600 dark:text-green-400"
                    >
                        With Helmet
                    </p>


                    <p
                        id="helmet-count"
                        class="mt-2 text-2xl font-bold
                               text-green-700 dark:text-green-300"
                    >
                        0
                    </p>

                </div>


                {{-- WITHOUT HELMET --}}

                <div
                    class="rounded-xl border border-red-200
                           bg-red-50 p-5
                           dark:border-red-900/40
                           dark:bg-red-950/20"
                >

                    <p
                        class="text-xs font-medium uppercase
                               text-red-600 dark:text-red-400"
                    >
                        Without Helmet
                    </p>


                    <p
                        id="without-helmet-count"
                        class="mt-2 text-2xl font-bold
                               text-red-700 dark:text-red-300"
                    >
                        0
                    </p>

                </div>


                {{-- FPS --}}

                <div
                    class="rounded-xl border border-blue-200
                           bg-blue-50 p-5
                           dark:border-blue-900/40
                           dark:bg-blue-950/20"
                >

                    <p
                        class="text-xs font-medium uppercase
                               text-blue-600 dark:text-blue-400"
                    >
                        FPS
                    </p>


                    <p
                        id="fps-count"
                        class="mt-2 text-2xl font-bold
                               text-blue-700 dark:text-blue-300"
                    >
                        0
                    </p>

                </div>

            </div>

        </div>

    </div>

</div>


@push('scripts')

<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {

        /*
        |--------------------------------------------------------------------------
        | ELEMENT
        |--------------------------------------------------------------------------
        */

        const fileInput =
            document.getElementById(
                'video-file'
            );

        const startButton =
            document.getElementById(
                'start-video'
            );

        const stopButton =
            document.getElementById(
                'stop-video'
            );

        const resultVideo =
            document.getElementById(
                'result-video'
            );

        const placeholder =
            document.getElementById(
                'video-placeholder'
            );

        const loading =
            document.getElementById(
                'video-loading'
            );

        const brand =
            document.getElementById(
                'video-brand'
            );

        const resolution =
            document.getElementById(
                'video-resolution'
            );

        const statusDot =
            document.getElementById(
                'status-dot'
            );

        const statusText =
            document.getElementById(
                'status-text'
            );

        const detectionStatus =
            document.getElementById(
                'detection-status'
            );

        const fileInfo =
            document.getElementById(
                'file-info'
            );

        const fileName =
            document.getElementById(
                'file-name'
            );

        const helmetCount =
            document.getElementById(
                'helmet-count'
            );

        const withoutHelmetCount =
            document.getElementById(
                'without-helmet-count'
            );

        const fpsCount =
            document.getElementById(
                'fps-count'
            );

        const systemDot =
            document.getElementById(
                'system-dot'
            );

        const systemText =
            document.getElementById(
                'system-text'
            );


        /*
        |--------------------------------------------------------------------------
        | STATE
        |--------------------------------------------------------------------------
        */

        let selectedFile = null;

        let videoId = null;

        let statsInterval = null;

        let streamURL = null;


        /*
        |--------------------------------------------------------------------------
        | FILE DIPILIH
        |--------------------------------------------------------------------------
        */

        fileInput.addEventListener(
            'change',
            function () {

                selectedFile =
                    this.files[0] || null;


                if (!selectedFile) {

                    return;

                }


                if (
                    !selectedFile.type.startsWith(
                        'video/'
                    )
                ) {

                    alert(
                        'Silakan pilih file video.'
                    );

                    this.value = '';

                    selectedFile = null;

                    return;

                }


                /*
                |--------------------------------------------------------------------------
                | TAMPILKAN NAMA
                |--------------------------------------------------------------------------
                */

                fileName.textContent =
                    selectedFile.name;

                fileInfo.classList.remove(
                    'hidden'
                );


                /*
                |--------------------------------------------------------------------------
                | ENABLE START
                |--------------------------------------------------------------------------
                */

                startButton.disabled =
                    false;

                stopButton.disabled =
                    true;


                detectionStatus.textContent =
                    'Video siap';


                /*
                |--------------------------------------------------------------------------
                | RESET STATISTIK
                |--------------------------------------------------------------------------
                */

                helmetCount.textContent =
                    '0';

                withoutHelmetCount.textContent =
                    '0';

                fpsCount.textContent =
                    '0';

            }
        );


        /*
        |--------------------------------------------------------------------------
        | MULAI DETEKSI
        |--------------------------------------------------------------------------
        */

        startButton.addEventListener(
            'click',
            async function () {

                if (!selectedFile) {

                    alert(
                        'Pilih video terlebih dahulu.'
                    );

                    return;

                }


                startButton.disabled =
                    true;

                stopButton.disabled =
                    false;


                loading.classList.remove(
                    'hidden'
                );

                loading.classList.add(
                    'flex'
                );


                detectionStatus.textContent =
                    'Mengupload video...';


                try {

                    /*
                    |--------------------------------------------------------------------------
                    | UPLOAD VIDEO KE PYTHON
                    |--------------------------------------------------------------------------
                    */

                    const formData =
                        new FormData();


                    formData.append(
                        'file',
                        selectedFile
                    );


                    const uploadResponse =
                        await fetch(
                            'http://127.0.0.1:8001/video/upload',
                            {
                                method: 'POST',

                                body:
                                    formData
                            }
                        );


                    if (
                        !uploadResponse.ok
                    ) {

                        throw new Error(
                            'Upload video gagal.'
                        );

                    }


                    const uploadResult =
                        await uploadResponse.json();


                    if (
                        !uploadResult.success
                    ) {

                        throw new Error(
                            uploadResult.message ||
                            'Video gagal diupload.'
                        );

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | SIMPAN VIDEO ID
                    |--------------------------------------------------------------------------
                    */

                    videoId =
                        uploadResult.video_id;


                    /*
                    |--------------------------------------------------------------------------
                    | STREAM
                    |--------------------------------------------------------------------------
                    */

                    streamURL =
                        `http://127.0.0.1:8001/video/stream/${videoId}`;


                    resultVideo.src =
                        streamURL;


                    /*
                    |--------------------------------------------------------------------------
                    | TAMPILKAN VIDEO
                    |--------------------------------------------------------------------------
                    */

                    placeholder.classList.add(
                        'hidden'
                    );

                    brand.classList.remove(
                        'hidden'
                    );

                    resolution.classList.remove(
                        'hidden'
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | STATUS
                    |--------------------------------------------------------------------------
                    */

                    statusDot.className =
                        'h-2.5 w-2.5 rounded-full bg-green-500';

                    statusText.textContent =
                        'ONLINE';


                    systemDot.className =
                        'h-2.5 w-2.5 rounded-full bg-green-500';

                    systemText.textContent =
                        'YOLOv11 Aktif';


                    detectionStatus.textContent =
                        'YOLOv11 sedang mendeteksi';


                    /*
                    |--------------------------------------------------------------------------
                    | HILANGKAN LOADING
                    |--------------------------------------------------------------------------
                    */

                    loading.classList.add(
                        'hidden'
                    );

                    loading.classList.remove(
                        'flex'
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | RESOLUSI VIDEO
                    |--------------------------------------------------------------------------
                    */

                    const tempVideo =
                        document.createElement(
                            'video'
                        );


                    tempVideo.preload =
                        'metadata';


                    const temporaryURL =
                        URL.createObjectURL(
                            selectedFile
                        );


                    tempVideo.src =
                        temporaryURL;


                    tempVideo.addEventListener(
                        'loadedmetadata',
                        function () {

                            resolution.textContent =
                                `${tempVideo.videoWidth} × ${tempVideo.videoHeight}`;


                            URL.revokeObjectURL(
                                temporaryURL
                            );

                        }
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | MULAI POLLING STATISTIK
                    |--------------------------------------------------------------------------
                    */

                    startStatsPolling();


                } catch (error) {

                    console.error(
                        error
                    );


                    loading.classList.add(
                        'hidden'
                    );

                    loading.classList.remove(
                        'flex'
                    );


                    detectionStatus.textContent =
                        'Gagal memproses video';


                    statusDot.className =
                        'h-2.5 w-2.5 rounded-full bg-red-500';

                    statusText.textContent =
                        'ERROR';


                    startButton.disabled =
                        false;

                    stopButton.disabled =
                        true;


                    alert(
                        error.message
                    );

                }

            }
        );


        /*
        |--------------------------------------------------------------------------
        | POLLING STATISTIK
        |--------------------------------------------------------------------------
        */

        function startStatsPolling()
        {

            /*
            |--------------------------------------------------------------------------
            | HENTIKAN POLLING LAMA
            |--------------------------------------------------------------------------
            */

            stopStatsPolling();


            /*
            |--------------------------------------------------------------------------
            | LANGSUNG CEK
            |--------------------------------------------------------------------------
            */

            updateStats();


            /*
            |--------------------------------------------------------------------------
            | CEK SETIAP 500ms
            |--------------------------------------------------------------------------
            */

            statsInterval =
                setInterval(
                    updateStats,
                    500
                );

        }


        /*
        |--------------------------------------------------------------------------
        | UPDATE STATISTIK
        |--------------------------------------------------------------------------
        */

        async function updateStats()
        {

            if (!videoId) {

                return;

            }


            try {

                const response =
                    await fetch(
                        `http://127.0.0.1:8001/video/stats/${videoId}`,
                        {
                            method: 'GET',

                            cache: 'no-store'
                        }
                    );


                if (!response.ok) {

                    return;

                }


                const data =
                    await response.json();


                if (!data.success) {

                    return;

                }


                /*
                |--------------------------------------------------------------------------
                | WITH HELMET
                |--------------------------------------------------------------------------
                */

                helmetCount.textContent =
                    Number(
                        data.with_helmet ?? 0
                    );


                /*
                |--------------------------------------------------------------------------
                | WITHOUT HELMET
                |--------------------------------------------------------------------------
                */

                withoutHelmetCount.textContent =
                    Number(
                        data.without_helmet ?? 0
                    );


                /*
                |--------------------------------------------------------------------------
                | FPS
                |--------------------------------------------------------------------------
                */

                fpsCount.textContent =
                    Number(
                        data.fps ?? 0
                    );


                /*
                |--------------------------------------------------------------------------
                | STATUS
                |--------------------------------------------------------------------------
                */

                if (
                    data.status ===
                    'detecting'
                ) {

                    detectionStatus.textContent =
                        'YOLOv11 sedang mendeteksi';


                    statusDot.className =
                        'h-2.5 w-2.5 rounded-full bg-green-500';

                    statusText.textContent =
                        'ONLINE';

                }


                else if (
                    data.status ===
                    'completed'
                ) {

                    detectionStatus.textContent =
                        'Deteksi selesai';


                    statusDot.className =
                        'h-2.5 w-2.5 rounded-full bg-blue-500';

                    statusText.textContent =
                        'SELESAI';


                    stopStatsPolling();

                    stopButton.disabled =
                        true;

                    startButton.disabled =
                        false;

                }


                else if (
                    data.status ===
                    'error'
                ) {

                    detectionStatus.textContent =
                        'Terjadi kesalahan';


                    statusDot.className =
                        'h-2.5 w-2.5 rounded-full bg-red-500';

                    statusText.textContent =
                        'ERROR';

                }

            }

            catch (error) {

                console.error(
                    'Stats error:',
                    error
                );

            }

        }


        /*
        |--------------------------------------------------------------------------
        | STOP POLLING
        |--------------------------------------------------------------------------
        */

        function stopStatsPolling()
        {

            if (statsInterval) {

                clearInterval(
                    statsInterval
                );

                statsInterval =
                    null;

            }

        }


        /*
        |--------------------------------------------------------------------------
        | STOP VIDEO
        |--------------------------------------------------------------------------
        */

        stopButton.addEventListener(
            'click',
            async function () {

                stopStatsPolling();


                /*
                |--------------------------------------------------------------------------
                | HENTIKAN STREAM
                |--------------------------------------------------------------------------
                */

                resultVideo.src =
                    '';


                /*
                |--------------------------------------------------------------------------
                | HAPUS VIDEO DARI PYTHON
                |--------------------------------------------------------------------------
                */

                if (videoId) {

                    try {

                        await fetch(
                            `http://127.0.0.1:8001/video/${videoId}`,
                            {
                                method: 'DELETE'
                            }
                        );

                    }

                    catch (error) {

                        console.error(
                            'Delete video error:',
                            error
                        );

                    }

                }


                /*
                |--------------------------------------------------------------------------
                | RESET
                |--------------------------------------------------------------------------
                */

                videoId =
                    null;

                streamURL =
                    null;


                helmetCount.textContent =
                    '0';

                withoutHelmetCount.textContent =
                    '0';

                fpsCount.textContent =
                    '0';


                detectionStatus.textContent =
                    'Deteksi dihentikan';


                statusDot.className =
                    'h-2.5 w-2.5 rounded-full bg-gray-400';

                statusText.textContent =
                    'OFFLINE';


                systemDot.className =
                    'h-2.5 w-2.5 rounded-full bg-green-500';

                systemText.textContent =
                    'Sistem Aktif';


                startButton.disabled =
                    !selectedFile;

                stopButton.disabled =
                    true;


                brand.classList.add(
                    'hidden'
                );

                resolution.classList.add(
                    'hidden'
                );

            }
        );


        /*
        |--------------------------------------------------------------------------
        | INITIAL
        |--------------------------------------------------------------------------
        */

        detectionStatus.textContent =
            'Belum aktif';

    }
);

</script>

@endpush

@endsection