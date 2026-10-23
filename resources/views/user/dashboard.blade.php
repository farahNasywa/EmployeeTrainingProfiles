@extends('layout.master2')
@section('content1')
<script src="https://cdn.jsdelivr.net/npm/vue@3/dist/vue.global.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.js" defer></script>
<script>
    window.relevanceData = @json($relevanceData);
    window.divisionTrainingData = @json($divisionTrainingData);
</script>
@vite(['resources/js/app.js'])
<script src="{{ asset('js/app.js') }}"></script>

<!--
    ============================================================
    RESPONSIVE ADDITIONS
    ------------------------------------------------------------
    All rules below ONLY apply inside @media (max-width),
    so the desktop view (>=1024px) stays 100% the same as before.
    No HTML classes are removed/replaced, no Blade/JS structure
    is changed — only <style> additions and a small tweak to the
    auto-scale script condition.
    ============================================================
-->
<style>
/* ---------- TABLET (<=1024px) ---------- */
@media (max-width: 1024px) {

    /* Disable the scale-transform effect so cards truly STACK,
       instead of just shrinking (if still scaled, text would get
       too small and the page would still feel like "zoomed-out
       desktop"). */
    #dashboardScaleOuter {
        overflow: visible !important;
        height: auto !important;
        width: 100% !important;
    }
    #dashboardScaleInner {
        width: 100% !important;
        transform: none !important;
    }

    /* Main 3-column grid -> 1 column (stack vertically) */
    #dashboardScaleInner .grid.grid-cols-3 {
        display: flex !important;
        flex-direction: column !important;
        gap: 1rem !important;
    }

    /* All cards follow container width, height adjusts to content */
    #dashboardScaleInner .grid.grid-cols-3 > div {
        width: 100% !important;
        max-width: 100% !important;
        height: auto !important;
        min-height: 260px;
    }

    /* Container 1 (Employee Information):
       badge & status pill originally used margin-left in rem
       (calculated relative to the original 600px width) so it
       would sit on the right side of the card. If this margin is
       reset to 0, the element sticks to the LEFT (wrong, doesn't
       match the original design).
       Solution: use margin-left: auto so it still sticks to the
       RIGHT even though the card is now full-width, with a
       bounded width (not 100%) to stay proportional like desktop. */
    #dashboardScaleInner .rounded-full.w-25 {
        margin-left: auto !important;
        margin-right: 2.5rem;
        justify-content: flex-end;
    }
    #dashboardScaleInner .container-1 {
        margin-left: auto !important;
        margin-right: 0.5rem;
        width: 72%;
        max-width: 320px;
        padding: 0;
    }

    /* Chart / speedometer container: follows card width, height
       stays enough so Chart.js/Vue doesn't collapse to 0px */
    #vue-dashboard-speedometer,
    #vue-dashboard-barchart,
    #vue-dashboard-linechart {
        width: 100% !important;
        min-height: 260px;
    }

    /* Category icons (Container 4): 5 columns -> 3 columns so
       they don't get cramped/cut off */
    #categoryIcons {
        grid-template-columns: repeat(3, 1fr) !important;
        height: auto !important;
        row-gap: 1rem;
    }

    #categoryDescription {
        width: 100% !important;
    }

    /* Map box (Container 5): fixed 300px width can overflow on
       narrow screens -> made relative to the container */
    #dashboardScaleInner .absolute.bottom-7.right-4 {
        width: 90% !important;
        max-width: 320px;
        right: 5% !important;
        bottom: 1rem !important;
    }
}

/* ---------- MOBILE (<=768px) ---------- */
@media (max-width: 768px) {
    #categoryIcons {
        grid-template-columns: repeat(2, 1fr) !important;
    }

    #dashboardScaleInner h2 {
        font-size: 1rem !important;
    }
}

/* ---------- SMALL MOBILE (<=576px) ---------- */
@media (max-width: 576px) {
    body {
        overflow-x: hidden;
    }

    #dashboardScaleInner .grid.grid-cols-3 > div {
        min-height: 220px;
        padding: 0.75rem !important;
    }

    /* Card 1: on very narrow screens, the card shrinks further,
       so the 72% width (tablet rule) is made a bit larger (80%)
       so the text inside the pill isn't too cramped. */
    #dashboardScaleInner .container-1 {
        width: 80%;
        max-width: 260px;
        margin-right: 0.25rem;
    }

    #categoryIcons {
        grid-template-columns: repeat(2, 1fr) !important;
        gap: 0.5rem !important;
    }

    #dashboardScaleInner .absolute.bottom-7.right-4 {
        position: relative !important;
        width: 100% !important;
        max-width: 100% !important;
        right: 0 !important;
        bottom: 0 !important;
        margin-top: 0.5rem;
    }

    table {
        width: 100%;
    }
    .table-responsive-wrap {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
}
</style>

