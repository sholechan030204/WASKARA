<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    class="h-full"
>
<head>

    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>
        {{ $title ?? 'WASKARA' }} | WASKARA YOLOv11
    </title>


    {{-- =====================================================
        VITE
    ====================================================== --}}

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])


    {{-- =====================================================
        ALPINE.JS
    ====================================================== --}}

    <script
        defer
        src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"
    ></script>


    {{-- =====================================================
        ALPINE STORE
    ====================================================== --}}

    <script>

        document.addEventListener('alpine:init', () => {

            /*
            |--------------------------------------------------------------------------
            | THEME
            |--------------------------------------------------------------------------
            */

            Alpine.store('theme', {

                theme: 'light',


                /*
                |--------------------------------------------------------------------------
                | INITIALIZE
                |--------------------------------------------------------------------------
                */

                init() {

                    const savedTheme =
                        localStorage.getItem('theme');

                    const systemTheme =
                        window.matchMedia(
                            '(prefers-color-scheme: dark)'
                        ).matches
                            ? 'dark'
                            : 'light';


                    this.theme =
                        savedTheme || systemTheme;


                    this.updateTheme();

                },


                /*
                |--------------------------------------------------------------------------
                | TOGGLE
                |--------------------------------------------------------------------------
                */

                toggle() {

                    this.theme =
                        this.theme === 'light'
                            ? 'dark'
                            : 'light';


                    localStorage.setItem(
                        'theme',
                        this.theme
                    );


                    this.updateTheme();

                },


                /*
                |--------------------------------------------------------------------------
                | UPDATE THEME
                |--------------------------------------------------------------------------
                */

                updateTheme() {

                    const html =
                        document.documentElement;

                    const body =
                        document.body;


                    if (
                        this.theme === 'dark'
                    ) {

                        html.classList.add(
                            'dark'
                        );

                        body.classList.add(
                            'dark'
                        );

                    } else {

                        html.classList.remove(
                            'dark'
                        );

                        body.classList.remove(
                            'dark'
                        );

                    }

                }

            });


            /*
            |--------------------------------------------------------------------------
            | SIDEBAR
            |--------------------------------------------------------------------------
            */

            Alpine.store('sidebar', {

                /*
                |--------------------------------------------------------------------------
                | DESKTOP
                |--------------------------------------------------------------------------
                */

                isExpanded:
                    window.innerWidth >= 1280,


                /*
                |--------------------------------------------------------------------------
                | MOBILE
                |--------------------------------------------------------------------------
                */

                isMobileOpen: false,


                /*
                |--------------------------------------------------------------------------
                | HOVER DESKTOP
                |--------------------------------------------------------------------------
                */

                isHovered: false,


                /*
                |--------------------------------------------------------------------------
                | DESKTOP TOGGLE
                |--------------------------------------------------------------------------
                */

                toggleExpanded() {

                    if (
                        window.innerWidth < 1280
                    ) {

                        this.toggleMobileOpen();

                        return;

                    }


                    this.isExpanded =
                        !this.isExpanded;


                    this.isMobileOpen =
                        false;

                },


                /*
                |--------------------------------------------------------------------------
                | MOBILE TOGGLE
                |--------------------------------------------------------------------------
                */

                toggleMobileOpen() {

                    if (
                        window.innerWidth >= 1280
                    ) {

                        return;

                    }


                    this.isMobileOpen =
                        !this.isMobileOpen;

                },


                /*
                |--------------------------------------------------------------------------
                | SET MOBILE
                |--------------------------------------------------------------------------
                */

                setMobileOpen(value) {

                    this.isMobileOpen =
                        Boolean(value);

                },


                /*
                |--------------------------------------------------------------------------
                | HOVER DESKTOP
                |--------------------------------------------------------------------------
                */

                setHovered(value) {

                    if (
                        window.innerWidth >= 1280 &&
                        !this.isExpanded
                    ) {

                        this.isHovered =
                            value;

                    }

                },


                /*
                |--------------------------------------------------------------------------
                | RESET MOBILE
                |--------------------------------------------------------------------------
                */

                closeMobile() {

                    this.isMobileOpen =
                        false;

                }

            });

        });

    </script>


    {{-- =====================================================
        APPLY THEME BEFORE PAGE LOAD
        MENCEGAH FLASH SAAT REFRESH
    ====================================================== --}}

    <script>

        (function () {

            const savedTheme =
                localStorage.getItem('theme');


            const systemTheme =
                window.matchMedia(
                    '(prefers-color-scheme: dark)'
                ).matches
                    ? 'dark'
                    : 'light';


            const theme =
                savedTheme || systemTheme;


            if (
                theme === 'dark'
            ) {

                document.documentElement.classList.add(
                    'dark'
                );

            } else {

                document.documentElement.classList.remove(
                    'dark'
                );

            }

        })();

    </script>


    {{-- =====================================================
        GLOBAL DARK / LIGHT MODE
    ====================================================== --}}

    <style>

        /*
        |--------------------------------------------------------------------------
        | ROOT
        |--------------------------------------------------------------------------
        */

        html {
            color-scheme: light;
        }


        html.dark {
            color-scheme: dark;
        }


        /*
        |--------------------------------------------------------------------------
        | BODY
        |--------------------------------------------------------------------------
        */

        body {

            background-color: #f9fafb;

            color: #1f2937;

            transition:
                background-color 0.2s ease,
                color 0.2s ease;

        }


        html.dark body {

            background-color: #111827 !important;

            color: #f9fafb !important;

        }


        /*
        |--------------------------------------------------------------------------
        | GLOBAL BACKGROUND
        |--------------------------------------------------------------------------
        */

        html.dark .bg-white {

            background-color: #111827 !important;

        }


        html.dark .bg-gray-50 {

            background-color: #111827 !important;

        }


        html.dark .bg-gray-100 {

            background-color: #1f2937 !important;

        }


        html.dark .bg-gray-200 {

            background-color: #374151 !important;

        }


        /*
        |--------------------------------------------------------------------------
        | GLOBAL TEXT
        |--------------------------------------------------------------------------
        */

        html.dark .text-gray-900 {

            color: #f9fafb !important;

        }


        html.dark .text-gray-800 {

            color: #f3f4f6 !important;

        }


        html.dark .text-gray-700 {

            color: #e5e7eb !important;

        }


        html.dark .text-gray-600 {

            color: #d1d5db !important;

        }


        html.dark .text-gray-500 {

            color: #9ca3af !important;

        }


        html.dark .text-gray-400 {

            color: #9ca3af !important;

        }


        /*
        |--------------------------------------------------------------------------
        | BORDER
        |--------------------------------------------------------------------------
        */

        html.dark .border-gray-100 {

            border-color: #374151 !important;

        }


        html.dark .border-gray-200 {

            border-color: #374151 !important;

        }


        html.dark .border-gray-300 {

            border-color: #4b5563 !important;

        }


        /*
        |--------------------------------------------------------------------------
        | DIVIDE
        |--------------------------------------------------------------------------
        */

        html.dark .divide-gray-100
        > :not([hidden]) ~ :not([hidden]) {

            border-color: #374151 !important;

        }


        html.dark .divide-gray-200
        > :not([hidden]) ~ :not([hidden]) {

            border-color: #374151 !important;

        }


        /*
        |--------------------------------------------------------------------------
        | INPUT
        |--------------------------------------------------------------------------
        */

        html.dark input:not(
            [type="checkbox"]
        ):not(
            [type="radio"]
        ),
        html.dark textarea,
        html.dark select {

            background-color: #1f2937 !important;

            color: #f9fafb !important;

            border-color: #4b5563 !important;

        }


        html.dark input::placeholder,
        html.dark textarea::placeholder {

            color: #9ca3af !important;

        }


        /*
        |--------------------------------------------------------------------------
        | TABLE
        |--------------------------------------------------------------------------
        */

        html.dark table {

            color: #f9fafb;

        }


        html.dark thead {

            background-color: #1f2937 !important;

        }


        html.dark tbody tr:hover {

            background-color: #1f2937 !important;

        }


        /*
        |--------------------------------------------------------------------------
        | LINKS NETRAL
        |--------------------------------------------------------------------------
        */

        html.dark a.text-gray-900 {

            color: #f9fafb !important;

        }


        html.dark a.text-gray-800 {

            color: #f3f4f6 !important;

        }


        html.dark a.text-gray-700 {

            color: #e5e7eb !important;

        }


        /*
        |--------------------------------------------------------------------------
        | PLACEHOLDER
        |--------------------------------------------------------------------------
        */

        html.dark ::placeholder {

            color: #9ca3af;

        }


        /*
        |--------------------------------------------------------------------------
        | SCROLLBAR LIGHT
        |--------------------------------------------------------------------------
        */

        ::-webkit-scrollbar {

            width: 8px;

            height: 8px;

        }


        ::-webkit-scrollbar-track {

            background: #f3f4f6;

        }


        ::-webkit-scrollbar-thumb {

            background: #d1d5db;

            border-radius: 9999px;

        }


        ::-webkit-scrollbar-thumb:hover {

            background: #9ca3af;

        }


        /*
        |--------------------------------------------------------------------------
        | SCROLLBAR DARK
        |--------------------------------------------------------------------------
        */

        html.dark ::-webkit-scrollbar-track {

            background: #111827;

        }


        html.dark ::-webkit-scrollbar-thumb {

            background: #4b5563;

        }


        html.dark ::-webkit-scrollbar-thumb:hover {

            background: #6b7280;

        }


        /*
        |--------------------------------------------------------------------------
        | SELECTION
        |--------------------------------------------------------------------------
        */

        ::selection {

            background: rgba(
                59,
                130,
                246,
                0.25
            );

        }


        /*
        |--------------------------------------------------------------------------
        | TRANSITION
        |--------------------------------------------------------------------------
        */

        body,
        main,
        aside,
        header,
        nav,
        section,
        article,
        div {

            transition:
                background-color 0.2s ease,
                border-color 0.2s ease,
                color 0.2s ease;

        }

    </style>

