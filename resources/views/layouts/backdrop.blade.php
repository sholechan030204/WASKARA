{{-- =========================================================
    WASKARA - Sidebar Backdrop
========================================================= --}}

<div
    x-show="$store.sidebar.isMobileOpen"
    @click="$store.sidebar.setMobileOpen(false)"
    x-transition.opacity
    class="fixed inset-0 z-[9998] bg-black/50 xl:hidden"
    aria-hidden="true"
></div>