<header

    class="sticky top-0 z-40

           border-b border-gray-200

           bg-white

           dark\:border-gray-800

           dark\:bg-gray-900"

\>

    <div

        class="flex h-[72px]

               items-center

               justify-between

               px-4

               lg\:px-6"

    >

        {{-- =====================================================

            LEFT SIDE

        ====================================================== --}}

        <div class="flex items-center gap-4">

            {{-- =================================================

                MOBILE MENU

            ================================================== --}}

            <button

                type="button"

                @click*="$store.sidebar.toggleMobileOpen()"*

                class="

                    flex

                    h-11

                    w-11

                    items-center

                    justify-center

                    rounded-xl

                    border

                    border-gray-200

                    bg-white

                    text-gray-600

                    transition

                    hover\:bg-gray-50

                    lg\:hidden

                    dark\:border-gray-700

                    dark\:bg-gray-800

                    dark\:text-gray-300

                    dark\:hover\:bg-gray-700

                "

                aria-label="Buka menu"

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

                        d="M4 6h16M4 12h16M4 18h16"

                    />

                </svg>

            </button>



            {{-- =================================================

                DESKTOP SIDEBAR TOGGLE

            ================================================== --}}

            <button

                type="button"

                {{-- =================================================

                    PENTING:

                    JANGAN gunakan toggleExpanded()

                    Sidebar tetap terbuka.

                ================================================== --}}

                @click*="$store.sidebar.isExpanded* *=* true*"*

                class="

                    hidden

                    h-11

                    w-11

                    items-center

                    justify-center

                    rounded-xl

                    border

                    border-gray-200

                    bg-white

                    text-gray-600

                    transition

                    hover\:bg-gray-50

                    xl\:flex

                    dark\:border-gray-700

                    dark\:bg-gray-800

                    dark\:text-gray-300

                    dark\:hover\:bg-gray-700

                "

                aria-label="Buka Sidebar"

                title="Buka Sidebar"

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

                        d="M4 6h16M4 12h16M4 18h16"

                    />

                </svg>

            </button>



            {{-- =================================================

                SEARCH

            ================================================== --}}

            <div

                class="

                    hidden

                    w-[280px]

                    lg\:block

                    xl\:w-[360px]

                "

            >

                <div class="relative">

                    <span

                        class="

                            pointer-events-none

                            absolute

                            inset-y-0

                            left-0

                            flex

                            items-center

                            pl-4

                        "

                    >

                        <svg

                            class="

                                h-5

                                w-5

                                text-gray-400

                            "

                            fill="none"

                            viewBox="0 0 24 24"

                            stroke="currentColor"

                            stroke-width="1.8"

                        >

                            <circle

                                cx="11"

                                cy="11"

                                r="7"

                            />

                            <path

                                stroke-linecap="round"

                                d="M20 20l-4-4"

                            />

                        </svg>

                    </span>



                    <input

                        type="text"

                        placeholder="Cari..."

                        class="

                            h-11

                            w-full

                            rounded-xl

                            border

                            border-gray-200

                            bg-gray-50

                            pl-11

                            pr-4

                            text-sm

                            text-gray-800

                            outline-none

                            transition

                            placeholder\:text-gray-400

                            focus\:border-blue-500

                            focus\:bg-white

                            focus\:ring-2

                            focus\:ring-blue-500/10

                            dark\:border-gray-700

                            dark\:bg-gray-800

                            dark\:text-white

                            dark\:placeholder\:text-gray-500

                            dark\:focus\:bg-gray-800

                        "

                    />

                </div>

            </div>

        </div>



        {{-- =====================================================

            RIGHT SIDE

        ====================================================== --}}

        <div

            class="

                flex

                items-center

                gap-2

                sm\:gap-3

            "

        >

            {{-- =================================================

                THEME TOGGLE

            ================================================== --}}

            <button

                type="button"

                @click*="$store.theme.toggle()"*

                class="

                    flex

                    h-11

                    w-11

                    items-center

                    justify-center

                    rounded-xl

                    border

                    border-gray-200

                    bg-white

                    text-gray-600

                    transition

                    hover\:bg-gray-50

                    dark\:border-gray-700

                    dark\:bg-gray-800

                    dark\:text-gray-300

                    dark\:hover\:bg-gray-700

                "

                title="Ubah tema"

            >

                {{-- SUN --}}

                <svg

                    x-show="$store.theme.theme === 'light'"

                    class="h-5 w-5"

                    fill="none"

                    viewBox="0 0 24 24"

                    stroke="currentColor"

                    stroke-width="1.8"

                >

                    <circle

                        cx="12"

                        cy="12"

                        r="4"

                    />

                    <path

                        stroke-linecap="round"

                        d="

                            M12 2v2

                            M12 20v2

                            M4.93 4.93l1.41 1.41

                            M17.66 17.66l1.41 1.41

                            M2 12h2

                            M20 12h2

                            M4.93 19.07l1.41-1.41

                            M17.66 6.34l1.41-1.41

                        "

                    />

                </svg>



                {{-- MOON --}}

                <svg

                    x-show="$store.theme.theme === 'dark'"

                    class="h-5 w-5"

                    fill="none"

                    viewBox="0 0 24 24"

                    stroke="currentColor"

                    stroke-width="1.8"

                >

                    <path

                        stroke-linecap="round"

                        stroke-linejoin="round"

                        d="

                            M21 12.8

                            A8.5 8.5 0 1 1 11.2 3

                            6.5 6.5 0 0 0 21 12.8Z

                        "

                    />

                </svg>

            </button>



            {{-- =================================================

                NOTIFICATION

            ================================================== --}}





            {{-- =================================================

                USER

            ================================================== --}}

            <div
                x-data="{ userMenuOpen: false }"
                @click.outside="userMenuOpen = false"
                class="relative ml-1 flex items-center gap-3"
            >

                {{-- AVATAR --}}

                <div

                    class="

                        flex

                        h-11

                        w-11

                        items-center

                        justify-center

                        rounded-full

                        bg-blue-600

                        text-sm

                        font-bold

                        text-white

                        shadow-sm

                    "

                >

                    W

                </div>



                {{-- USER INFO --}}

                <div class="hidden sm\:block">

                    <p

                        class="

                            text-sm

                            font-semibold

                            text-gray-800

                            dark\:text-white

                        "

                    >

                        WASKARA

                    </p>

                    <p

                        class="

                            text-xs

                            text-gray-500

                            dark\:text-gray-400

                        "

                    >

                        YOLOv11

                    </p>

                </div>



                {{-- ARROW --}}
                <button
                    type="button"
                    @click="userMenuOpen = !userMenuOpen"
                    class="hidden h-4 w-4 items-center justify-center
                           text-gray-400 sm:flex"
                    aria-label="Buka menu pengguna"
                    :aria-expanded="userMenuOpen.toString()"
                >
                    <svg
                        class="h-4 w-4 transition-transform duration-200"
                        :class="{ 'rotate-180': userMenuOpen }"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M6 9l6 6 6-6"
                        />
                    </svg>
                </button>

                {{-- USER DROPDOWN --}}
