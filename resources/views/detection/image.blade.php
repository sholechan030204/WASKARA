@extends('layouts.app')

@section('content')

<div class="w-full space-y-6">

    {{-- =====================================================
        PAGE HEADER
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

                    <rect x="3" y="4"
                          width="18"
                          height="16"
                          rx="2"/>

                    <circle cx="8.5" cy="9"
                            r="1.5"/>

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M21 15l-5-5L5 20"/>

                </svg>

            </div>


            <div>

                <h1 class="text-3xl font-bold tracking-tight
                           text-gray-900 dark:text-white">

                    Deteksi Gambar

                </h1>

                <p class="mt-1 text-sm text-gray-500
                          dark:text-gray-400">

                    Deteksi penggunaan helm pada gambar menggunakan YOLOv11

                </p>

            </div>

        </div>


        {{-- SYSTEM STATUS --}}

        <div class="inline-flex w-fit items-center gap-2
                    rounded-full border border-green-200
                    bg-green-50 px-4 py-2
                    text-sm font-semibold text-green-700
                    dark:border-green-900
                    dark:bg-green-950/30
                    dark:text-green-400">

            <span class="h-2.5 w-2.5 rounded-full bg-green-500"></span>

            Sistem Aktif

        </div>

    </div>


    {{-- =====================================================
        MAIN CARD
    ====================================================== --}}

    <div class="overflow-hidden rounded-2xl
                border border-gray-200
                bg-white shadow-sm
                dark:border-gray-800
                dark:bg-gray-900">

        {{-- CARD HEADER --}}

        <div class="border-b border-gray-200
                    px-6 py-5
                    dark:border-gray-800">

            <h2 class="text-lg font-semibold
                       text-gray-900 dark:text-white">

                Upload Gambar

            </h2>

            <p class="mt-1 text-sm text-gray-500
                      dark:text-gray-400">

                Pilih gambar untuk dianalisis oleh model YOLOv11.

            </p>

        </div>


        {{-- =================================================
            CONTENT
        ================================================== --}}

        <div class="p-6">

            {{-- UPLOAD AREA --}}

            <div id="upload-area"
                 class="relative flex min-h-[320px]
                        cursor-pointer flex-col
                        items-center justify-center
                        rounded-2xl border-2 border-dashed
                        border-gray-300 bg-gray-50
                        transition hover:border-blue-500
                        hover:bg-blue-50/40
                        dark:border-gray-700
                        dark:bg-gray-800/50
                        dark:hover:border-blue-500">

                <input
                    type="file"
                    id="image-input"
                    accept="image/jpeg,image/png,image/jpg"
                    class="hidden"
                >

                <div class="flex h-16 w-16
                            items-center justify-center
                            rounded-2xl bg-blue-100
                            text-blue-600
                            dark:bg-blue-900/30
                            dark:text-blue-400">

                    <svg class="h-8 w-8"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="1.8">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M12 16V4m0 0l-4 4m4-4l4 4"/>

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M4 16v3a1 1 0 001 1h14a1 1 0 001-1v-3"/>

                    </svg>

                </div>


                <h3 class="mt-5 text-lg font-semibold
                           text-gray-900 dark:text-white">

                    Pilih Gambar

                </h3>


                <p class="mt-2 text-sm text-gray-500
                          dark:text-gray-400">

                    Klik untuk memilih gambar JPG, JPEG, atau PNG

                </p>


                <p class="mt-1 text-xs text-gray-400">

                    Maksimal 10 MB

                </p>

            </div>


            {{-- =================================================
                PREVIEW
            ================================================== --}}

            <div id="preview-section"
                 class="mt-6 hidden">

                <div class="mb-3 flex items-center
                            justify-between">

                    <h3 class="text-sm font-semibold
                               text-gray-900 dark:text-white">

                        Preview Gambar

                    </h3>


                    <button
                        type="button"
                        id="remove-image"
                        class="text-sm font-medium
                               text-red-600 hover:text-red-700">

                        Hapus

                    </button>

                </div>


                <div class="relative overflow-hidden
                            rounded-2xl bg-gray-950">

                    <img
                        id="image-preview"
                        src=""
                        alt="Preview gambar"
                        class="mx-auto max-h-[600px]
                               w-full object-contain"
                    >


                    {{-- DETECTION CANVAS --}}

                    <canvas
                        id="detection-canvas"
                        class="pointer-events-none
                               absolute inset-0
                               h-full w-full">
                    </canvas>

                </div>

            </div>


            {{-- =================================================
                BUTTON
            ================================================== --}}

            <div class="mt-5 flex flex-wrap gap-3">

                <button
                    type="button"
                    id="choose-button"
                    class="inline-flex items-center gap-2
                           rounded-xl bg-gray-100
                           px-5 py-3
                           text-sm font-semibold
                           text-gray-700
                           transition hover:bg-gray-200
                           dark:bg-gray-800
                           dark:text-gray-200
                           dark:hover:bg-gray-700">

                    <svg class="h-5 w-5"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="1.8">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M12 16V4m0 0l-4 4m4-4l4 4"/>

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M4 16v3a1 1 0 001 1h14a1 1 0 001-1v-3"/>

                    </svg>

                    Pilih Gambar

                </button>


                <button
                    type="button"
                    id="detect-button"
                    disabled
                    class="inline-flex items-center gap-2
                           rounded-xl bg-blue-600
                           px-5 py-3
                           text-sm font-semibold
                           text-white shadow-sm
                           transition hover:bg-blue-700
                           disabled:cursor-not-allowed
                           disabled:opacity-40">

                    <svg class="h-5 w-5"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="1.8">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M9 12l2 2 4-4"/>

                        <circle cx="12"
                                cy="12"
                                r="9"/>

                    </svg>

                    Mulai Deteksi

                </button>


                <button
                    type="button"
                    id="reset-button"
                    class="hidden inline-flex items-center gap-2
                           rounded-xl bg-red-500
                           px-5 py-3
                           text-sm font-semibold
                           text-white
                           transition hover:bg-red-600">

                    Reset

                </button>

            </div>


            {{-- =================================================
                LOADING
            ================================================== --}}

            <div id="loading"
                 class="mt-5 hidden rounded-xl
                        border border-blue-200
                        bg-blue-50 p-4
                        dark:border-blue-900
                        dark:bg-blue-950/30">

                <div class="flex items-center gap-3">

                    <div class="h-6 w-6
                                animate-spin rounded-full
                                border-4 border-blue-200
                                border-t-blue-600">
                    </div>

                    <div>

                        <p class="text-sm font-semibold
                                  text-blue-700
                                  dark:text-blue-400">

                            YOLOv11 sedang mendeteksi...

                        </p>

                        <p class="mt-1 text-xs
                                  text-blue-600
                                  dark:text-blue-500">

                            Mohon tunggu sebentar.

                        </p>

                    </div>

                </div>

            </div>


            {{-- =================================================
                ERROR
            ================================================== --}}

            <div id="error-box"
                 class="mt-5 hidden rounded-xl
                        border border-red-200
                        bg-red-50 p-4
                        dark:border-red-900
                        dark:bg-red-950/30">

                <p class="text-sm font-semibold
                          text-red-700
                          dark:text-red-400">

                    Deteksi gagal

                </p>

                <p id="error-message"
                   class="mt-1 text-xs
                          text-red-600
                          dark:text-red-400">
                </p>

            </div>


            {{-- =================================================
                RESULT STATISTICS
            ================================================== --}}

            <div class="mt-6 grid gap-4
                        md:grid-cols-3">

                {{-- TOTAL --}}

                <div class="rounded-xl border
                            border-gray-200
                            bg-gray-50 p-5
                            dark:border-gray-800
                            dark:bg-gray-800/50">

                    <p class="text-xs font-medium
                              uppercase tracking-wider
                              text-gray-500
                              dark:text-gray-400">

                        Total Deteksi

                    </p>

                    <p id="total-detection"
                       class="mt-2 text-3xl font-bold
                              text-gray-900
                              dark:text-white">

                        0

                    </p>

                </div>


                {{-- WITH HELMET --}}

                <div class="rounded-xl border
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

                    <p id="helmet-count"
                       class="mt-2 text-3xl font-bold
                              text-green-700
                              dark:text-green-400">

                        0

                    </p>

                </div>


                {{-- WITHOUT HELMET --}}

                <div class="rounded-xl border
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

                    <p id="without-helmet-count"
                       class="mt-2 text-3xl font-bold
                              text-red-700
                              dark:text-red-400">

                        0

                    </p>

                </div>

            </div>


            {{-- =================================================
                DETECTION DETAIL
            ================================================== --}}

            <div id="detection-detail"
                 class="mt-5 hidden">

                <h3 class="mb-3 text-sm font-semibold
                           text-gray-900 dark:text-white">

                    Detail Deteksi

                </h3>

                <div id="detection-list"
                     class="space-y-2">
                </div>

            </div>

        </div>

    </div>

</div>


{{-- =========================================================
    JAVASCRIPT
========================================================= --}}

@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    // =====================================================
    // ELEMENT
    // =====================================================

    const uploadArea =
        document.getElementById('upload-area');

    const imageInput =
        document.getElementById('image-input');

    const chooseButton =
        document.getElementById('choose-button');

    const detectButton =
        document.getElementById('detect-button');

    const removeButton =
        document.getElementById('remove-image');

    const resetButton =
        document.getElementById('reset-button');

    const previewSection =
        document.getElementById('preview-section');

    const imagePreview =
        document.getElementById('image-preview');

    const canvas =
        document.getElementById('detection-canvas');

    const loading =
        document.getElementById('loading');

    const errorBox =
        document.getElementById('error-box');

    const errorMessage =
        document.getElementById('error-message');

    const totalDetection =
        document.getElementById('total-detection');

    const helmetCount =
        document.getElementById('helmet-count');

    const withoutHelmetCount =
        document.getElementById(
            'without-helmet-count'
        );

    const detectionDetail =
        document.getElementById(
            'detection-detail'
        );

    const detectionList =
        document.getElementById(
            'detection-list'
        );


    // =====================================================
    // STATE
    // =====================================================

    let selectedFile = null;


    // =====================================================
    // OPEN FILE
    // =====================================================

    uploadArea.addEventListener(
        'click',
        function () {

            imageInput.click();

        }
    );


    chooseButton.addEventListener(
        'click',
        function () {

            imageInput.click();

        }
    );


    // =====================================================
    // FILE SELECTED
    // =====================================================

    imageInput.addEventListener(
        'change',
        function () {

            const file =
                this.files[0];

            if (!file) {

                return;

            }

            handleImage(file);

        }
    );


    // =====================================================
    // HANDLE IMAGE
    // =====================================================

    function handleImage(file) {

        hideError();


        // -------------------------------------------------
        // VALIDASI
        // -------------------------------------------------

        const allowedTypes = [
            'image/jpeg',
            'image/jpg',
            'image/png'
        ];


        if (
            !allowedTypes.includes(
                file.type
            )
        ) {

            showError(
                'Format gambar harus JPG, JPEG, atau PNG.'
            );

            return;

        }


        // -------------------------------------------------
        // MAX 10 MB
        // -------------------------------------------------

        if (
            file.size >
            10 * 1024 * 1024
        ) {

            showError(
                'Ukuran gambar maksimal 10 MB.'
            );

            return;

        }


        selectedFile =
            file;


        // -------------------------------------------------
        // PREVIEW
        // -------------------------------------------------

        const reader =
            new FileReader();


        reader.onload =
            function (event) {

                imagePreview.src =
                    event.target.result;


                previewSection.classList.remove(
                    'hidden'
                );


                uploadArea.classList.add(
                    'hidden'
                );


                detectButton.disabled =
                    false;


                resetButton.classList.remove(
                    'hidden'
                );


                clearResults();

            };


        reader.readAsDataURL(
            file
        );

    }


    // =====================================================
    // REMOVE IMAGE
    // =====================================================

    removeButton.addEventListener(
        'click',
        resetAll
    );


    resetButton.addEventListener(
        'click',
        resetAll
    );


    // =====================================================
    // RESET
    // =====================================================

    function resetAll() {

        selectedFile =
            null;


        imageInput.value =
            '';


        imagePreview.src =
            '';


        previewSection.classList.add(
            'hidden'
        );


        uploadArea.classList.remove(
            'hidden'
        );


        detectButton.disabled =
            true;


        resetButton.classList.add(
            'hidden'
        );


        clearResults();


        hideError();


        clearCanvas();

    }


    // =====================================================
    // DETECT BUTTON
    // =====================================================

    detectButton.addEventListener(
        'click',
        detectImage
    );


    // =====================================================
    // DETECT IMAGE
    // =====================================================

    async function detectImage() {

        if (!selectedFile) {

            showError(
                'Silakan pilih gambar terlebih dahulu.'
            );

            return;

        }


        // -------------------------------------------------
        // UI LOADING
        // -------------------------------------------------

        detectButton.disabled =
            true;


        loading.classList.remove(
            'hidden'
        );


        hideError();


        try {

            // -------------------------------------------------
            // FORMDATA
            // -------------------------------------------------

            const formData =
                new FormData();


            formData.append(
                'file',
                selectedFile,
                selectedFile.name
            );


            // -------------------------------------------------
            // KIRIM KE FASTAPI
            // -------------------------------------------------

            const response =
                await fetch(
                    'http://127.0.0.1:8001/detect',
                    {
                        method: 'POST',
                        body: formData
                    }
                );


            // -------------------------------------------------
            // RESPONSE ERROR
            // -------------------------------------------------

            if (!response.ok) {

                let message =
                    'Server YOLOv11 mengembalikan error.';


                try {

                    const errorData =
                        await response.json();


                    if (
                        errorData.message
                    ) {

                        message =
                            errorData.message;

                    }

                }
                catch (e) {

                    // gunakan pesan default

                }


                throw new Error(
                    message
                );

            }


            // -------------------------------------------------
            // JSON
            // -------------------------------------------------

            const result =
                await response.json();


            if (
                !result.success
            ) {

                throw new Error(
                    result.message ||
                    'Deteksi gagal.'
                );

            }


            // -------------------------------------------------
            // DETECTIONS
            // -------------------------------------------------

            const detections =
                Array.isArray(
                    result.detections
                )
                    ? result.detections
                    : [];


            // -------------------------------------------------
            // DRAW
            // -------------------------------------------------

            await drawDetections(
                detections
            );


            // -------------------------------------------------
            // STATISTICS
            // -------------------------------------------------

            updateStatistics(
                detections
            );


            // -------------------------------------------------
            // DETAIL
            // -------------------------------------------------

            updateDetectionDetail(
                detections
            );


            // =================================================
            // SIMPAN SEMUA HASIL DETEKSI
            // =================================================

            await saveDetections(
                detections
            );

        }
        catch (error) {

            console.error(
                'Image detection error:',
                error
            );


            showError(
                error.message ||
                'Tidak dapat terhubung ke YOLOv11.'
            );

        }
        finally {

            loading.classList.add(
                'hidden'
            );


            detectButton.disabled =
                false;

        }

    }


    // =====================================================
    // SIMPAN SEMUA HASIL DETEKSI
    // =====================================================

    async function saveDetections(
        detections
    ) {

        if (!selectedFile) {
            return;
        }

        if (!Array.isArray(detections) || detections.length === 0) {
            return;
        }

        // -------------------------------------------------
        // SIMPAN SATU PER SATU
        // -------------------------------------------------
        for (const detection of detections) {

            try {

                const formData =
                    new FormData();

                // -------------------------------------------------
                // GAMBAR
                // -------------------------------------------------
                formData.append(
                    'image',
                    selectedFile
                );

                // -------------------------------------------------
                // CLASS
                // -------------------------------------------------
                formData.append(
                    'class_name',
                    detection.class_name
                );

                // -------------------------------------------------
                // CONFIDENCE
                // -------------------------------------------------
                formData.append(
                    'confidence',
                    detection.confidence ?? 0
                );

                // -------------------------------------------------
                // BOUNDING BOX
                // -------------------------------------------------
                formData.append(
                    'x1',
                    detection.x1 ?? ''
                );

                formData.append(
                    'y1',
                    detection.y1 ?? ''
                );

                formData.append(
                    'x2',
                    detection.x2 ?? ''
                );

                formData.append(
                    'y2',
                    detection.y2 ?? ''
                );

                // -------------------------------------------------
                // KIRIM KE LARAVEL
                // -------------------------------------------------
                const response =
                    await fetch(
                        '/api/store-violation',
                        {
                            method: 'POST',
                            headers: {
                                'Accept':
                                    'application/json'
                            },
                            body: formData
                        }
                    );

                // -------------------------------------------------
                // RESPONSE
                // -------------------------------------------------
                const result =
                    await response.json();

                if (
                    !response.ok ||
                    !result.success
                ) {

                    console.error(
                        'Gagal menyimpan hasil deteksi:',
                        result
                    );

                    continue;
                }

                console.log(
                    'Hasil deteksi berhasil disimpan:',
                    result
                );

            } catch (error) {

                console.error(
                    'Error menyimpan hasil deteksi:',
                    error
                );
            }
        }
    }


    // =====================================================
    // DRAW DETECTIONS
    // =====================================================

    async function drawDetections(
        detections
    ) {

        const image =
            imagePreview;


        if (!image.complete) {

            await new Promise(
                resolve => {

                    image.onload =
                        resolve;

                }
            );

        }


        const rect =
            image.getBoundingClientRect();


        const naturalWidth =
            image.naturalWidth;


        const naturalHeight =
            image.naturalHeight;


        if (
            !naturalWidth ||
            !naturalHeight
        ) {

            return;

        }


        // -------------------------------------------------
        // CANVAS SIZE
        // -------------------------------------------------

        canvas.width =
            rect.width;


        canvas.height =
            rect.height;


        const ctx =
            canvas.getContext(
                '2d'
            );


        ctx.clearRect(
            0,
            0,
            canvas.width,
            canvas.height
        );


        // -------------------------------------------------
        // OBJECT-CONTAIN SCALE
        // -------------------------------------------------

        const scale =
            Math.min(
                rect.width /
                    naturalWidth,

                rect.height /
                    naturalHeight
            );


        const renderedWidth =
            naturalWidth *
            scale;


        const renderedHeight =
            naturalHeight *
            scale;


        const offsetX =
            (
                rect.width -
                renderedWidth
            ) / 2;


        const offsetY =
            (
                rect.height -
                renderedHeight
            ) / 2;


        // -------------------------------------------------
        // DRAW EACH BOX
        // -------------------------------------------------

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
                    x1 * scale;


                const boxY =
                    offsetY +
                    y1 * scale;


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


                const color =
                    className ===
                    'With_helmet'
                        ? '#22c55e'
                        : '#ef4444';


                // -------------------------------------------------
                // BOX
                // -------------------------------------------------

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


                // -------------------------------------------------
                // LABEL
                // -------------------------------------------------

                const label =
                    className +
                    ' ' +
                    (
                        confidence *
                        100
                    ).toFixed(1) +
                    '%';


                ctx.font =
                    'bold 15px Arial';


                const textWidth =
                    ctx.measureText(
                        label
                    ).width;


                const labelHeight =
                    30;


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
                    textWidth + 18,
                    labelHeight
                );


                ctx.fillStyle =
                    '#ffffff';


                ctx.fillText(
                    label,
                    boxX + 9,
                    labelY + 20
                );

            }
        );

    }


    // =====================================================
    // STATISTICS
    // =====================================================

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


        totalDetection.textContent =
            detections.length;


        helmetCount.textContent =
            helmet;


        withoutHelmetCount.textContent =
            withoutHelmet;

    }


    // =====================================================
    // DETECTION DETAIL
    // =====================================================

    function updateDetectionDetail(
        detections
    ) {

        detectionList.innerHTML =
            '';


        if (
            detections.length === 0
        ) {

            detectionDetail.classList.add(
                'hidden'
            );

            return;

        }


        detectionDetail.classList.remove(
            'hidden'
        );


        detections.forEach(
            (detection, index) => {

                const isHelmet =
                    detection.class_name ===
                    'With_helmet';


                const colorClass =
                    isHelmet

                        ? 'border-green-200 bg-green-50 dark:border-green-900 dark:bg-green-950/20'

                        : 'border-red-200 bg-red-50 dark:border-red-900 dark:bg-red-950/20';


                const textClass =
                    isHelmet

                        ? 'text-green-700 dark:text-green-400'

                        : 'text-red-700 dark:text-red-400';


                const confidence =
                    (
                        Number(
                            detection.confidence ||
                            0
                        ) *
                        100
                    ).toFixed(1);


                const item =
                    document.createElement(
                        'div'
                    );


                item.className =
                    `flex items-center justify-between rounded-xl border p-4 ${colorClass}`;


                item.innerHTML = `

                    <div>

                        <p class="text-sm font-semibold ${textClass}">

                            Deteksi #${index + 1}

                        </p>

                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">

                            ${detection.class_name}

                        </p>

                    </div>


                    <span class="rounded-lg bg-white px-3 py-1 text-xs font-bold ${textClass} dark:bg-gray-900">

                        ${confidence}%

                    </span>

                `;


                detectionList.appendChild(
                    item
                );

            }
        );

    }


    // =====================================================
    // CLEAR RESULTS
    // =====================================================

    function clearResults() {

        totalDetection.textContent =
            '0';


        helmetCount.textContent =
            '0';


        withoutHelmetCount.textContent =
            '0';


        detectionDetail.classList.add(
            'hidden'
        );


        detectionList.innerHTML =
            '';

    }


    // =====================================================
    // CLEAR CANVAS
    // =====================================================

    function clearCanvas() {

        const ctx =
            canvas.getContext(
                '2d'
            );


        ctx.clearRect(
            0,
            0,
            canvas.width,
            canvas.height
        );

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


});

</script>

@endpush

@endsection