<!--
    ============================================================
    AUTO-SCALE WRAPPER
    ------------------------------------------------------------
    Content inside #dashboardScaleInner is rendered at the
    original design width (1712px = 600+600+500px + gap), EXACTLY
    like your original code, NOT A SINGLE NUMBER changed below.
    Since the available width is always enough (1712px), the
    3-column grid will never be "squeezed"/overlapping.
    Then this whole block is visually scaled (just like a browser
    zoom) automatically via JS to fit any screen size, so you
    don't need to zoom manually anymore.
    On screens <=1024px, scaling is disabled and the CSS media
    query above takes over (stack vertically).
    ============================================================
-->
<div id="dashboardScaleOuter" style="width: 100%; overflow: hidden;">
<div id="dashboardScaleInner" style="width: 1712px;">

    <div class="grid grid-cols-3 gap-1.5">
        <!-- 📌 Container 1 with Image -->
        <div class="rounded-xl p-0 shadow-lg w-[600px] h-[300px] relative overflow-visible" style="height: 338px;">
            <!-- Background Image -->
            <img
                src="/img/bg-cn1.png"
                alt="Uploaded Image"
                class="absolute inset-0 w-full h-full object-cover rounded-xl"
            />
        
            <!-- Overlay Content -->
            <div class="relative z-10 w-full h-full p-3 flex flex-col justify-between">
                <h2 class="text-white font-bold text-xl text-right">EMPLOYEE INFORMATION</h2>
        
                <div class="rounded-full w-25 h-25 flex items-center mt-3" style="margin-left: 20rem;">
                    <img src="/img/circle-icon.png" alt="Circle Icon" />
                    <span class="absolute text-black font-extrabold ml-7 text-sm text-center drop-shadow-sm" style="margin-top: 70px; font-family: 'Poppins', sans-serif;">
    {{ $totalEmployees }} Employee
