@extends('layouts.app')

@section('content')

<div class="w-full space-y-6">

    {{-- =====================================================
        PAGE HEADER
    ====================================================== --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div class="flex items-center gap-4">

            <div
                class="flex h-14 w-14 shrink-0 items-center justify-center
                       rounded-2xl bg-blue-600 text-white shadow-lg
                       shadow-blue-600/20"
            >
                <svg
                    class="h-7 w-7"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M15 10l4.5-3A1 1 0 0121 7.8v8.4a1.5 1.5 0 01-1.5 1.3L15 14"
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

            <div>

                <h1
                    class="text-3xl font-bold tracking-tight
                           text-gray-900 dark:text-white"
                >
                    Deteksi Real-Time
                </h1>

                <p
                    class="mt-1 text-sm text-gray-500
                           dark:text-gray-400"
                >
                    Deteksi penggunaan helm menggunakan YOLOv11
                </p>

            </div>

        </div>


        {{-- SYSTEM STATUS --}}
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

            Sistem Siap

        </div>

    </div>


    {{-- =====================================================
        DETECTION CARD
    ====================================================== --}}
    <div
        class="overflow-hidden rounded-2xl
               border border-gray-200
               bg-white shadow-sm
               dark:border-gray-800
               dark:bg-gray-900"
    >

        {{-- CARD HEADER --}}
        <div
            class="flex flex-col gap-4
                   border-b border-gray-200
                   px-6 py-5
                   sm:flex-row sm:items-center
                   sm:justify-between
                   dark:border-gray-800"
        >

            <div>

                <h2
                    class="text-lg font-semibold
                           text-gray-900 dark:text-white"
                >
                    Kamera Deteksi
                </h2>

                <p
                    class="mt-1 text-sm
                           text-gray-500 dark:text-gray-400"
                >
                    Gunakan kamera untuk mendeteksi penggunaan helm secara langsung.
                </p>

            </div>


            {{-- CAMERA STATUS --}}
            <div
                id="camera-status"
                class="inline-flex w-fit items-center gap-2
                       rounded-xl border
                       border-gray-200
                       bg-gray-50
                       px-4 py-2
                       text-sm font-semibold
                       text-gray-600
                       dark:border-gray-700
                       dark:bg-gray-800
                       dark:text-gray-300"
            >

                <span
                    id="camera-status-dot"
                    class="h-2.5 w-2.5 rounded-full bg-gray-400"
                ></span>

                <span id="camera-status-text">
                    OFFLINE
                </span>

            </div>

        </div>


        {{-- =================================================
            VIDEO AREA
        ================================================== --}}
        <div class="p-6">

            <div
                id="video-container"
                class="relative aspect-video w-full
                       overflow-hidden rounded-2xl
                       bg-[#030712]"
            >

                {{-- CAMERA VIDEO --}}
                <video
                    id="video"
                    autoplay
                    playsinline
                    muted
                    class="absolute inset-0
                           h-full w-full
                           object-contain"
                ></video>


                {{-- DETECTION CANVAS --}}
                <canvas
                    id="canvas"
                    class="pointer-events-none
                           absolute inset-0
                           h-full w-full"
                ></canvas>


                {{-- TOP LEFT --}}
                <div
                    class="absolute left-5 top-5
                           rounded-xl bg-black/70
                           px-4 py-2
                           text-sm font-semibold
                           text-white backdrop-blur-sm"
                >
                    WASKARA • YOLOv11
                </div>


                {{-- RESOLUTION --}}
                <div
                    id="video-resolution"
                    class="absolute right-5 top-5
                           rounded-xl bg-black/70
                           px-4 py-2
                           text-sm font-semibold
                           text-gray-200 backdrop-blur-sm"
                >
                    -- × --
                </div>


                {{-- PLACEHOLDER --}}
                <div
                    id="camera-placeholder"
                    class="absolute inset-0
                           flex items-center justify-center
                           bg-[#030712]"
                >

                    <div class="px-6 text-center">

                        <div
                            class="mx-auto mb-5
                                   flex h-20 w-20
                                   items-center justify-center
                                   rounded-2xl
                                   bg-gray-800
                                   text-gray-400"
                        >

                            <svg
                                class="h-10 w-10"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.6"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M15 10l4.5-3A1 1 0 0121 7.8v8.4a1.5 1.5 0 01-1.5 1.3L15 14"
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
                            class="text-xl font-semibold
                                   text-white"
                        >
                            Kamera belum dimulai
                        </h3>


                        <p
                            class="mx-auto mt-2 max-w-lg
                                   text-sm leading-6
                                   text-gray-400"
                        >
                            Kamera akan digunakan untuk mendeteksi
                            pengendara dengan helm dan tanpa helm
                            menggunakan YOLOv11.
                        </p>

                    </div>

                </div>


                {{-- LOADING --}}
                <div
                    id="camera-loading"
                    class="absolute inset-0 hidden
                           items-center justify-center
                           bg-gray-950/90"
                >

                    <div class="text-center">

                        <div
                            class="mx-auto mb-4
                                   h-10 w-10 animate-spin
                                   rounded-full border-4
                                   border-gray-700
                                   border-t-blue-500"
                        ></div>

                        <p
                            class="text-sm font-medium
                                   text-gray-300"
                        >
                            Mengaktifkan kamera...
                        </p>

                    </div>

                </div>


                {{-- ERROR --}}
                <div
                    id="camera-error"
                    class="absolute inset-x-4
                           bottom-4 hidden
                           rounded-xl
                           border border-red-500/30
                           bg-red-950/90
                           p-4 backdrop-blur-sm"
                >

                    <p
                        class="text-sm font-semibold
                               text-red-300"
                    >
                        Terjadi kesalahan
                    </p>

                    <p
                        id="camera-error-message"
                        class="mt-1 text-xs
                               text-red-200"
                    ></p>

                </div>

            </div>


            {{-- =================================================
                BUTTON
            ================================================== --}}
            <div class="mt-5 flex flex-wrap items-center gap-3">

                <button
                    id="start-camera"
                    type="button"
                    class="inline-flex items-center gap-2
                           rounded-xl bg-blue-600
                           px-5 py-3
                           text-sm font-semibold
                           text-white shadow-sm
                           transition
                           hover:bg-blue-700
                           focus:outline-none
                           focus:ring-4
                           focus:ring-blue-500/20"
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
                            d="M15 10l4.5-3A1 1 0 0121 7.8v8.4a1.5 1.5 0 01-1.5 1.3L15 14"
                        />

                        <rect
                            x="3"
                            y="6"
                            width="12"
                            height="12"
                            rx="2"
                        />

                    </svg>

                    Mulai Kamera

                </button>


                <button
                    id="stop-camera"
                    type="button"
                    disabled
                    class="inline-flex items-center gap-2
                           rounded-xl bg-red-500
                           px-5 py-3
                           text-sm font-semibold
                           text-white shadow-sm
                           transition
                           hover:bg-red-600
                           disabled:cursor-not-allowed
                           disabled:opacity-40"
                >

                    <svg
                        class="h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <rect
                            x="6"
                            y="6"
                            width="12"
                            height="12"
                            rx="2"
                        />
                    </svg>

                    Hentikan

                </button>

            </div>


            {{-- =================================================
                STATISTICS
            ================================================== --}}
            <div
                class="mt-5 grid gap-4 md:grid-cols-3"
            >

                {{-- STATUS --}}
                <div
                    class="rounded-xl border
                           border-gray-200 bg-gray-50 p-5
                           dark:border-gray-800
                           dark:bg-gray-800/50"
                >

                    <p
                        class="text-xs font-medium
                               uppercase tracking-wider
                               text-gray-500
                               dark:text-gray-400"
                    >
                        Status
                    </p>

                    <p
                        id="detection-status"
                        class="mt-2 text-lg font-semibold
                               text-gray-900
                               dark:text-white"
                    >
                        Belum aktif
                    </p>

                </div>


                {{-- FPS --}}
                <div
                    class="rounded-xl border
                           border-gray-200 bg-gray-50 p-5
                           dark:border-gray-800
                           dark:bg-gray-800/50"
                >

                    <p
                        class="text-xs font-medium
                               uppercase tracking-wider
                               text-gray-500
                               dark:text-gray-400"
                    >
                        FPS Deteksi
                    </p>

                    <p
                        id="fps"
                        class="mt-2 text-lg font-semibold
                               text-gray-900
                               dark:text-white"
                    >
                        0
                    </p>

                </div>


                {{-- DETECTION --}}
                <div
                    class="rounded-xl border
                           border-gray-200 bg-gray-50 p-5
                           dark:border-gray-800
                           dark:bg-gray-800/50"
                >

                    <p
                        class="text-xs font-medium
                               uppercase tracking-wider
                               text-gray-500
                               dark:text-gray-400"
                    >
                        Deteksi
                    </p>

                    <p
                        id="detection-count"
                        class="mt-2 text-lg font-semibold
                               text-gray-900
                               dark:text-white"
                    >
                        0
                    </p>

                </div>

            </div>


            {{-- =================================================
                DETECTION SUMMARY
            ================================================== --}}
            <div
                class="mt-5 grid gap-4 sm:grid-cols-2"
            >

                {{-- WITH HELMET --}}
                <div
                    class="rounded-xl border
                           border-green-200
                           bg-green-50 p-5
                           dark:border-green-900
                           dark:bg-green-950/20"
                >

                    <div class="flex items-center justify-between">

                        <div>

                            <p
                                class="text-sm font-medium
                                       text-green-700
                                       dark:text-green-400"
                            >
                                Dengan Helm
                            </p>

                            <p
                                id="helmet-count"
                                class="mt-1 text-2xl
                                       font-bold
                                       text-green-800
                                       dark:text-green-300"
                            >
                                0
                            </p>

                        </div>

                        <span
                            class="rounded-lg
                                   bg-green-100
                                   px-3 py-1
                                   text-xs font-semibold
                                   text-green-700
                                   dark:bg-green-900/40
                                   dark:text-green-300"
                        >
                            With_helmet
                        </span>

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

                    <div class="flex items-center justify-between">

                        <div>

                            <p
                                class="text-sm font-medium
                                       text-red-700
                                       dark:text-red-400"
                            >
                                Tanpa Helm
                            </p>

                            <p
                                id="without-helmet-count"
                                class="mt-1 text-2xl
                                       font-bold
                                       text-red-800
                                       dark:text-red-300"
                            >
                                0
                            </p>

                        </div>

                        <span
                            class="rounded-lg
                                   bg-red-100
                                   px-3 py-1
                                   text-xs font-semibold
                                   text-red-700
                                   dark:bg-red-900/40
                                   dark:text-red-300"
                        >
                            without_helmet
                        </span>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- =========================================================
    REALTIME YOLOv11 JAVASCRIPT
========================================================= --}}
@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {


    /*
    |--------------------------------------------------------------------------
    | ELEMENT
    |--------------------------------------------------------------------------
    */

    const video =
        document.getElementById('video');

    const canvas =
        document.getElementById('canvas');

    const videoContainer =
        document.getElementById('video-container');

    const startButton =
        document.getElementById('start-camera');

    const stopButton =
        document.getElementById('stop-camera');

    const placeholder =
        document.getElementById('camera-placeholder');

    const loading =
        document.getElementById('camera-loading');

    const errorBox =
        document.getElementById('camera-error');

    const errorMessage =
        document.getElementById('camera-error-message');

    const statusText =
        document.getElementById('camera-status-text');

    const statusDot =
        document.getElementById('camera-status-dot');

    const cameraStatus =
        document.getElementById('camera-status');

    const resolution =
        document.getElementById('video-resolution');

    const detectionStatus =
        document.getElementById('detection-status');

    const fpsElement =
        document.getElementById('fps');

    const detectionCount =
        document.getElementById('detection-count');

    const helmetCount =
        document.getElementById('helmet-count');

    const withoutHelmetCount =
        document.getElementById('without-helmet-count');


    /*
    |--------------------------------------------------------------------------
    | STATE
    |--------------------------------------------------------------------------
    */

    let stream = null;

    let detectionCanvas = null;

    let detectionContext = null;

    let detectionTimer = null;

    let requestInProgress = false;

    let running = false;

    let lastDetectionTime =
        performance.now();

    let detectionFrames = 0;


    /*
    |--------------------------------------------------------------------------
    | CAMERA STATUS
    |--------------------------------------------------------------------------
    */

    function setOnline() {

        cameraStatus.className =
            'inline-flex w-fit items-center gap-2 rounded-xl border border-green-200 bg-green-50 px-4 py-2 text-sm font-semibold text-green-700 dark:border-green-900 dark:bg-green-950/30 dark:text-green-400';

        statusDot.className =
            'h-2.5 w-2.5 rounded-full bg-green-500';

        statusText.textContent =
            'ONLINE';

        detectionStatus.textContent =
            'Kamera aktif';

    }


    function setOffline() {

        cameraStatus.className =
            'inline-flex w-fit items-center gap-2 rounded-xl border border-gray-200 bg-gray-50 px-4 py-2 text-sm font-semibold text-gray-600 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300';

        statusDot.className =
            'h-2.5 w-2.5 rounded-full bg-gray-400';

        statusText.textContent =
            'OFFLINE';

        detectionStatus.textContent =
            'Belum aktif';

    }


    /*
    |--------------------------------------------------------------------------
    | ERROR
    |--------------------------------------------------------------------------
    */

    function showError(message) {

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


    /*
    |--------------------------------------------------------------------------
    | START CAMERA
    |--------------------------------------------------------------------------
    */

    async function startCamera() {

        hideError();

        loading.classList.remove(
            'hidden'
        );

        loading.classList.add(
            'flex'
        );

        startButton.disabled = true;


        try {

            stream =
                await navigator.mediaDevices.getUserMedia({

                    video: {

                        width: {
                            ideal: 1280
                        },

                        height: {
                            ideal: 720
                        },

                        facingMode: 'user'

                    },

                    audio: false

                });


            video.srcObject =
                stream;


            await video.play();


            video.classList.remove(
                'hidden'
            );

            placeholder.classList.add(
                'hidden'
            );


            /*
            |--------------------------------------------------------------------------
            | RESOLUTION
            |--------------------------------------------------------------------------
            */

            resolution.textContent =
                video.videoWidth +
                ' × ' +
                video.videoHeight;


            /*
            |--------------------------------------------------------------------------
            | DISPLAY CANVAS
            |--------------------------------------------------------------------------
            */

            canvas.width =
                video.videoWidth;

            canvas.height =
                video.videoHeight;


            /*
            |--------------------------------------------------------------------------
            | DETECTION CANVAS
            |--------------------------------------------------------------------------
            */

            detectionCanvas =
                document.createElement(
                    'canvas'
                );

            detectionCanvas.width =
                video.videoWidth;

            detectionCanvas.height =
                video.videoHeight;

            detectionContext =
                detectionCanvas.getContext(
                    '2d'
                );


            /*
            |--------------------------------------------------------------------------
            | BUTTON
            |--------------------------------------------------------------------------
            */

            stopButton.disabled =
                false;


            /*
            |--------------------------------------------------------------------------
            | ONLINE
            |--------------------------------------------------------------------------
            */

            setOnline();


            /*
            |--------------------------------------------------------------------------
            | START YOLO
            |--------------------------------------------------------------------------
            */

            running = true;

            startDetectionLoop();


        } catch (error) {

            console.error(
                'Camera error:',
                error
            );

            startButton.disabled =
                false;


            if (
                error.name ===
                'NotAllowedError'
            ) {

                showError(
                    'Izin kamera ditolak. Izinkan akses kamera pada browser.'
                );

            }

            else if (
                error.name ===
                'NotFoundError'
            ) {

                showError(
                    'Kamera tidak ditemukan.'
                );

            }

            else {

                showError(
                    'Kamera tidak dapat digunakan.'
                );

            }

        }


        loading.classList.add(
            'hidden'
        );

        loading.classList.remove(
            'flex'
        );

    }


    /*
    |--------------------------------------------------------------------------
    | STOP CAMERA
    |--------------------------------------------------------------------------
    */

    function stopCamera() {

        running = false;


        if (detectionTimer) {

            clearTimeout(
                detectionTimer
            );

            detectionTimer = null;

        }


        if (stream) {

            stream
                .getTracks()
                .forEach(
                    track => track.stop()
                );

        }


        stream = null;

        video.srcObject = null;


        video.classList.add(
            'hidden'
        );

        placeholder.classList.remove(
            'hidden'
        );


        stopButton.disabled =
            true;

        startButton.disabled =
            false;


        setOffline();


        fpsElement.textContent =
            '0';

        detectionCount.textContent =
            '0';

        helmetCount.textContent =
            '0';

        withoutHelmetCount.textContent =
            '0';

        resolution.textContent =
            '-- × --';


        clearCanvas();

    }


    /*
    |--------------------------------------------------------------------------
    | CLEAR CANVAS
    |--------------------------------------------------------------------------
    */

    function clearCanvas() {

        if (!detectionContext) {
            return;
        }

        detectionContext.clearRect(
            0,
            0,
            detectionCanvas.width,
            detectionCanvas.height
        );

    }


    /*
    |--------------------------------------------------------------------------
    | DETECTION LOOP
    |--------------------------------------------------------------------------
    */

    function startDetectionLoop() {

        if (!running) {
            return;
        }


        sendFrameToYOLO();


        /*
        |--------------------------------------------------------------------------
        | 5 REQUEST PER SECOND
        |--------------------------------------------------------------------------
        */

        detectionTimer =
            setTimeout(
                startDetectionLoop,
                200
            );

    }


    /*
    |--------------------------------------------------------------------------
    | SEND FRAME TO FASTAPI
    |--------------------------------------------------------------------------
    */

    async function sendFrameToYOLO() {

        if (
            !running ||
            requestInProgress ||
            !video.videoWidth ||
            !video.videoHeight
        ) {

            return;

        }


        requestInProgress =
            true;


        try {

            /*
            |--------------------------------------------------------------------------
            | AMBIL FRAME WEBCAM
            |--------------------------------------------------------------------------
            */

            detectionContext.drawImage(
                video,
                0,
                0,
                detectionCanvas.width,
                detectionCanvas.height
            );


            /*
            |--------------------------------------------------------------------------
            | JPEG
            |--------------------------------------------------------------------------
            */

            const blob =
                await new Promise(
                    resolve => {

                        detectionCanvas.toBlob(
                            resolve,
                            'image/jpeg',
                            0.75
                        );

                    }
                );


            if (!blob) {
                return;
            }


            /*
            |--------------------------------------------------------------------------
            | FORMDATA
            |--------------------------------------------------------------------------
            |
            | PENTING:
            | FastAPI menerima "file"
            |--------------------------------------------------------------------------
            */

            const formData =
                new FormData();

            formData.append(
                'file',
                blob,
                'webcam.jpg'
            );


            /*
            |--------------------------------------------------------------------------
            | KIRIM KE FASTAPI
            |--------------------------------------------------------------------------
            */

            const response =
                await fetch(
                    'http://127.0.0.1:8001/detect',
                    {
                        method: 'POST',
                        body: formData
                    }
                );


            /*
            |--------------------------------------------------------------------------
            | HTTP ERROR
            |--------------------------------------------------------------------------
            */

            if (!response.ok) {

                throw new Error(
                    'HTTP ' +
                    response.status
                );

            }


            /*
            |--------------------------------------------------------------------------
            | RESPONSE JSON
            |--------------------------------------------------------------------------
            */

            const result =
                await response.json();


            /*
            |--------------------------------------------------------------------------
            | HASIL DETEKSI
            |--------------------------------------------------------------------------
            */

            if (
                result.success === true
            ) {

                const detections =
                    Array.isArray(
                        result.detections
                    )
                        ? result.detections
                        : [];


                drawDetections(
                    detections
                );


                updateStatistics(
                    detections
                );


                updateDetectionFPS();

            }

            else {

                clearCanvas();

            }


        } catch (error) {

            console.error(
                'YOLO detection error:',
                error
            );

        } finally {

            requestInProgress =
                false;

        }

    }


    /*
    |--------------------------------------------------------------------------
    | DRAW DETECTION
    |--------------------------------------------------------------------------
    */

    function drawDetections(
        detections
    ) {

        clearCanvas();


        if (!detections.length) {
            return;
        }


        const containerRect =
            videoContainer.getBoundingClientRect();


        const displayWidth =
            containerRect.width;


        const displayHeight =
            containerRect.height;


        const videoWidth =
            video.videoWidth;


        const videoHeight =
            video.videoHeight;


        if (
            !videoWidth ||
            !videoHeight
        ) {

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | OBJECT-CONTAIN
        |--------------------------------------------------------------------------
        */

        const scale =
            Math.min(
                displayWidth /
                    videoWidth,

                displayHeight /
                    videoHeight
            );


        const renderedWidth =
            videoWidth * scale;


        const renderedHeight =
            videoHeight * scale;


        const offsetX =
            (
                displayWidth -
                renderedWidth
            ) / 2;


        const offsetY =
            (
                displayHeight -
                renderedHeight
            ) / 2;


        /*
        |--------------------------------------------------------------------------
        | CANVAS
        |--------------------------------------------------------------------------
        */

        canvas.width =
            displayWidth;

        canvas.height =
            displayHeight;


        const ctx =
            canvas.getContext(
                '2d'
            );


        ctx.clearRect(
            0,
            0,
            displayWidth,
            displayHeight
        );


        /*
        |--------------------------------------------------------------------------
        | DRAW BOX
        |--------------------------------------------------------------------------
        */

        detections.forEach(
            detection => {


                const x1 =
                    Number(
                        detection.x1
                    );


                const y1 =
                    Number(
                        detection.y1
                    );


                const x2 =
                    Number(
                        detection.x2
                    );


                const y2 =
                    Number(
                        detection.y2
                    );


                const boxX =
                    offsetX +
                    (
                        x1 * scale
                    );


                const boxY =
                    offsetY +
                    (
                        y1 * scale
                    );


                const boxWidth =
                    (
                        x2 - x1
                    ) * scale;


                const boxHeight =
                    (
                        y2 - y1
                    ) * scale;


                const className =
                    detection.class_name ||
                    'Unknown';


                const confidence =
                    Number(
                        detection.confidence ||
                        0
                    );


                /*
                |--------------------------------------------------------------------------
                | COLOR
                |--------------------------------------------------------------------------
                */

                const isHelmet =
                    className ===
                    'With_helmet';


                const color =
                    isHelmet
                        ? '#22c55e'
                        : '#ef4444';


                /*
                |--------------------------------------------------------------------------
                | BOX
                |--------------------------------------------------------------------------
                */

                ctx.strokeStyle =
                    color;

                ctx.lineWidth =
                    3;


                ctx.strokeRect(
                    boxX,
                    boxY,
                    boxWidth,
                    boxHeight
                );


                /*
                |--------------------------------------------------------------------------
                | LABEL
                |--------------------------------------------------------------------------
                */

                const label =
                    className +
                    ' ' +
                    (
                        confidence * 100
                    ).toFixed(1) +
                    '%';


                ctx.font =
                    'bold 14px Arial';


                const textWidth =
                    ctx.measureText(
                        label
                    ).width;


                const labelHeight =
                    28;


                const labelY =
                    Math.max(
                        0,
                        boxY -
                        labelHeight
                    );


                ctx.fillStyle =
                    color;


                ctx.fillRect(
                    boxX,
                    labelY,
                    textWidth + 16,
                    labelHeight
                );


                ctx.fillStyle =
                    '#ffffff';


                ctx.fillText(
                    label,
                    boxX + 8,
                    labelY + 19
                );

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | STATISTICS
    |--------------------------------------------------------------------------
    */

    function updateStatistics(
        detections
    ) {

        let helmet =
            0;


        let withoutHelmet =
            0;


        detections.forEach(
            detection => {


                if (
                    detection.class_name ===
                    'With_helmet'
                ) {

                    helmet++;

                }


                if (
                    detection.class_name ===
                    'without_helmet'
                ) {

                    withoutHelmet++;

                }

            }
        );


        helmetCount.textContent =
            helmet;


        withoutHelmetCount.textContent =
            withoutHelmet;


        detectionCount.textContent =
            detections.length;


        if (
            detections.length > 0
        ) {

            detectionStatus.textContent =
                'Objek terdeteksi';

        }

        else {

            detectionStatus.textContent =
                'Tidak ada objek';

        }

    }


    /*
    |--------------------------------------------------------------------------
    | FPS
    |--------------------------------------------------------------------------
    */

    function updateDetectionFPS() {

        detectionFrames++;


        const now =
            performance.now();


        const elapsed =
            now -
            lastDetectionTime;


        if (
            elapsed >= 1000
        ) {

            const fps =
                Math.round(
                    detectionFrames /
                    (
                        elapsed /
                        1000
                    )
                );


            fpsElement.textContent =
                fps;


            detectionFrames =
                0;


            lastDetectionTime =
                now;

        }

    }


    /*
    |--------------------------------------------------------------------------
    | BUTTON EVENT
    |--------------------------------------------------------------------------
    */

    startButton.addEventListener(
        'click',
        startCamera
    );


    stopButton.addEventListener(
        'click',
        stopCamera
    );


    /*
    |--------------------------------------------------------------------------
    | CLEANUP
    |--------------------------------------------------------------------------
    */

    window.addEventListener(
        'beforeunload',
        stopCamera
    );

});

</script>

@endpush

@endsection