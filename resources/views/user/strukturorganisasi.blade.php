@extends('layout.master2')

@section('content1')

    <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
        <!-- Container 1 -->
        <div class="relative max-w-7xl mx-auto rounded-xl shadow-xl overflow-hidden" style="background: url('/img/bgdasar3.png') no-repeat center center; background-size: cover;">
            <!-- Title -->
            <div class="max-w-md mx-auto bg-green-700  text-white text-center rounded-b-full shadow-lg">
              <p class="text-xl font-bold" style="text-shadow: 0 2px 4px rgba(0,0,0,0.4);">ACEH OIL AND GAS MANAGEMENT AGENCY</p>
            </div>    
            <div class="p-2 space-y-4">     
            <!-- Cards: Head and Deputy -->
            <div class="flex flex-wrap justify-center items-center gap-6">
              <!-- Get Head of Agency from Division 16 -->
                @php
                $kepalaBadan = $divisions->firstWhere('id_divisi', 16);
                $wakilKepala = $divisions->firstWhere('id_divisi', 17);
                @endphp

                @if ($kepalaBadan)
                @foreach ($kepalaBadan->employees as $employee)
                <div class="flex flex-col items-center w-36 bg-white rounded-xl shadow-md p-3">
                    <div class="w-30 h-30 rounded-full bg-gray-200 border-2 border-gray-300 shadow-inner overflow-hidden">
                        <img src="{{ asset('img/foto/' . $employee->foto) }}" alt="{{ $employee->nama }}" class="w-full h-full object-cover rounded-full">
                    </div>
                    <a href="{{ route('employee', $employee->id_pegawai) }}" class="mt-1 text-center group">
                        <p class="text-sm font-semibold text-gray-800 group-hover:underline">{{ ucwords(strtolower($employee->nama)) }}</p>
                        <p class="text-xs text-gray-600 group-hover:text-blue-600">{{ $employee->bidang }}</p>
                    </a>
                </div>
                @endforeach
                @endif

                @if ($wakilKepala)
                @foreach ($wakilKepala->employees as $employee)
                <div class="flex flex-col items-center w-36 bg-white rounded-xl shadow-md p-3">
                    <div class="w-30 h-30 rounded-full bg-gray-200 border-2 border-gray-300 shadow-inner overflow-hidden">
                        <img src="{{ asset('img/foto/' . $employee->foto) }}" alt="{{ $employee->nama }}" class="w-full h-full object-cover rounded-full">
                    </div>
                    <a href="{{ route('employee', $employee->id_pegawai) }}" class="mt-1 text-center group">
                        <p class="text-sm font-semibold text-gray-800 group-hover:underline">{{ ucwords(strtolower($employee->nama)) }}</p>
                        <p class="text-xs text-gray-600 group-hover:text-blue-600">{{ $employee->bidang }}</p>
                    </a>
                </div>
                @endforeach
                @endif
            </div>
            <!-- Description -->
          <div class="bg-white bg-opacity-90 p-1 rounded-lg shadow-md text-sm leading-relaxed text-gray-800" >
              <h2 class="text-center font-bold text-base mb-1">
                <span class="inline-block px-1 py-2 text-white" style="background-color: #016181; border-radius: 10px;">
                  EMPLOYEE TRAINING PROFILES
                </span>
              </h2>
              <div style="border-block-color: black">
              <p class="text-center mt-1">
                Welcome to Employee Training Profiles, a platform designed to enhance our understanding of employee development at <strong>BPMA</strong>. It gives insight into training relevance and organizational impact.
                </br></br>
                It also offers recommendations tailored to both organizational needs and personal growth. We encourage you to actively engage with this tool to support continuous improvement.
              </p>
              <p class="text-center mt-3 font-semibold">Best,<br><span class="font-black">Nasri Jalal</span><br>Head of the BPMA</p>
            </div>
          </div>
          </div>
        </div>

        <!-- Container 2 -->
        <div class="relative max-w-7xl mx-auto rounded-xl shadow-xl overflow-hidden"  
          style="background: url('/img/bgdasar3.png') no-repeat center center; background-size: cover;">
  
          <!-- Main Header Row - Title and Hexagons Side by Side -->
          <div class="flex flex-row items-start px-2">
  
          <!-- Employee Profile Header (Left Side) -->
          <div class="flex flex-col items-center w-40 h-30 rounded-b-xl shadow-md p-2 mb-4" style="background-color: #FFEB3B;">
            @if ($kepaladeputi1)
            <div class="w-28 h-28 rounded-full bg-gray-200 border-2 border-gray-300 shadow-inner overflow-hidden">
                <img src="{{ asset('img/foto/' . $kepaladeputi1->foto) }}"
                    alt="{{ $kepaladeputi1->nama }}"
                    class="w-full h-full object-cover rounded-full">
            </div>
            <a href="{{ route('employee', $kepaladeputi1->id_pegawai) }}" class="mt-1 text-center group">
                <p class="text-sm font-semibold text-gray-800 group-hover:underline">
                    {{ ucwords(strtolower($kepaladeputi1->nama)) }}
                </p>
                <p class="text-xs text-gray-600 group-hover:text-blue-600">
                    {{ $kepaladeputi1->bidang }}
                </p>
            </a>
            @endif
        </div>
  
          <!-- Deputy and Division -->
          <div class="flex flex-row ml-1 items-start py-2">
          @foreach ($deputies as $deputi)
            @if ($deputi->id_deputi == 1)
              <div class="ml-1 py-4">
                <a href="{{ route('deputi.show', $deputi->id_deputi) }}"
                  class="absolute -mt-6 text-center no-underline text-white font-bold text-lg cursor-pointer z-10 hover:underline"
                  style="text-shadow: 2px 2px 30px rgba(0,0,0,0.7);">
                   {{ $deputi->nama_deputi }}
               </a>
  
                <div class="flex flex-row gap-1">
                  @foreach ($deputi->divisions as $division)
                    <div class="hexagon-container min-w-[180px]">
                      <div class="hexagon">
                        <div class="top-part">
                          <div class="circle-top">
                            <img src="{{ asset('img/icon-divisi/' . ($division->icon ?? 'default-icon.png')) }}"
                                  alt="{{ $division->nama_divisi }}"
                                  class="w-full h-full object-cover rounded-full">
                          </div>
                        </div>
                        <div class="bottom-part">
                          <a href="{{ route('division.show', $division->id_divisi) }}"
                              class="text-white text-center mb-4 block hover:underline cursor-pointer">
                            {{ $division->nama_divisi }}
                          </a>
                        </div>
                      </div>
                      <div class="circle-bottom text-white text-sm text-center">
                        {{ $division->employees->count()}}
                      </div>
                    </div>
                  @endforeach
                </div>
              </div>
            @endif
          @endforeach
          </div>
          </div>
  
          <!-- Training Relevance -->
          <div class="flex justify-center">
          <div class="flex-col items-center w-40 rounded-t-xl shadow-md bg-opacity-90 p-1 leading-relaxed text-gray-800 mt-1 mx-2 mb-2"
              style="background-color: #0089B7;">
          <h2 class="text-white font-bold text-center text-sm mb-0.5">Training Relevance</h2>
  
          <!-- Image + Percentage -->
          @php
          $targetDeputy = $deputiestraining->firstWhere('id_deputi', 1);
          @endphp
          
          @if ($targetDeputy)
              <div class="relative w-28 h-28 mx-auto">
                  <img src="/img/gambar1.png" alt="Image Description" class="w-full h-full object-cover rounded-md">
                  <div class="absolute inset-0 flex items-center justify-center">
                      <span class="font-bold text-sm mb-2">{{ $targetDeputy['persentase_training'] }}%</span>
                  </div>
              </div>
          @endif

        <!-- Relevance Category -->
        @php
          $id_deputi = 1;
          $modalData = [];
        @endphp

        @foreach (['Low', 'Medium', 'High'] as $level)
            @php
                $items = $formattedRelevansi[$id_deputi][$level] ?? collect();
                $limitedItems = $items->take(1);
                $hasMore = $items->count() > 1;

                if ($hasMore) {
                    $modalData[$level] = $items;
                }
            @endphp

            <div class="box flex items-center gap-1 mb-2">
                <div class="flex gap-1 items-end">
                    <div class="rectangle" style="background-color: {{ $level == 'Low' ? '#ffff' : ($level == 'Medium' ? '#ffff' : '#ffff') }};"></div>
                    <div class="rectangle-2" style="background-color: {{ $level == 'Low' ? '#ffff' : ($level == 'Medium' ? '#ffff' : '#ffff') }};"></div>
                    <div class="rectangle-3" style="background-color: {{ $level == 'Low' ? '#ffff' : ($level == 'Medium' ? '#ffff' : '#ffff') }};"></div>
                </div>
                <div class="text text-white text-xs">
                    <div class="font-semibold -ml-3 leading-tight">{{ $level }} Relevance:</div>
                    <ul class="list-none -ml-8 text-[10px] text-white leading-snug mt-0.5">
                        @forelse($limitedItems as $item)
                          <li>- {{ $item['nama_kategori'] }}</li>
                        @empty
                            <li>No relevant category found.</li>
                        @endforelse
                        @if($hasMore)
                            <li>
                                <button onclick="document.getElementById('modal-{{ $level }}').showModal()" class="underline text-blue-300 ml-1">
                                    View Details
                                </button>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
          @endforeach
            {{-- Render modal after foreach --}}
            @foreach ($modalData as $level => $items)
            <dialog id="modal-{{ $level }}" class="rounded-lg shadow-xl p-6 w-[400px] bg-white text-black z-50 max-w-full">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">{{ $level }} Relevance </h3>
                    <button onclick="document.getElementById('modal-{{ $level }}').close()" class="text-gray-500 hover:text-gray-700 font-bold">&times;</button>
                </div>
                <ul class="list-disc list-inside text-sm space-y-2">
                    @foreach($items as $item)
                        <li class="text-gray-700">{{ $item['nama_kategori'] }}</li>
                    @endforeach
                </ul>
            </dialog>
            @endforeach

            {{-- Styles for smooth modal transition --}}
            <style>
            dialog {
                transition: opacity 0.3s ease, transform 0.3s ease;
            }
            dialog[open] {
                opacity: 1;
                transform: translateY(0);
            }
            dialog:not([open]) {
                opacity: 0;
                transform: translateY(20px);
            }
            </style>
        </div>
  
          <!-- Performance Metrics -->
          <div class="flex-1 rounded-xl shadow-md p-1 text-gray-800 ml-0.5 mr-2 mt-2 mb-2"
          style="background-color: rgba(255, 255, 255, 0.5);">
          <h2 class="text-base font-bold text-gray-700 mb-1 text-center">
              Performance Metrics for Skills Assessment in Training and Development
          </h2>

          <div class="grid grid-cols-2 gap-1">
            <!-- Box 1: Diagram -->
            @php
            $targetDeputy = $deputiestraining->firstWhere('id_deputi', 1);
            @endphp

            @if ($targetDeputy)
            <div class="relative w-full h-full">
              <div class="absolute inset-0 flex flex-col items-center justify-center">
                <span class="font-bold text-lg">{{ $targetDeputy['tingkat_relevansi'] }}%</span>
                <span class="font-bold text-center" style="font-size: 8px;">Overall<br>Performance</span>
              </div>
              <img src="/img/diagram.png" alt="Overall Performance" class="w-full h-full object-cover rounded-lg" />
            </div>
            @endif

            @php
                  $colorMap = [
                      1 => 'green-600',
                      2 => 'yellow-500',
                      3 => 'red-500',
                      // Add other colors as needed
                  ];
              @endphp
              @foreach ($divisionsWithRelevance as $division)
              @php
                  $id = $division['id_divisi'];
                  $color = $colorMap[$id] ?? 'gray-500'; // fallback if id is not in the map
                  $kategoriList = $division['kategori_pelatihan'];
                  $kategoriLimited = collect($kategoriList)->take(2);
                  $lebihDariDua = count($kategoriList) > 2;
              @endphp
          
              @if (in_array($id, array_keys($colorMap))) {{-- only render items that are in the mapping --}}
              <div class="bg-white/60 border rounded-lg shadow p-0.5">
                  <div class="bg-{{ $color }} text-white text-xs text-center font-bold rounded-t-md py-0.5 mb-0.5">
                      {{ $division['nama_divisi'] }}
                  </div>
          
                  <p class="text-xs text-gray-700 italic mb-1 flex flex-wrap max-w-full break-words">
                      Training Category: 
                      @foreach ($kategoriLimited as $kategori)
                          <span class="inline-block px-2 py-0.5 bg-gray-200 rounded-full mr-1 mb-1 whitespace-nowrap text-[10px] max-w-[100px] truncate">{{ $kategori }}</span>
                      @endforeach
                      @if ($lebihDariDua)
                          <span class="text-[10px] text-gray-500">and more..</span>
                      @endif
                  </p>
          
                  <h4 class="text-xs text-gray-800 font-semibold flex justify-between items-center">
                      <span>
                          Score: {{ $division['total_relevansi_score'] }}
                           {{-- ({{ $division['persentase_relevansi'] }}%) --}}
                      </span>
                      @if ($lebihDariDua)
                          <button 
                              onclick="showModal({{ $id }})" 
                              class="text-blue-600 hover:underline text-[10px] ml-2"
                          >
                              View Details
                          </button>
                      @endif
                  </h4>
              </div>
              @endif
          @endforeach
              </div>
            </div>
          </div>
        </div>
  
        <!-- Container 3 -->
        <div class="relative max-w-7xl mx-auto rounded-xl shadow-xl overflow-hidden"
          style="background: url('/img/bgdasar3.png') no-repeat center center; background-size: cover;">
  
          <!-- Main Header Row - Title and Hexagons Side by Side -->
          <div class="flex flex-row items-start px-2">
  
          <!-- Employee Profile Header (Left Side) -->
          <div class="flex flex-col items-center w-40 h-30 rounded-b-xl shadow-md p-2 mb-4" style="background-color: #FFEB3B;">
            @if ($kepaladeputi2)
            <div class="w-28 h-28 rounded-full bg-gray-200 border-2 border-gray-300 shadow-inner overflow-hidden">
                <img src="{{ asset('img/foto/' . $kepaladeputi2->foto) }}"
                    alt="{{ $kepaladeputi2->nama }}"
                    class="w-full h-full object-cover rounded-full">
            </div>
            <a href="{{ route('employee', $kepaladeputi2->id_pegawai) }}" class="mt-1 text-center group">
                <p class="text-sm font-semibold text-gray-800 group-hover:underline">
                    {{ ucwords(strtolower($kepaladeputi2->nama)) }}
                </p>
                <p class="text-xs text-gray-600 group-hover:text-blue-600">
                    {{ $kepaladeputi2->bidang }}
                </p>
            </a>
            @endif
        </div>
  
          <!-- Deputy and Division -->
          <div class="flex flex-row ml-1 items-start py-2">
          @foreach ($deputies as $deputi)
            @if ($deputi->id_deputi == 2)
              <div class="ml-1 py-4">
                <a href="{{ route('deputi.show', $deputi->id_deputi) }}"
                  class="absolute -mt-6 text-center no-underline text-white font-bold text-lg cursor-pointer z-10 hover:underline"
                  style="text-shadow: 2px 2px 30px rgba(0,0,0,0.7);">
                   {{ $deputi->nama_deputi }}
               </a>
  
                <div class="flex flex-row gap-1">
                  @foreach ($deputi->divisions as $division)
                    <div class="hexagon-container min-w-[180px]">
                      <div class="hexagon">
                        <div class="top-part">
                          <div class="circle-top">
                            <img src="{{ asset('img/icon-divisi/' . ($division->icon ?? 'default-icon.png')) }}"
                                  alt="{{ $division->nama_divisi }}"
                                  class="w-full h-full object-cover rounded-full">
                          </div>
                        </div>
                        <div class="bottom-part">
                          <a href="{{ route('division.show', $division->id_divisi) }}"
                              class="text-white text-center mb-4 block hover:underline cursor-pointer">
                            {{ $division->nama_divisi }}
                          </a>
                        </div>
                      </div>
                      <div class="circle-bottom text-white text-sm text-center">
                        {{ $division->employees->count() }}
                      </div>
                    </div>
                  @endforeach
                </div>
              </div>
            @endif
          @endforeach
          </div>
          </div>
  
          <!-- Training Relevance -->
          <div class="flex justify-center">
          <div class="flex-col items-center w-40 rounded-t-xl shadow-md bg-opacity-90 p-1 leading-relaxed text-gray-800 mt-1 mx-2 mb-2"
              style="background-color: #0089B7;">
          <h2 class="text-white font-bold text-center text-sm mb-0.5">Training Relevance</h2>
  
          <!-- Image + Percentage -->
          @php
          $targetDeputy = $deputiestraining->firstWhere('id_deputi', 2);
          @endphp
          
          @if ($targetDeputy)
              <div class="relative w-28 h-28 mx-auto">
                  <img src="/img/gambar1.png" alt="Image Description" class="w-full h-full object-cover rounded-md">
                  <div class="absolute inset-0 flex items-center justify-center">
                      <span class="font-bold text-sm mb-2">{{ $targetDeputy['persentase_training'] }}%</span>
                  </div>
              </div>
          @endif

        <!-- Relevance Category -->
        @php
          $id_deputi = 2;
          $modalData = [];
        @endphp

        @foreach (['Low', 'Medium', 'High'] as $level)
            @php
                $items = $formattedRelevansi[$id_deputi][$level] ?? collect();
                $limitedItems = $items->take(1);
                $hasMore = $items->count() > 1;

                if ($hasMore) {
                    $modalData[$level] = $items;
                }
            @endphp

            <div class="box flex items-center gap-1 mb-2">
                <div class="flex gap-1 items-end">
                    <div class="rectangle" style="background-color: {{ $level == 'Low' ? '#ffff' : ($level == 'Medium' ? '#ffff' : '#ffff') }};"></div>
                    <div class="rectangle-2" style="background-color: {{ $level == 'Low' ? '#ffff' : ($level == 'Medium' ? '#ffff' : '#ffff') }};"></div>
                    <div class="rectangle-3" style="background-color: {{ $level == 'Low' ? '#ffff' : ($level == 'Medium' ? '#ffff' : '#ffff') }};"></div>
                </div>
                <div class="text text-white text-xs">
                    <div class="font-semibold -ml-3 leading-tight">{{ $level }} Relevance:</div>
                    <ul class="list-none -ml-8 text-[10px] text-white leading-snug mt-0.5">
                        @forelse($limitedItems as $item)
                          <li>- {{ $item['nama_kategori'] }}</li>
                        @empty
                            <li>No relevant category found.</li>
                        @endforelse
                        @if($hasMore)
                            <li>
                                <button onclick="document.getElementById('modal-{{ $level }}').showModal()" class="underline text-blue-300 ml-1">
                                    View Details
                                </button>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
          @endforeach
            {{-- Render modal after foreach --}}
            @foreach ($modalData as $level => $items)
            <dialog id="modal-{{ $level }}" class="rounded-lg shadow-xl p-6 w-[400px] bg-white text-black z-50 max-w-full">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">{{ $level }} Relevance </h3>
                    <button onclick="document.getElementById('modal-{{ $level }}').close()" class="text-gray-500 hover:text-gray-700 font-bold">&times;</button>
                </div>
                <ul class="list-disc list-inside text-sm space-y-2">
                    @foreach($items as $item)
                        <li class="text-gray-700">{{ $item['nama_kategori'] }}</li>
                    @endforeach
                </ul>
            </dialog>
            @endforeach

            {{-- Styles for smooth modal transition --}}
            <style>
            dialog {
                transition: opacity 0.3s ease, transform 0.3s ease;
            }
            dialog[open] {
                opacity: 1;
                transform: translateY(0);
            }
            dialog:not([open]) {
                opacity: 0;
                transform: translateY(20px);
            }
            </style>
          </div>
  
          <!-- Performance Metrics -->
          <div class="flex-1 rounded-xl shadow-md p-1 text-gray-800 ml-0.5 mr-2 mt-2 mb-2"
              style="background-color: rgba(255, 255, 255, 0.5);">
          <h2 class="text-base font-bold text-gray-700 mb-1 text-center">
            Performance Metrics for Skills Assessment in Training and Development
          </h2>
  
          <div class="grid grid-cols-2 gap-1">
            <!-- Box 1: Diagram -->
            @php
            $targetDeputy = $deputiestraining->firstWhere('id_deputi', 2);
            @endphp

            @if ($targetDeputy)
            <div class="relative w-full h-full">
              <div class="absolute inset-0 flex flex-col items-center justify-center">
                <span class="font-bold text-lg">{{ $targetDeputy['tingkat_relevansi'] }}%</span>
                <span class="font-bold text-center" style="font-size: 8px;">Overall<br>Performance</span>
              </div>
              <img src="/img/diagram.png" alt="Overall Performance" class="w-full h-full object-cover rounded-lg" />
            </div>
            @endif
            
            @php
                $colorMap = [
                    4 => 'green-600',
                    5 => 'yellow-500',
                    6 => 'red-500',
                    // Add other colors as needed
                ];
            @endphp
            @foreach ($divisionsWithRelevance as $division)
            @php
                $id = $division['id_divisi'];
                $color = $colorMap[$id] ?? 'gray-500'; // fallback if id is not in the map
                $kategoriList = $division['kategori_pelatihan'];
                $kategoriLimited = collect($kategoriList)->take(2);
                $lebihDariDua = count($kategoriList) > 2;
            @endphp
        
            @if (in_array($id, array_keys($colorMap))) {{-- only render items that are in the mapping --}}
            <div class="bg-white/60 border rounded-lg shadow p-0.5">
                <div class="bg-{{ $color }} text-white text-xs text-center font-bold rounded-t-md py-0.5 mb-0.5">
                    {{ $division['nama_divisi'] }}
                </div>
        
                <p class="text-xs text-gray-700 italic mb-1 flex flex-wrap max-w-full break-words">
                    Training Category: 
                    @foreach ($kategoriLimited as $kategori)
                        <span class="inline-block px-2 py-0.5 bg-gray-200 rounded-full mr-1 mb-1 whitespace-nowrap text-[10px] max-w-[100px] truncate">{{ $kategori }}</span>
                    @endforeach
                    @if ($lebihDariDua)
                        <span class="text-[10px] text-gray-500">and more..</span>
                    @endif
                </p>
        
                <h4 class="text-xs text-gray-800 font-semibold flex justify-between items-center">
                    <span>
                        Score: {{ $division['total_relevansi_score'] }} 
                        {{-- ({{ $division['persentase_relevansi'] }}%) --}}
                    </span>
                    @if ($lebihDariDua)
                        <button 
                            onclick="showModal({{ $id }})" 
                            class="text-blue-600 hover:underline text-[10px] ml-2"
                        >
                            View Details
                        </button>
                    @endif
                </h4>
            </div>
            @endif
        @endforeach
  
          </div>
          </div>
          </div>
        </div>
  
        <!-- Container 4 -->
        <div class="relative max-w-7xl mx-auto rounded-xl shadow-xl overflow-hidden"  
          style="background: url('/img/bgdasar3.png') no-repeat center center; background-size: cover;">
  
          <!-- Main Header Row - Title and Hexagons Side by Side -->
          <div class="flex flex-row items-start px-2">
  
          <!-- Employee Profile Header (Left Side) -->
          <div class="flex flex-col items-center w-40 h-30 rounded-b-xl shadow-md p-2 mb-4" style="background-color: #FFEB3B;">
            @if ($kepaladeputi3)
            <div class="w-28 h-28 rounded-full bg-gray-200 border-2 border-gray-300 shadow-inner overflow-hidden">
                <img src="{{ asset('img/foto/' . $kepaladeputi3->foto) }}"
                    alt="{{ $kepaladeputi3->nama }}"
                    class="w-full h-full object-cover rounded-full">
            </div>
            <a href="{{ route('employee', $kepaladeputi3->id_pegawai) }}" class="mt-1 text-center group">
                <p class="text-sm font-semibold text-gray-800 group-hover:underline">
                    {{ ucwords(strtolower($kepaladeputi3->nama)) }}
                </p>
                <p class="text-xs text-gray-600 group-hover:text-blue-600">
                    {{ $kepaladeputi3->bidang }}
                </p>
            </a>
            @endif
        </div>
  
          <!-- Deputy and Division -->
          <div class="flex flex-row ml-1 items-start py-2">
          @foreach ($deputies as $deputi)
            @if ($deputi->id_deputi == 3)
              <div class="ml-1 py-4">
                <a href="{{ route('deputi.show', $deputi->id_deputi) }}"
                  class="absolute -mt-6 text-center no-underline text-white font-bold text-lg cursor-pointer z-10 hover:underline"
                  style="text-shadow: 2px 2px 30px rgba(0,0,0,0.7);">
                   {{ $deputi->nama_deputi }}
               </a>
  
                <div class="flex flex-row gap-1">
                  @foreach ($deputi->divisions as $division)
                    <div class="hexagon-container min-w-[180px]">
                      <div class="hexagon">
                        <div class="top-part">
                          <div class="circle-top">
                            <img src="{{ asset('img/icon-divisi/' . ($division->icon ?? 'default-icon.png')) }}"
                                  alt="{{ $division->nama_divisi }}"
                                  class="w-full h-full object-cover rounded-full">
                          </div>
                        </div>
                        <div class="bottom-part">
                          <a href="{{ route('division.show', $division->id_divisi) }}"
                              class="text-white text-center mb-4 block hover:underline cursor-pointer">
                            {{ $division->nama_divisi }}
                          </a>
                        </div>
                      </div>
                      <div class="circle-bottom text-white text-sm text-center">
                        {{ $division->employees->count() }}
                      </div>
                    </div>
                  @endforeach
                </div>
              </div>
            @endif
          @endforeach
          </div>
          </div>
  
          <!-- Training Relevance -->
          <div class="flex justify-center">
          <div class="flex-col items-center w-40 rounded-t-xl shadow-md bg-opacity-90 p-1 leading-relaxed text-gray-800 mt-1 mx-2 mb-2"
              style="background-color: #0089B7;">
          <h2 class="text-white font-bold text-center text-sm mb-0.5">Training Relevance</h2>
  
          <!-- Image + Percentage -->
          @php
          $targetDeputy = $deputiestraining->firstWhere('id_deputi', 3);
          @endphp
          
          @if ($targetDeputy)
              <div class="relative w-28 h-28 mx-auto">
                  <img src="/img/gambar1.png" alt="Image Description" class="w-full h-full object-cover rounded-md">
                  <div class="absolute inset-0 flex items-center justify-center">
                      <span class="font-bold text-sm mb-2">{{ $targetDeputy['persentase_training'] }}%</span>
                  </div>
              </div>
          @endif

        <!-- Relevance Category -->
        @php
          $id_deputi = 3;
          $modalData = [];
        @endphp

        @foreach (['Low', 'Medium', 'High'] as $level)
            @php
                $items = $formattedRelevansi[$id_deputi][$level] ?? collect();
                $limitedItems = $items->take(1);
                $hasMore = $items->count() > 1;

                if ($hasMore) {
                    $modalData[$level] = $items;
                }
            @endphp

            <div class="box flex items-center gap-1 mb-2">
                <div class="flex gap-1 items-end">
                    <div class="rectangle" style="background-color: {{ $level == 'Low' ? '#ffff' : ($level == 'Medium' ? '#ffff' : '#ffff') }};"></div>
                    <div class="rectangle-2" style="background-color: {{ $level == 'Low' ? '#ffff' : ($level == 'Medium' ? '#ffff' : '#ffff') }};"></div>
                    <div class="rectangle-3" style="background-color: {{ $level == 'Low' ? '#ffff' : ($level == 'Medium' ? '#ffff' : '#ffff') }};"></div>
                </div>
                <div class="text text-white text-xs">
                    <div class="font-semibold -ml-3 leading-tight">{{ $level }} Relevance:</div>
                    <ul class="list-none -ml-8 text-[10px] text-white leading-snug mt-0.5">
                        @forelse($limitedItems as $item)
                          <li>- {{ $item['nama_kategori'] }}</li>
                        @empty
                            <li>No relevant category found.</li>
                        @endforelse
                        @if($hasMore)
                            <li>
                                <button onclick="document.getElementById('modal-{{ $level }}').showModal()" class="underline text-blue-300 ml-1">
                                    View Details
                                </button>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
          @endforeach
            {{-- Render modal after foreach --}}
            @foreach ($modalData as $level => $items)
            <dialog id="modal-{{ $level }}" class="rounded-lg shadow-xl p-6 w-[400px] bg-white text-black z-50 max-w-full">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">{{ $level }} Relevance </h3>
                    <button onclick="document.getElementById('modal-{{ $level }}').close()" class="text-gray-500 hover:text-gray-700 font-bold">&times;</button>
                </div>
                <ul class="list-disc list-inside text-sm space-y-2">
                    @foreach($items as $item)
                        <li class="text-gray-700">{{ $item['nama_kategori'] }}</li>
                    @endforeach
                </ul>
            </dialog>
            @endforeach

            {{-- Styles for smooth modal transition --}}
            <style>
            dialog {
                transition: opacity 0.3s ease, transform 0.3s ease;
            }
            dialog[open] {
                opacity: 1;
                transform: translateY(0);
            }
            dialog:not([open]) {
                opacity: 0;
                transform: translateY(20px);
            }
            </style>
          </div>
  
          <!-- Performance Metrics -->
          <div class="flex-1 rounded-xl shadow-md p-1 text-gray-800 ml-0.5 mr-2 mt-2 mb-2"
              style="background-color: rgba(255, 255, 255, 0.5);">
          <h2 class="text-base font-bold text-gray-700 mb-1 text-center">
            Performance Metrics for Skills Assessment in Training and Development
          </h2>
  
          <div class="grid grid-cols-2 gap-1">
            <!-- Box 1: Diagram -->
            @php
            $targetDeputy = $deputiestraining->firstWhere('id_deputi', 3);
            @endphp

            @if ($targetDeputy)
            <div class="relative w-full h-full">
              <div class="absolute inset-0 flex flex-col items-center justify-center">
                <span class="font-bold text-lg">{{ $targetDeputy['tingkat_relevansi'] }}%</span>
                <span class="font-bold text-center" style="font-size: 8px;">Overall<br>Performance</span>
              </div>
              <img src="/img/diagram.png" alt="Overall Performance" class="w-full h-full object-cover rounded-lg" />
            </div>
            @endif
            
            @php
                $colorMap = [
                    7 => 'green-600',
                    8 => 'yellow-500',
                    9 => 'red-500',
                    // Add other colors as needed
                ];
            @endphp
            @foreach ($divisionsWithRelevance as $division)
            @php
                $id = $division['id_divisi'];
                $color = $colorMap[$id] ?? 'gray-500'; // fallback if id is not in the map
                $kategoriList = $division['kategori_pelatihan'];
                $kategoriLimited = collect($kategoriList)->take(2);
                $lebihDariDua = count($kategoriList) > 2;
            @endphp
        
            @if (in_array($id, array_keys($colorMap))) {{-- only render items that are in the mapping --}}
            <div class="bg-white/60 border rounded-lg shadow p-0.5">
                <div class="bg-{{ $color }} text-white text-xs text-center font-bold rounded-t-md py-0.5 mb-0.5">
                    {{ $division['nama_divisi'] }}
                </div>
        
                <p class="text-xs text-gray-700 italic mb-1 flex flex-wrap max-w-full break-words">
                    Training Category: 
                    @foreach ($kategoriLimited as $kategori)
                        <span class="inline-block px-2 py-0.5 bg-gray-200 rounded-full mr-1 mb-1 whitespace-nowrap text-[10px] max-w-[100px] truncate">{{ $kategori }}</span>
                    @endforeach
                    @if ($lebihDariDua)
                        <span class="text-[10px] text-gray-500">and more..</span>
                    @endif
                </p>
        
                <h4 class="text-xs text-gray-800 font-semibold flex justify-between items-center">
                    <span>
                        Score: {{ $division['total_relevansi_score'] }} 
                        {{-- ({{ $division['persentase_relevansi'] }}%) --}}
                    </span>
                    @if ($lebihDariDua)
                        <button 
                            onclick="showModal({{ $id }})" 
                            class="text-blue-600 hover:underline text-[10px] ml-2"
                        >
                            View Details
                        </button>
                    @endif
                </h4>
            </div>
            @endif
        @endforeach      
  
          </div>
          </div>
          </div>
        </div>

        <!-- Container 5 -->
        <div class="relative max-w-7xl mx-auto rounded-xl shadow-xl overflow-hidden"  
          style="background: url('/img/bgdasar3.png') no-repeat center center; background-size: cover;">
  
          <!-- Main Header Row - Title and Hexagons Side by Side -->
          <div class="flex flex-row items-start px-2">
  
          <!-- Employee Profile Header (Left Side) -->
          <div class="flex flex-col items-center w-40 h-30 rounded-b-xl shadow-md p-2 mb-4" style="background-color: #FFEB3B;">
            @if ($kepaladeputi4)
            <div class="w-28 h-28 rounded-full bg-gray-200 border-2 border-gray-300 shadow-inner overflow-hidden">
                <img src="{{ asset('img/foto/' . $kepaladeputi4->foto) }}"
                    alt="{{ $kepaladeputi4->nama }}"
                    class="w-full h-full object-cover rounded-full">
            </div>
            <a href="{{ route('employee', $kepaladeputi4->id_pegawai) }}" class="mt-1 text-center group">
                <p class="text-sm font-semibold text-gray-800 group-hover:underline">
                    {{ ucwords(strtolower($kepaladeputi4->nama)) }}
                </p>
                <p class="text-xs text-gray-600 group-hover:text-blue-600">
                    {{ $kepaladeputi4->bidang }}
                </p>
            </a>
            @endif
        </div>
  
          <!-- Deputy and Division -->
          <div class="flex flex-row ml-1 items-start py-2">
          @foreach ($deputies as $deputi)
            @if ($deputi->id_deputi == 4)
              <div class="ml-1 py-4">
                <a href="{{ route('deputi.show', $deputi->id_deputi) }}"
                  class="absolute -mt-6 text-center no-underline text-white font-bold text-lg cursor-pointer z-10 hover:underline"
                  style="text-shadow: 2px 2px 30px rgba(0,0,0,0.7);">
                   {{ $deputi->nama_deputi }}
               </a>
  
                <div class="flex flex-row gap-1">
                  @foreach ($deputi->divisions as $division)
                    <div class="hexagon-container min-w-[180px]">
                      <div class="hexagon">
                        <div class="top-part">
                          <div class="circle-top">
                            <img src="{{ asset('img/icon-divisi/' . ($division->icon ?? 'default-icon.png')) }}"
                                  alt="{{ $division->nama_divisi }}"
                                  class="w-full h-full object-cover rounded-full">
                          </div>
                        </div>
                        <div class="bottom-part">
                          <a href="{{ route('division.show', $division->id_divisi) }}"
                              class="text-white text-center mb-4 block hover:underline cursor-pointer">
                            {{ $division->nama_divisi }}
                          </a>
                        </div>
                      </div>
                      <div class="circle-bottom text-white text-sm text-center">
                        {{ $division->employees->count() }}
                      </div>
                    </div>
                  @endforeach
                </div>
              </div>
            @endif
          @endforeach
          </div>
          </div>
  
          <!-- Training Relevance -->
          <div class="flex justify-center">
          <div class="flex-col items-center w-40 rounded-t-xl shadow-md bg-opacity-90 p-1 leading-relaxed text-gray-800 mt-1 mx-2 mb-2"
              style="background-color: #0089B7;">
          <h2 class="text-white font-bold text-center text-sm mb-0.5">Training Relevance</h2>
  
          <!-- Image + Percentage -->
          @php
          $targetDeputy = $deputiestraining->firstWhere('id_deputi', 4);
          @endphp
          
          @if ($targetDeputy)
              <div class="relative w-28 h-28 mx-auto">
                  <img src="/img/gambar1.png" alt="Image Description" class="w-full h-full object-cover rounded-md">
                  <div class="absolute inset-0 flex items-center justify-center">
                      <span class="font-bold text-sm mb-2">{{ $targetDeputy['persentase_training'] }}%</span>
                  </div>
              </div>
          @endif

        <!-- Relevance Category -->
        @php
          $id_deputi = 4;
          $modalData = [];
        @endphp

        @foreach (['Low', 'Medium', 'High'] as $level)
            @php
                $items = $formattedRelevansi[$id_deputi][$level] ?? collect();
                $limitedItems = $items->take(1);
                $hasMore = $items->count() > 1;

                if ($hasMore) {
                    $modalData[$level] = $items;
                }
            @endphp

            <div class="box flex items-center gap-1 mb-2">
                <div class="flex gap-1 items-end">
                    <div class="rectangle" style="background-color: {{ $level == 'Low' ? '#ffff' : ($level == 'Medium' ? '#ffff' : '#ffff') }};"></div>
                    <div class="rectangle-2" style="background-color: {{ $level == 'Low' ? '#ffff' : ($level == 'Medium' ? '#ffff' : '#ffff') }};"></div>
                    <div class="rectangle-3" style="background-color: {{ $level == 'Low' ? '#ffff' : ($level == 'Medium' ? '#ffff' : '#ffff') }};"></div>
                </div>
                <div class="text text-white text-xs">
                    <div class="font-semibold -ml-3 leading-tight">{{ $level }} Relevance:</div>
                    <ul class="list-none -ml-8 text-[10px] text-white leading-snug mt-0.5">
                        @forelse($limitedItems as $item)
                          <li>- {{ $item['nama_kategori'] }}</li>
                        @empty
                            <li>No relevant category found.</li>
                        @endforelse
                        @if($hasMore)
                            <li>
                                <button onclick="document.getElementById('modal-{{ $level }}').showModal()" class="underline text-blue-300 ml-1">
                                    View Details
                                </button>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
          @endforeach
            {{-- Render modal after foreach --}}
            @foreach ($modalData as $level => $items)
            <dialog id="modal-{{ $level }}" class="rounded-lg shadow-xl p-6 w-[400px] bg-white text-black z-50 max-w-full">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">{{ $level }} Relevance </h3>
                    <button onclick="document.getElementById('modal-{{ $level }}').close()" class="text-gray-500 hover:text-gray-700 font-bold">&times;</button>
                </div>
                <ul class="list-disc list-inside text-sm space-y-2">
                    @foreach($items as $item)
                        <li class="text-gray-700">{{ $item['nama_kategori'] }}</li>
                    @endforeach
                </ul>
            </dialog>
            @endforeach

            {{-- Styles for smooth modal transition --}}
            <style>
            dialog {
                transition: opacity 0.3s ease, transform 0.3s ease;
            }
            dialog[open] {
                opacity: 1;
                transform: translateY(0);
            }
            dialog:not([open]) {
                opacity: 0;
                transform: translateY(20px);
            }
            </style>
          </div>
  
          <!-- Performance Metrics -->
          <div class="flex-1 rounded-xl shadow-md p-1 text-gray-800 ml-0.5 mr-2 mt-2 mb-2"
              style="background-color: rgba(255, 255, 255, 0.5);">
          <h2 class="text-base font-bold text-gray-700 mb-1 text-center">
            Performance Metrics for Skills Assessment in Training and Development
          </h2>
  
          <div class="grid grid-cols-2 gap-1">
            <!-- Box 1: Diagram -->
            @php
            $targetDeputy = $deputiestraining->firstWhere('id_deputi', 4);
            @endphp

            @if ($targetDeputy)
            <div class="relative w-full h-full">
              <div class="absolute inset-0 flex flex-col items-center justify-center">
                <span class="font-bold text-lg">{{ $targetDeputy['tingkat_relevansi'] }}%</span>
                <span class="font-bold text-center" style="font-size: 8px;">Overall<br>Performance</span>
              </div>
              <img src="/img/diagram.png" alt="Overall Performance" class="w-full h-full object-cover rounded-lg" />
            </div>
            @endif

            @php
                $colorMap = [
                    10 => 'green-600',
                    11 => 'yellow-500',
                    12 => 'red-500',
                    // Add other colors as needed
                ];
            @endphp
            @foreach ($divisionsWithRelevance as $division)
            @php
                $id = $division['id_divisi'];
                $color = $colorMap[$id] ?? 'gray-500'; // fallback if id is not in the map
                $kategoriList = $division['kategori_pelatihan'];
                $kategoriLimited = collect($kategoriList)->take(2);
                $lebihDariDua = count($kategoriList) > 2;
            @endphp
        
            @if (in_array($id, array_keys($colorMap))) {{-- only render items that are in the mapping --}}
            <div class="bg-white/60 border rounded-lg shadow p-0.5">
                <div class="bg-{{ $color }} text-white text-xs text-center font-bold rounded-t-md py-0.5 mb-0.5">
                    {{ $division['nama_divisi'] }}
                </div>
        
                <p class="text-xs text-gray-700 italic mb-1 flex flex-wrap max-w-full break-words">
                    Training Category: 
                    @foreach ($kategoriLimited as $kategori)
                        <span class="inline-block px-2 py-0.5 bg-gray-200 rounded-full mr-1 mb-1 whitespace-nowrap text-[10px] max-w-[100px] truncate">{{ $kategori }}</span>
                    @endforeach
                    @if ($lebihDariDua)
                        <span class="text-[10px] text-gray-500">and more..</span>
                    @endif
                </p>
        
                <h4 class="text-xs text-gray-800 font-semibold flex justify-between items-center">
                    <span>
                        Score: {{ $division['total_relevansi_score'] }} 
                        {{-- ({{ $division['persentase_relevansi'] }}%) --}}
                    </span>
                    @if ($lebihDariDua)
                        <button 
                            onclick="showModal({{ $id }})" 
                            class="text-blue-600 hover:underline text-[10px] ml-2"
                        >
                            View Details
                        </button>
                    @endif
                </h4>
            </div>
            @endif
        @endforeach

          </div>
          </div>
          </div>
        </div>

        <!-- Container 6 -->
        <div class="relative max-w-7xl mx-auto rounded-xl shadow-xl overflow-hidden"  
          style="background: url('/img/bgdasar3.png') no-repeat center center; background-size: cover;">
  
          <!-- Main Header Row - Title and Hexagons Side by Side -->
          <div class="flex flex-row items-start px-2">
  
          <!-- Employee Profile Header (Left Side) -->
          <div class="flex flex-col items-center w-40 h-30 rounded-b-xl shadow-md p-2 mb-4" style="background-color: #FFEB3B;">
            @if ($kepaladeputi5)
            <div class="w-28 h-28 rounded-full bg-gray-200 border-2 border-gray-300 shadow-inner overflow-hidden">
                <img src="{{ asset('img/foto/' . $kepaladeputi5->foto) }}"
                    alt="{{ $kepaladeputi5->nama }}"
                    class="w-full h-full object-cover rounded-full">
            </div>
            <a href="{{ route('employee', $kepaladeputi5->id_pegawai) }}" class="mt-1 text-center group">
                <p class="text-sm font-semibold text-gray-800 group-hover:underline">
                    {{ ucwords(strtolower($kepaladeputi5->nama)) }}
                </p>
                <p class="text-xs text-gray-600 group-hover:text-blue-600">
                    {{ $kepaladeputi5->bidang }}
                </p>
            </a>
            @endif
        </div>
  
          <!-- Deputy and Division -->
          <div class="flex flex-row ml-1 items-start py-2">
          @foreach ($deputies as $deputi)
            @if ($deputi->id_deputi == 5)
              <div class="ml-1 py-4">
                <a href="{{ route('deputi.show', $deputi->id_deputi) }}"
                  class="absolute -mt-6 text-center no-underline text-white font-bold text-lg cursor-pointer z-10 hover:underline"
                  style="text-shadow: 2px 2px 30px rgba(0,0,0,0.7);">
                   {{ $deputi->nama_deputi }}
               </a>
  
                <div class="flex flex-row gap-1">
                  @foreach ($deputi->divisions as $division)
                    <div class="hexagon-container min-w-[180px]">
                      <div class="hexagon">
                        <div class="top-part">
                          <div class="circle-top">
                            <img src="{{ asset('img/icon-divisi/' . ($division->icon ?? 'default-icon.png')) }}"
                                  alt="{{ $division->nama_divisi }}"
                                  class="w-full h-full object-cover rounded-full">
                          </div>
                        </div>
                        <div class="bottom-part">
                          <a href="{{ route('division.show', $division->id_divisi) }}"
                              class="text-white text-center mb-4 block hover:underline cursor-pointer">
                            {{ $division->nama_divisi }}
                          </a>
                        </div>
                      </div>
                      <div class="circle-bottom text-white text-sm text-center">
                        {{ $division->employees->count() }}
                      </div>
                    </div>
                  @endforeach
                </div>
              </div>
            @endif
          @endforeach
          </div>
          </div>
  
          <!-- Training Relevance -->
          <div class="flex justify-center">
          <div class="flex-col items-center w-40 rounded-t-xl shadow-md bg-opacity-90 p-1 leading-relaxed text-gray-800 mt-1 mx-2 mb-2"
              style="background-color: #0089B7;">
          <h2 class="text-white font-bold text-center text-sm mb-0.5">Training Relevance</h2>
  
          <!-- Image + Percentage -->
          @php
          $targetDeputy = $deputiestraining->firstWhere('id_deputi', 5);
          @endphp
          
          @if ($targetDeputy)
              <div class="relative w-28 h-28 mx-auto">
                  <img src="/img/gambar1.png" alt="Image Description" class="w-full h-full object-cover rounded-md">
                  <div class="absolute inset-0 flex items-center justify-center">
                      <span class="font-bold text-sm mb-2">{{ $targetDeputy['persentase_training'] }}%</span>
                  </div>
              </div>
          @endif

        <!-- Relevance Category -->
        @php
          $id_deputi = 5;
          $modalData = [];
        @endphp

        @foreach (['Low', 'Medium', 'High'] as $level)
            @php
                $items = $formattedRelevansi[$id_deputi][$level] ?? collect();
                $limitedItems = $items->take(1);
                $hasMore = $items->count() > 1;

                if ($hasMore) {
                    $modalData[$level] = $items;
                }
            @endphp

            <div class="box flex items-center gap-1 mb-2">
                <div class="flex gap-1 items-end">
                    <div class="rectangle" style="background-color: {{ $level == 'Low' ? '#ffff' : ($level == 'Medium' ? '#ffff' : '#ffff') }};"></div>
                    <div class="rectangle-2" style="background-color: {{ $level == 'Low' ? '#ffff' : ($level == 'Medium' ? '#ffff' : '#ffff') }};"></div>
                    <div class="rectangle-3" style="background-color: {{ $level == 'Low' ? '#ffff' : ($level == 'Medium' ? '#ffff' : '#ffff') }};"></div>
                </div>
                <div class="text text-white text-xs">
                    <div class="font-semibold -ml-3 leading-tight">{{ $level }} Relevance:</div>
                    <ul class="list-none -ml-8 text-[10px] text-white leading-snug mt-0.5">
                        @forelse($limitedItems as $item)
                          <li>- {{ $item['nama_kategori'] }}</li>
                        @empty
                            <li>No relevant category found.</li>
                        @endforelse
                        @if($hasMore)
                            <li>
                                <button onclick="document.getElementById('modal-{{ $level }}').showModal()" class="underline text-blue-300 ml-1">
                                    View Details
                                </button>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
          @endforeach
            {{-- Render modal after foreach --}}
            @foreach ($modalData as $level => $items)
            <dialog id="modal-{{ $level }}" class="rounded-lg shadow-xl p-6 w-[400px] bg-white text-black z-50 max-w-full">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">{{ $level }} Relevance </h3>
                    <button onclick="document.getElementById('modal-{{ $level }}').close()" class="text-gray-500 hover:text-gray-700 font-bold">&times;</button>
                </div>
                <ul class="list-disc list-inside text-sm space-y-2">
                    @foreach($items as $item)
                        <li class="text-gray-700">{{ $item['nama_kategori'] }}</li>
                    @endforeach
                </ul>
            </dialog>
            @endforeach

            {{-- Styles for smooth modal transition --}}
            <style>
            dialog {
                transition: opacity 0.3s ease, transform 0.3s ease;
            }
            dialog[open] {
                opacity: 1;
                transform: translateY(0);
            }
            dialog:not([open]) {
                opacity: 0;
                transform: translateY(20px);
            }
            </style>
        </div>
  
          <!-- Performance Metrics -->
          <div class="flex-1 rounded-xl shadow-md p-1 text-gray-800 ml-0.5 mr-2 mt-2 mb-2"
              style="background-color: rgba(255, 255, 255, 0.5);">
          <h2 class="text-base font-bold text-gray-700 mb-1 text-center">
            Performance Metrics for Skills Assessment in Training and Development
          </h2>
  
          <div class="grid grid-cols-2 gap-1">
            <!-- Box 1: Diagram -->
            @php
            $targetDeputy = $deputiestraining->firstWhere('id_deputi', 5);
            @endphp

            @if ($targetDeputy)
            <div class="relative w-full h-full">
              <div class="absolute inset-0 flex flex-col items-center justify-center">
                <span class="font-bold text-lg">{{ $targetDeputy['tingkat_relevansi'] }}%</span>
                <span class="font-bold text-center" style="font-size: 8px;">Overall<br>Performance</span>
              </div>
              <img src="/img/diagram.png" alt="Overall Performance" class="w-full h-full object-cover rounded-lg" />
            </div>
            @endif
            
            @php
                $colorMap = [
                    13 => 'green-600',
                    14 => 'yellow-500',
                    15 => 'red-500',
                    // Add other colors as needed
                ];
            @endphp
            @foreach ($divisionsWithRelevance as $division)
            @php
                $id = $division['id_divisi'];
                $color = $colorMap[$id] ?? 'gray-500'; // fallback if id is not in the map
                $kategoriList = $division['kategori_pelatihan'];
                $kategoriLimited = collect($kategoriList)->take(2);
                $lebihDariDua = count($kategoriList) > 2;
            @endphp
        
            @if (in_array($id, array_keys($colorMap))) {{-- only render items that are in the mapping --}}
            <div class="bg-white/60 border rounded-lg shadow p-0.5">
                <div class="bg-{{ $color }} text-white text-xs text-center font-bold rounded-t-md py-0.5 mb-0.5">
                    {{ $division['nama_divisi'] }}
                </div>
        
                <p class="text-xs text-gray-700 italic mb-1 flex flex-wrap max-w-full break-words">
                    Training Category: 
                    @foreach ($kategoriLimited as $kategori)
                        <span class="inline-block px-2 py-0.5 bg-gray-200 rounded-full mr-1 mb-1 whitespace-nowrap text-[10px] max-w-[100px] truncate">{{ $kategori }}</span>
                    @endforeach
                    @if ($lebihDariDua)
                        <span class="text-[10px] text-gray-500">and more..</span>
                    @endif
                </p>
        
                <h4 class="text-xs text-gray-800 font-semibold flex justify-between items-center">
                    <span>
                        Score: {{ $division['total_relevansi_score'] }} 
                        {{-- ({{ $division['persentase_relevansi'] }}%) --}}
                    </span>
                    @if ($lebihDariDua)
                        <button 
                            onclick="showModal({{ $id }})" 
                            class="text-blue-600 hover:underline text-[10px] ml-2"
                        >
                            View Details
                        </button>
                    @endif
                </h4>
            </div>
            @endif
        @endforeach

          </div>
          </div>
          </div>
        </div>
    </div>

    <script>
      const kategoriData = @json($divisionsWithRelevance->keyBy('id_divisi'));
  
      // Function to open the category modal
      function showModal(id) {
          const modal = document.getElementById('modal-pelatihan');
          const modalContent = document.getElementById('modal-content');
  
          const kategoriList = kategoriData[id]?.kategori_pelatihan || [];
  
          modalContent.innerHTML = kategoriList.map(k => `
              <span class="inline-block px-3 py-1 bg-gray-200 text-sm rounded-full text-gray-800 shadow-sm">
                  ${k}
              </span>
          `).join('');
  
          modal.classList.remove('hidden');
      }
  
      // Function to close the category modal
      function closeModal() {
          document.getElementById('modal-pelatihan').classList.add('hidden');
      }
  
      // Function to open the modal based on level
      function openLevelModal(level) {
          const modal = document.getElementById('modal-' + level);
          modal.classList.remove('hidden');
          modal.classList.add('flex');
      }
  
      // Function to close the modal based on level
      function closeLevelModal(level) {
          const modal = document.getElementById('modal-' + level);
          modal.classList.add('hidden');
          modal.classList.remove('flex');
      }
  </script>
  
  {{-- Modal for training category details --}}
  <div id="modal-pelatihan" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-2xl shadow-xl w-[90%] max-w-md p-6 animate-fadeInScale relative">
      <!-- Close button -->
      <button 
        onclick="closeModal()" 
        class="absolute top-3 right-3 text-gray-500 hover:text-red-500 text-2xl font-bold focus:outline-none"
        aria-label="Close"
      >
        &times;
      </button>
  
      <!-- Title -->
      <h3 class="text-lg font-semibold text-gray-800 mb-3 text-center border-b pb-2">
        Training Category Details
      </h3>
  
      <!-- Scrollable content -->
      <div id="modal-content" class="flex flex-wrap gap-2 max-h-60 overflow-y-auto pr-1">
        <!-- kategori items will be inserted here -->
      </div>
    </div>
  </div>
  
  <!-- Fade-in animation -->
  <style>
  @keyframes fadeInScale {
    0% {
      opacity: 0;
      transform: scale(0.9);
    }
    100% {
      opacity: 1;
      transform: scale(1);
    }
  }
  .animate-fadeInScale {
    animation: fadeInScale 0.3s ease-out;
  }
  </style>
  
  {{-- Styles for smooth modal transition --}}
  <style>
      .modal {
          transition: opacity 0.3s ease, transform 0.3s ease;
      }
      .modal-content {
          animation: modalFadeIn 0.3s ease-out;
      }
      @keyframes modalFadeIn {
          0% {
              opacity: 0;
              transform: translateY(20px);
          }
          100% {
              opacity: 1;
              transform: translateY(0);
          }
      }
  </style>
  
@endsection