</span>
                </div>
        
                <div class="container-1 flex flex-col gap-0.5 mt-4" style="margin-left: 17rem;">
                    <!-- Head of Agency -->
                    <div x-show="!open" class="flex items-center font-bold text-base text-black rounded-xl p-0.5 pl-1 bg-white mt-1">
                        <span class="w-5 h-5 rounded-full" style="background: #F4A300"></span>
                        <span class="ml-2 cursor-pointer flex items-center gap-0.5">
                            Head of Agency
                        </span>
                    </div>
                
                    <!-- Deputy Head of Agency -->
                    <div x-show="!open" class="flex items-center font-bold text-base text-black rounded-xl p-0.5 pl-1 bg-white mt-1">
                        <span class="w-5 h-5 rounded-full" style="background: #7C60FF"></span>
                        <span class="ml-2 cursor-pointer flex items-center gap-0.5">
                            Deputy Head of Agency
                        </span>
                    </div>

                    {{-- <!-- Deputi Dropdown -->
                    <div x-data="{ open: false }" class="relative">
                        <!-- Button to toggle the dropdown -->
                        <button @click="open = !open" class="flex items-center font-bold text-base text-black rounded-xl p-0.5 pl-1 bg-white mt-1 w-full">
                            <span class="w-5 h-5 rounded-full" style="background: #00b8f1"></span>
                            <span class="ml-2 cursor-pointer flex items-center gap-0.5">
                                 Kedeputian ({{ $totalDeputy }})
                            </span>
                        </button>
                    
                        <!-- Dropdown Menu for Deputies -->
                        <div x-show="open" @click.away="open = false" class="absolute left-0 mt-2 bg-white shadow-lg rounded-lg w-full z-50">
                            <ul class="p-0.5">
                                @foreach($deputies as $deputy)
                                    <li class="py-2 px-2 text-black cursor-pointer hover:bg-gray-200">{{ ucwords(strtolower($deputy->nama_deputi)) }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div> --}}

                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center font-bold text-base text-black rounded-xl p-0.5 pl-1 bg-white mt-1 w-full">
                            <span class="w-5 h-5 rounded-full" style="background: #00b8f1"></span>
                            <span class="ml-2 cursor-pointer flex items-center gap-0.5">
                                Deputies ({{ $totalDeputy }})
                            </span>
                        </button>

                        <div x-show="open" @click.away="open = false" class="absolute left-0 mt-2 bg-white shadow-lg rounded-lg w-full z-50">
                            <ul class="p-0.5">
                                @foreach($deputies as $deputy)
                                    <li>
                                        <a href="{{ route('deputi.show', ['id_deputi' => $deputy->id_deputi, 'ref' => 'beranda']) }}" class="block py-2 px-2 text-black cursor-pointer hover:bg-gray-200 no-underline">
                                            {{ ucwords(strtolower($deputy->nama_deputi)) }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
        
                    <!-- Division Dropdown -->
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center font-bold text-base text-black rounded-xl p-0.5 pl-1 bg-white mt-1 w-full">
                            <span class="w-5 h-5 rounded-full" style="background: #05FBF3"></span>
                            <span class="ml-2 cursor-pointer flex items-center gap-0.5">
                                Divisions ({{ $totalDivision }})
                            </span>
                        </button>

                        <div x-show="open" @click.away="open = false" class="absolute top-full mt-1 left-0 bg-white shadow-lg rounded-lg w-full z-50 max-h-60 overflow-y-auto">
                            <ul class="p-0.5">
                                @foreach($divisions as $division)
                                    <li>
                                        <a href="{{ route('division.show', ['id_divisi' => $division->id_divisi, 'ref' => 'beranda']) }}" class="block py-2 px-2 text-black cursor-pointer hover:bg-gray-200 no-underline">
                                            {{ ucwords(strtolower($division->nama_divisi)) }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
           <!-- 📌 Container 2 Speedometer -->
        <div class="rounded-xl p-6 shadow-lg w-[600px] h-[300px]" style="background: linear-gradient(to bottom, #1C869D, #6AD2E1); height: 338px;">
            <h2 class="text-white text-xl -mt-2 font-bold mb-4 font-poppins text-center">
                EMPLOYEE TRAINING RELEVANCE ASSESSMENT
            </h2>
            <div id="vue-dashboard-speedometer" class="mt-4"></div> <!-- This will be for Speedometer -->
        </div> 

        <!-- 📌 Container 3 Chart -->
        <div class="rounded-xl p-6 shadow-lg w-[500px] h-[300px]" style="background: linear-gradient(to bottom, #CBE9F5, #77C8D6); height: 338px;">
            <h2 class="text-xl font-bold mb-10 ml-4 -mt-2 text-center font-poppins">
                TOTAL TRAINING FOR EACH DIVISION
            </h2>
            <div id="vue-dashboard-barchart" data-division-training='@json($divisionTrainingData)'></div> <!-- Passing data directly to the component -->
        </div>

        <!-- 📌 Container 4 - Improved -->
        <div class="bg-cover bg-center rounded-xl p-4 shadow-lg relative" style="height: 370px; background: linear-gradient(rgba(0,0,0,0.2), rgba(0,0,0,0.1)), url('/img/background%20card.png') center center / cover no-repeat;">
            <h2 class="text-white text-xl font-bold mb-3 text-center font-poppins drop-shadow-md">TRAINING AND DEVELOPMENT CATEGORIES</h2>

            <!-- Category Description Box - Now positioned directly below the title -->
            <div id="categoryDescription" class="rounded-2xl shadow-lg flex flex-col items-center p-4 relative hidden transition-all duration-300 ease-in-out" 
                style="background: linear-gradient(135deg, #6AD2E1, #4ea8b9); max-height: 290px; overflow-y: auto; width: 95%; margin: 0 auto;">
                <button id="closeCategoryButton" class="absolute top-2 right-2 bg-white/40 hover:bg-white/60 transition p-1.5 rounded-full backdrop-blur-sm" title="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>

                <div class="flex items-center justify-center w-full">
                    <img src="/img/reward-icon1.png" alt="Reward Icon" class="w-16 h-16 mr-3" />
                    
                    <div class="flex-1">
                        <h3 class="text-gray-900 font-bold text-xl mb-1 font-poppins" id="categoryTitle">
                            <!-- Category title will be injected here -->
                        </h3>
                        
                        <div id="totalEmployees" class="text-lg font-semibold text-blue-900 mb-2">
                            <!-- Total Employees will be injected here -->
                        </div>
                    </div>
                </div>

                <div class="w-full mt-3 px-2">
                    <h4 class="text-gray-800 font-semibold mb-1">Subcategories :</h4>
                    <ul id="subcategoryList" class="text-sm text-blue-900 font-semibold font-poppins pl-4 list-disc">
                        <!-- Subcategories will be injected here -->
                    </ul>
                </div>
            </div>

            <!-- Category Icons Grid -->
            <div id="categoryIcons" class="grid grid-cols-5 gap-2 -mt-8" style="width: 100%; justify-items: center; height: 270px;">
    @foreach($categories as $category)
        @php
            $words = explode(' ', $category->nama_kategori);
            $initials = '';
            $wordCount = count($words);
            foreach ($words as $index => $word) {
                $initials .= strtoupper(substr($word, 0, 1));
                if ($index < $wordCount - 1 && ctype_alpha(substr($word, -1)) && isset($words[$index + 1]) && ctype_alpha(substr($words[$index + 1], 0, 1))) {
                    $initials .= '';
                }
                if (strlen($initials) >= 5) break; // Limit initials so they aren't too long
            }
        @endphp
        <div class="flex flex-col items-center justify-center category-icon cursor-pointer p-2 rounded-lg transition-all hover:scale-110 hover:brightness-110 relative group"
            data-id="{{ $category->id_kategori }}" style="z-index: 1;"> <div class="bg-white/30 rounded-full p-3 backdrop-blur-sm shadow-md">
                <img src="{{ $category->icon }}" alt="Icon" class="w-12 h-12" />
            </div>
            <div class="text-center text-xs font-semibold bg-white w-12 rounded-xl -mt-3" style="z-index: 2;">{{ $initials }}</div> 
            <div class="absolute -bottom-10 left-1/2 transform -translate-x-1/2 opacity-0 group-hover:opacity-100 bg-white text-sm font-semibold rounded-lg p-2 shadow-lg transition-opacity text-blue-900 whitespace-nowrap" style="z-index: 3;"> {{ ucwords(strtolower($category->nama_kategori)) }}
            </div>
        </div>
    @endforeach
</div>
        </div>

        <!-- 📌 Container 5 Map -->
        <div class="relative rounded-xl overflow-hidden shadow-lg" style="height: 370px;">
            <a href="https://www.bpma.go.id/wp-content/wk/index.html#7/3.694/96.449" target="_blank" rel="noopener noreferrer">
                <img
                    src="/img/petabpma1.png"
                    alt="BPMA Area Map"
                    class="w-full h-full object-cover rounded-lg hover:opacity-80 transition-opacity"
                />
            </a>
    
            <div class="absolute bottom-7 right-4 bg-opacity-30 text-white rounded-xl p-4 w-[300px] font-poppins shadow-md" style="background: #2BB3AD; opacity: 0.9;">
                <h3 class="text-lg font-bold mb-1 text-center leading-tight">ACEH OIL AND GAS<br/>WORKING AREA</h3>
                <div>
                    <ul class="text-white font-bold pl-1 space-y-1 list-disc mt-2" style="font-size: 15px">
                        <li>WK Bireun Sigli</li>
                        <li>WK Block "A"</li>
                        <li>WK Block "B"</li>
                        <li>WK Lhokseumawe</li>
                        <li>WK ONWA</li>
                        <li>WK OSWA</li>
                        <li>WK Pase</li>
                        <li>WK Nusantara - PEP Asset I</li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- <!-- 📌 Container 6 Chart -->
        <div class="rounded-xl p-6 shadow-lg w-full max-w-[500px] h-[400px] flex flex-col items-center justify-between" style="height: 370px; background: linear-gradient(to bottom, #D7FFFE, #76DEDB);">
            <h2 class="text-xl font-bold mb-4 text-black font-poppins">INDUSTRY PERFORMANCE</h2>
    
        </div> --}}

        <!-- 📌 Container 6 Chart -->
        <div class="rounded-xl p-6 shadow-lg w-full max-w-[500px] h-[400px] flex flex-col items-center justify-between" style="height: 370px; background: linear-gradient(to bottom, #D7FFFE, #76DEDB);">
            <h2 class="text-xl font-bold mb-2 text-black font-poppins">TRAINING RELEVANCE BY DIVISION</h2>
            <div id="vue-dashboard-linechart" data-division-relevance='@json($divisionRelevanceData)' style="width: 100%; height: 310px;"></div>
        </div>


</div>

</div>
<!-- #dashboardScaleInner -->
</div>
<!-- #dashboardScaleOuter -->

<script>
    // ============================================================
    // Auto-scale dashboard: automatically replicate a "90% zoom"
    // effect on any screen size, without changing a single number
    // above.
    // Responsive change: on screens <=1024px, scaling is disabled
    // and the CSS media query takes over (stack vertically). The
    // original desktop scaling logic is NOT changed at all.
    // ============================================================
    (function () {
        var DESIGN_WIDTH = 1712; // original design width: 600 + 600 + 500 + gap

        function fitDashboardScale() {
            var outer = document.getElementById('dashboardScaleOuter');
            var inner = document.getElementById('dashboardScaleInner');
            if (!outer || !inner) return;

            // Below/at 1024px, let the CSS media query handle it
            // (stack vertically), no scale transform needed at all.
            if (window.innerWidth <= 1024) {
                inner.style.transform = 'none';
                outer.style.height = 'auto';
                return;
            }

            var availableWidth = outer.clientWidth;
            var scale = availableWidth / DESIGN_WIDTH;

            inner.style.transform = 'scale(' + scale + ')';
            inner.style.transformOrigin = 'top left';

            // scrollHeight doesn't change even when scaled, so it's
            // safe to use it to match the outer height so there's
            // no empty space or cut-off content below.
            outer.style.height = (inner.scrollHeight * scale) + 'px';
        }

        window.addEventListener('resize', fitDashboardScale);
        window.addEventListener('DOMContentLoaded', fitDashboardScale);
        window.addEventListener('load', fitDashboardScale);
    })();
</script>

<script>
    // Improved script for category interaction
    document.addEventListener('DOMContentLoaded', function() {
        const categoryDescription = document.getElementById('categoryDescription');
        const categoryIcons = document.getElementById('categoryIcons');
        const categoryTitle = document.getElementById('categoryTitle');
        const subcategoryList = document.getElementById('subcategoryList');
        const totalEmployees = document.getElementById('totalEmployees');
        const closeCategoryButton = document.getElementById('closeCategoryButton');

        // Event listener for close button
        closeCategoryButton.addEventListener('click', function() {
            // Hide description and show icons with animation
            categoryDescription.classList.add('opacity-0');
            setTimeout(() => {
                categoryDescription.classList.add('hidden');
                categoryIcons.classList.remove('hidden');
                setTimeout(() => {
                    categoryIcons.classList.add('opacity-100');
                }, 50);
            }, 300);
        });

        // Event listeners for category icons
        document.querySelectorAll('.category-icon').forEach(icon => {
            icon.addEventListener('click', function() {
                const categoryId = this.dataset.id;

                // Reset the previous category view (clear old data)
                categoryTitle.textContent = 'Loading...';
                subcategoryList.innerHTML = '';
                totalEmployees.textContent = 'Loading...';

                // Hide icons and show loading animation
                categoryIcons.classList.add('opacity-0');
                setTimeout(() => {
                    categoryIcons.classList.add('hidden');
                    
                    // Show the category description area with animation
                    categoryDescription.classList.remove('hidden');
                    categoryDescription.classList.add('opacity-100');
                    
                    // Fetch category details
                    fetch(`/category/${categoryId}/details`)
                        .then(response => response.json())
                        .then(data => {
                            // Update the content with new data
                            categoryTitle.textContent = data.category.nama_kategori;
                            totalEmployees.textContent = `Total Training Employees : ${data.totalEmployees}`;
                            
                            // Function to capitalize the first letter of each word (ucwords)
                            function ucwords(str) {
                                return str.replace(/\b\w/g, function(char) {
                                    return char.toUpperCase();
                                });
                            }

                            // Function to lowercase a string (strtolower)
                            function strtolower(str) {
                                return str.toLowerCase();
                            }

                            // Build subcategory list
                            let subcategoryHTML = '';
                            if (data.subcategories && data.subcategories.length > 0) {
                                data.subcategories.forEach(sub => {
                                    subcategoryHTML += `<li>${ucwords(strtolower(sub.nama_subkategori))}</li>`;
                                });
                            } else {
                                subcategoryHTML = '<li>No subcategories available</li>';
                            }
                            subcategoryList.innerHTML = subcategoryHTML;
                        })
                        .catch(error => {
                            console.error('Error fetching category details:', error);
                            categoryTitle.textContent = 'Error Loading Data';
                            totalEmployees.textContent = '';
                            subcategoryList.innerHTML = '<li class="text-red-600">Failed to load subcategories</li>';
                        });
                }, 300);
            });
        });
    });
</script>
@endsection