<div
    x-show="userMenuOpen"
    x-transition:enter="transition ease-out duration-150"
    x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
    x-transition:leave="transition ease-in duration-100"
    x-transition:leave-start="opacity-100 scale-100 translate-y-0"
    x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
    class="absolute z-[100] w-56
           overflow-hidden rounded-xl border
           border-gray-200 bg-white shadow-lg
           dark:border-gray-700 dark:bg-gray-800"
    style="
        display: none;
        top: calc(100% + 12px);
        right: 0;
    "
>
                    <div class="border-b border-gray-100 px-4 py-3 dark:border-gray-700">
                        <p class="text-sm font-semibold text-gray-800 dark:text-white">
                            WASKARA
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            YOLOv11
                        </p>
                    </div>

                    <div class="p-2">
                        <a href="{{ url('/dashboard') }}"
                           @click="userMenuOpen = false"
                           class="block rounded-lg px-3 py-2.5 text-sm
                                  text-gray-700 transition hover:bg-gray-100
                                  dark:text-gray-200 dark:hover:bg-gray-700">
                            Dashboard
                        </a>

                        <a href="{{ url('/detection') }}"
                           @click="userMenuOpen = false"
                           class="block rounded-lg px-3 py-2.5 text-sm
                                  text-gray-700 transition hover:bg-gray-100
                                  dark:text-gray-200 dark:hover:bg-gray-700">
                            Deteksi
                        </a>

                        <a href="{{ url('/violations') }}"
                           @click="userMenuOpen = false"
                           class="block rounded-lg px-3 py-2.5 text-sm
                                  text-gray-700 transition hover:bg-gray-100
                                  dark:text-gray-200 dark:hover:bg-gray-700">
                            Riwayat Pelanggaran
                        </a>

                        <a href="{{ url('/evaluation') }}"
                           @click="userMenuOpen = false"
                           class="block rounded-lg px-3 py-2.5 text-sm
                                  text-gray-700 transition hover:bg-gray-100
                                  dark:text-gray-200 dark:hover:bg-gray-700">
                            Evaluasi
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>