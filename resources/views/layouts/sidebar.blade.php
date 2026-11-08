{{-- =========================================================
    WASKARA - Sidebar
    YOLOv11 Helmet Safety Detection System
========================================================= --}}

<aside
    id="sidebar"
    x-data
    :class="{
        'translate-x-0': $store.sidebar.isMobileOpen,
        '-translate-x-full': !$store.sidebar.isMobileOpen,
        'xl:translate-x-0': true
    }"
    @mouseenter="$store.sidebar.setHovered(true)"
    @mouseleave="$store.sidebar.setHovered(false)"
    class="
        fixed
        inset-y-0
        left-0
        z-[9999]
        flex
        w-[290px]
        flex-col
        border-r
        border-gray-200
        bg-white
        transition-all
        duration-300
        ease-in-out
        dark:border-gray-800
        dark:bg-gray-900
        xl:translate-x-0
    "
>

    {{-- =====================================================
        LOGO
    ====================================================== --}}

    <div
        class="
            flex
            h-20
            items-center
            justify-between
            border-b
            border-gray-200
            px-5
            dark:border-gray-800
        "
    >

        <a
            href="{{ route('dashboard') }}"
            class="flex items-center gap-3"
        >

            <div>

                <h1
                    class="
                        text-xl
                        font-bold
                        tracking-wide
                        text-gray-900
                        dark:text-white
                    "
                >
                    WASKARA
                </h1>

                <p
                    class="
                        text-[10px]
                        font-medium
                        uppercase
                        tracking-wider
                        text-gray-500
                        dark:text-gray-400
                    "
                >
                    Helmet Safety System
                </p>

            </div>

        </a>


        {{-- Tombol Tutup Mobile --}}
        <button
            type="button"
            @click="$store.sidebar.setMobileOpen(false)"
            class="
                rounded-lg
                p-2
                text-gray-500
                hover:bg-gray-100
                hover:text-gray-700
                dark:hover:bg-gray-800
                dark:hover:text-white
                xl:hidden
            "
            aria-label="Tutup Sidebar"
        >

            <svg
                class="h-5 w-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
            >

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M6 18L18 6M6 6l12 12"
                />

            </svg>

        </button>

    </div>


    {{-- =====================================================
        MENU
    ====================================================== --}}

    <div
        class="
            flex
            flex-1
            flex-col
            overflow-y-auto
            px-4
            py-6
        "
    >

        {{-- =================================================
            DASHBOARD
        ================================================== --}}

        <div class="mb-6">

            <p
                class="
                    mb-3
                    px-3
                    text-[11px]
                    font-semibold
                    uppercase
                    tracking-wider
                    text-gray-400
                "
            >
                Dashboard
            </p>

            <a
                href="{{ route('dashboard.index') }}"
                class="
                    flex
                    items-center
                    gap-3
                    rounded-xl
                    px-3
                    py-3
                    text-sm
                    font-medium
                    text-gray-700
                    transition
                    hover:bg-brand-50
                    hover:text-brand-600
                    dark:text-gray-300
                    dark:hover:bg-gray-800
                    dark:hover:text-brand-400
                "
            >

                <svg
                    class="h-5 w-5 shrink-0"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8"
                >

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M3 13h8V3H3v10zM13 21h8V11h-8v10zM13 3h8v6h-8V3zM3 17h8v4H3v-4z"
                    />

                </svg>

                <span>Dashboard</span>

            </a>

        </div>


        {{-- =================================================
            LIVE DETECTION
        ================================================== --}}

        <div class="mb-6">

            <p
                class="
                    mb-3
                    px-3
                    text-[11px]
                    font-semibold
                    uppercase
                    tracking-wider
                    text-gray-400
                "
            >
                Live Detection
            </p>


            {{-- Webcam --}}

            <a
                href="{{ route('detection.index') }}"
                class="
                    mb-1
                    flex
                    items-center
                    gap-3
                    rounded-xl
                    px-3
                    py-3
                    text-sm
                    font-medium
                    text-gray-700
                    transition
                    hover:bg-brand-50
                    hover:text-brand-600
                    dark:text-gray-300
                    dark:hover:bg-gray-800
                    dark:hover:text-brand-400
                "
            >

                <svg
                    class="h-5 w-5 shrink-0"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8"
                >

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
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

                <span>Webcam (Realtime)</span>

            </a>


            {{-- Video --}}

            <a
                href="{{ route('video') }}"
                class="
                    mb-1
                    flex
                    items-center
                    gap-3
                    rounded-xl
                    px-3
                    py-3
                    text-sm
                    font-medium
                    text-gray-700
                    transition
                    hover:bg-brand-50
                    hover:text-brand-600
                    dark:text-gray-300
                    dark:hover:bg-gray-800
                    dark:hover:text-brand-400
                "
            >

                <svg
                    class="h-5 w-5 shrink-0"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8"
                >

                    <rect
                        x="3"
                        y="5"
                        width="18"
                        height="14"
                        rx="2"
                    />

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M10 9l5 3-5 3V9z"
                    />

                </svg>

                <span>Video</span>

            </a>


            {{-- Gambar --}}

            <a
                href="{{ route('image') }}"
                class="
                    mb-1
                    flex
                    items-center
                    gap-3
                    rounded-xl
                    px-3
                    py-3
                    text-sm
                    font-medium
                    text-gray-700
                    transition
                    hover:bg-brand-50
                    hover:text-brand-600
                    dark:text-gray-300
                    dark:hover:bg-gray-800
                    dark:hover:text-brand-400
                "
            >

                <svg
                    class="h-5 w-5 shrink-0"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8"
                >

                    <rect
                        x="3"
                        y="4"
                        width="18"
                        height="16"
                        rx="2"
                    />

                    <circle
                        cx="8.5"
                        cy="9"
                        r="1.5"
                    />

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M21 15l-5-5L5 20"
                    />

                </svg>

                <span>Gambar</span>

            </a>


            {{-- CCTV / ATCS --}}

            <a
                href="{{ route('cctv') }}"
                class="
                    flex
                    items-center
                    justify-between
                    rounded-xl
                    px-3
                    py-3
                    text-sm
                    font-medium
                    text-gray-700
                    transition
                    hover:bg-brand-50
                    hover:text-brand-600
                    dark:text-gray-300
                    dark:hover:bg-gray-800
                    dark:hover:text-brand-400
                "
            >

                <div class="flex items-center gap-3">

                    <svg
                        class="h-5 w-5 shrink-0"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M4 7h16v10H4z"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M8 17v3m8-3v3M7 20h10"
                        />

                    </svg>

                    <span>CCTV / ATCS</span>

                </div>

                <span
                    class="
                        rounded-full
                        bg-gray-100
                        px-2
                        py-0.5
                        text-[9px]
                        font-semibold
                        text-gray-500
                        dark:bg-gray-800
                        dark:text-gray-400
                    "
                >
                    Soon
                </span>

            </a>

        </div>


        {{-- =================================================
            ANALITIK
        ================================================== --}}

        <div class="mb-6">

            <p
                class="
                    mb-3
                    px-3
                    text-[11px]
                    font-semibold
                    uppercase
                    tracking-wider
                    text-gray-400
                "
            >
                Analitik
            </p>


            {{-- Statistik --}}

            <a
                href="{{ route('analytics.index') }}"
                class="
                    mb-1
                    flex
                    items-center
                    gap-3
                    rounded-xl
                    px-3
                    py-3
                    text-sm
                    font-medium
                    text-gray-700
                    transition
                    hover:bg-brand-50
                    hover:text-brand-600
                    dark:text-gray-300
                    dark:hover:bg-gray-800
                    dark:hover:text-brand-400
                "
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
                        d="M4 19V5m0 14h16"
                    />

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M7 16l3-4 3 2 5-7"
                    />

                </svg>

                <span>Statistik</span>

            </a>


            {{-- Evaluasi Model --}}

            <a
                href="{{ route('evaluation.index') }}"
                class="
                    flex
                    items-center
                    gap-3
                    rounded-xl
                    px-3
                    py-3
                    text-sm
                    font-medium
                    text-gray-700
                    transition
                    hover:bg-brand-50
                    hover:text-brand-600
                    dark:text-gray-300
                    dark:hover:bg-gray-800
                    dark:hover:text-brand-400
                "
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
                        d="M5 20V10m7 10V4m7 16v-7"
                    />

                </svg>

                <span>Evaluasi Model</span>

            </a>

        </div>


        {{-- =================================================
            RIWAYAT
        ================================================== --}}

        <div class="mb-6">

            <p
                class="
                    mb-3
                    px-3
                    text-[11px]
                    font-semibold
                    uppercase
                    tracking-wider
                    text-gray-400
                "
            >
                Riwayat
            </p>


            {{-- Riwayat Pelanggaran --}}

            <a
                href="{{ route('violations.index') }}"
                class="
                    mb-1
                    flex
                    items-center
                    gap-3
                    rounded-xl
                    px-3
                    py-3
                    text-sm
                    font-medium
                    text-gray-700
                    transition
                    hover:bg-brand-50
                    hover:text-brand-600
                    dark:text-gray-300
                    dark:hover:bg-gray-800
                    dark:hover:text-brand-400
                "
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
                        d="M12 8v4l3 2"
                    />

                    <circle
                        cx="12"
                        cy="12"
                        r="9"
                    />

                </svg>

                <span>Riwayat Pelanggaran</span>

            </a>


            {{-- Export Data --}}

            <a
                href="{{ route('export.index') }}"
                class="
                    flex
                    items-center
                    gap-3
                    rounded-xl
                    px-3
                    py-3
                    text-sm
                    font-medium
                    text-gray-700
                    transition
                    hover:bg-brand-50
                    hover:text-brand-600
                    dark:text-gray-300
                    dark:hover:bg-gray-800
                    dark:hover:text-brand-400
                "
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

                <span>Export Data</span>

            </a>

        </div>


        {{-- =================================================
            SISTEM
        ================================================== --}}

        <div class="mb-6">

            <p
                class="
                    mb-3
                    px-3
                    text-[11px]
                    font-semibold
                    uppercase
                    tracking-wider
                    text-gray-400
                "
            >
                Sistem
            </p>


            {{-- Pengaturan --}}

            <a
                href="{{ route('settings.index') }}"
                class="
                    mb-1
                    flex
                    items-center
                    gap-3
                    rounded-xl
                    px-3
                    py-3
                    text-sm
                    font-medium
                    text-gray-700
                    transition
                    hover:bg-brand-50
                    hover:text-brand-600
                    dark:text-gray-300
                    dark:hover:bg-gray-800
                    dark:hover:text-brand-400
                "
            >

                <svg
                    class="h-5 w-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8"
                >

                    <circle
                        cx="12"
                        cy="12"
                        r="3"
                    />

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M19.4 15a1.7 1.7 0 00.34 1.88l.06.06-1.7 1.7-.06-.06a1.7 1.7 0 00-1.88-.34 1.7 1.7 0 00-1.03 1.56V20h-2.4v-.09a1.7 1.7 0 00-1.03-1.56 1.7 1.7 0 00-1.88.34l-.06.06-1.7-1.7.06-.06A1.7 1.7 0 008.4 15a1.7 1.7 0 00-1.56-1.03H6v-2.4h.09A1.7 1.7 0 007.65 10a1.7 1.7 0 00-.34-1.88l-.06-.06 1.7-1.7.06.06A1.7 1.7 0 0010.89 6.1 1.7 1.7 0 0011.92 4.5V4h2.4v.5a1.7 1.7 0 001.03 1.6 1.7 1.7 0 001.88-.34l.06-.06 1.7 1.7-.06.06A1.7 1.7 0 0018.6 10a1.7 1.7 0 001.56 1.03h.09v2.4h-.09A1.7 1.7 0 0019.4 15z"
                    />

                </svg>

                <span>Pengaturan</span>

            </a>


            {{-- Tentang WASKARA --}}

            <a
                href="{{ route('about.index') }}"
                class="
                    flex
                    items-center
                    gap-3
                    rounded-xl
                    px-3
                    py-3
                    text-sm
                    font-medium
                    text-gray-700
                    transition
                    hover:bg-brand-50
                    hover:text-brand-600
                    dark:text-gray-300
                    dark:hover:bg-gray-800
                    dark:hover:text-brand-400
                "
            >

                <svg
                    class="h-5 w-5"
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
                        stroke-linejoin="round"
                        d="M12 10v6"
                    />

                    <circle
                        cx="12"
                        cy="7"
                        r=".8"
                        fill="currentColor"
                    />

                </svg>

                <span>Tentang WASKARA</span>

            </a>

        </div>

    </div>


    {{-- =====================================================
        FOOTER SIDEBAR
    ====================================================== --}}

    <div
        class="
            border-t
            border-gray-200
            p-4
            dark:border-gray-800
        "
    >

        <div
            class="
                rounded-xl
                bg-gray-50
                p-4
                dark:bg-gray-800/50
            "
        >

            <div class="mb-2 flex items-center gap-2">

                <span
                    class="
                        h-2
                        w-2
                        rounded-full
                        bg-green-500
                    "
                ></span>

                <span
                    class="
                        text-xs
                        font-semibold
                        text-gray-700
                        dark:text-gray-200
                    "
                >
                    Sistem Aktif
                </span>

            </div>

            <p
                class="
                    text-[11px]
                    leading-relaxed
                    text-gray-500
                    dark:text-gray-400
                "
            >
                YOLOv11 Helmet Detection
            </p>

        </div>

    </div>

</aside>