</head>


<body
    x-data="{ loaded: true }"

    x-init="

        const checkScreen = () => {

            if (
                window.innerWidth < 1280
            ) {

                $store.sidebar.isExpanded =
                    false;

                $store.sidebar.isHovered =
                    false;

            } else {

                $store.sidebar.isMobileOpen =
                    false;

                $store.sidebar.isExpanded =
                    true;

            }

        };


        checkScreen();


        window.addEventListener(
            'resize',
            checkScreen
        );

    "

    class="
        min-h-screen
        bg-gray-50
        text-gray-800
        dark:bg-gray-900
        dark:text-white
    "
>


    {{-- =====================================================
        MAIN APPLICATION
    ====================================================== --}}

    <div class="min-h-screen xl:flex">


        {{-- =================================================
            SIDEBAR BACKDROP
        ================================================== --}}

        @include('layouts.backdrop')


        {{-- =================================================
            SIDEBAR
        ================================================== --}}

        @include('layouts.sidebar')


        {{-- =================================================
            MAIN CONTENT
        ================================================== --}}

        <div
            class="
                flex-1
                transition-all
                duration-300
                ease-in-out
            "

            :class="{

                'xl:ml-[290px]':
                    $store.sidebar.isExpanded,

                'xl:ml-[90px]':
                    !$store.sidebar.isExpanded,

                'ml-0':
                    $store.sidebar.isMobileOpen

            }"
        >


            {{-- =============================================
                HEADER
            ============================================== --}}

            @include('layouts.app-header')


            {{-- =============================================
                PAGE CONTENT
            ============================================== --}}

            <main
                class="
                    min-h-screen
                    p-4
                    mx-auto
                    max-w-(--breakpoint-2xl)
                    md:p-6
                "
            >

                @yield('content')

            </main>


        </div>

    </div>


    {{-- =====================================================
        STACKED SCRIPTS
    ====================================================== --}}

    @stack('scripts')


</body>

</html>