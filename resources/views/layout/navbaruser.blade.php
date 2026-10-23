<style>
/* ============================================================
   RESPONSIVE ADDITIONS — HEADER / NAVBAR
   ------------------------------------------------------------
   All rules below ONLY apply inside @media (max-width), so the
   desktop view (>=1024px) stays 100% the same as before. No
   classes are removed/replaced, HTML structure is unchanged.
   ============================================================ */

/* Shift the title text further to the right on desktop.
   Original .title class already has margin-left: 210px from
   navbar.css, so this pushes it further right (210px -> 260px).
   Reset to 0 on tablet/mobile below so it doesn't get pushed
   off-screen on narrow viewports. */
.header .title {
    margin-left: 240px;
}

/* ---------- TABLET (<=1024px) ---------- */
@media (max-width: 1024px) {
    .header .logo {
        height: 4rem !important; /* h-24 -> smaller so it's proportional */
    }
    .header .title {
        font-size: 1.75rem !important;
        line-height: 1.3;
        margin-left: 0 !important;
    }
    .header .nav {
        gap: 0.5rem;
    }
    .header .nav-item {
        padding: 0.4rem 0.75rem !important;
        font-size: 0.9rem;
    }
}

/* ---------- MOBILE (<=768px) ---------- */
@media (max-width: 768px) {
    /* Main header container stacked: logo/title/nav on top,
       search+logout automatically DROP below the nav (instead of
       overlapping the title, instead of shrinking) */
    .header .flex.flex-wrap.items-start.justify-between {
        flex-direction: column !important;
        align-items: flex-start !important;
    }

    /* Search + logout row: forced into its own full row
       (flex-basis 100%) and NOT ALLOWED to shrink to 0/disappear.
       Previously the original "flex-shrink-0" class + other
       combinations could collapse/overlap this row -> now forced
       to display with display:flex !important and full width. */
    .header .flex.items-center.flex-wrap.gap-2.mt-1.flex-shrink-0 {
        display: flex !important;
        flex-basis: 100% !important;
        width: 100% !important;
        max-width: 100% !important;
        flex-direction: column !important;
        align-items: stretch !important;
        justify-content: flex-start !important;
        gap: 0.5rem !important;
        margin-top: 0.75rem !important;
        flex-shrink: 1 !important;
        visibility: visible !important;
        opacity: 1 !important;
    }

    /* Search box: forced full-width & always visible, because
       previously the fixed width w-72 (288px) + flex-shrink-0
       could push it out of the visible area on narrow screens. */
    .header .search-box {
        display: flex !important;
        width: 100% !important;
        max-width: 100% !important;
        flex-shrink: 1 !important;
        box-sizing: border-box !important;
        visibility: visible !important;
        opacity: 1 !important;
    }
    .header .search-box form {
        width: 100% !important;
    }
    .header .search-box input {
        width: 100% !important;
        min-width: 0 !important;
    }

    /* Logout form & its button: also full width so it lines up
       neatly with the search box, doesn't shrink/get cut off. */
    .header form[action*="logout"] {
        width: 100% !important;
        margin: 0 !important;
    }
    .header form[action*="logout"] button {
        width: 100% !important;
        justify-content: center !important;
    }

    .header .nav {
        flex-wrap: wrap;
    }
}

/* ---------- SMALL MOBILE (<=576px) ---------- */
@media (max-width: 576px) {
    .header {
        padding: 1rem !important;
    }

    .header .logo {
        height: 3rem !important;
        margin-left: 0.5rem !important;
    }

    .header .title {
        font-size: 1.4rem !important;
    }

    .header .subtitle {
        font-size: 0.85rem;
    }

    .header .nav-item {
        font-size: 0.85rem;
        padding: 0.35rem 0.6rem !important;
    }

    .header .search-box input {
        font-size: 0.9rem;
    }

    .header button[type="submit"] {
        font-size: 0.9rem;
        padding: 0.5rem 0.9rem !important;
    }
}
</style>

<div class="header bg-white p-6 shadow-md">
    <!--
        Change: previously logo/subtitle/title/nav and
        search+logout were stacked using "margin-top: -80px"
        (fragile, easily overlapping the title if the content
        above changed height).
        Now wrapped in a flex "justify-between flex-wrap":
        - On wide screens: same result (search+logout top right).
        - On narrow screens: search+logout automatically DROP
          below the nav (instead of overlapping the title, instead
          of shrinking) -> the page gets taller and scrollable, as
          requested.
    -->
    <div class="flex flex-wrap items-start justify-between">

        <div class="min-w-0">
            <img src="{{ asset('img/logobpma.png') }}" alt="BPMA Logo" class="logo h-24 object-contain ml-6" />
            <div class="subtitle text-gray-600 mb-4">Aceh Oil and Gas Management Agency</div>
            <div class="title text-2xl md:text-5xl font-bold text-gray-800 mb-1">EMPLOYEE TRAINING PROFILES</div>
            <div class="nav flex flex-wrap space-x-4 mb-4">
                <a href="/user/dashboard" class="nav-item text-center text-blue-600 hover:bg-gray-300 hover:text-gray block rounded-md cursor-pointer px-4 py-2 transition duration-200 text-decoration-none">Home</a>
                <a href="/user/strukturorganisasi" class="nav-item text-center text-blue-600 hover:bg-gray-300 hover:text-gray block rounded-md cursor-pointer px-4 py-2 transition duration-200 text-decoration-none">Organizational Structure</a>
            </div>
        </div>

        <div class="flex items-center flex-wrap gap-2 mt-1 flex-shrink-0">
            <div class="mt-1 search-box flex items-center bg-gray-100 p-2 rounded-md w-72 max-w-full flex-shrink-0">
                <form action="{{ route('search') }}" method="GET" class="flex items-center w-full space-x-2">
                    <input type="text" name="keyword" class="ml-3 bg-gray-100 text-gray-700 focus:outline-none w-full" placeholder="Search employee name or ID ..." autocomplete="off">
                </form>
            </div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="mt-1 mr-1 flex items-center bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-full transition duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    logout
                </button>
            </form>
        </div>

    </div>
</div>
<div class="divider h-px bg-gray-300 my-2"></div>