@extends('layout.master2')
@section('content1')

    <div class="relative w-full mx-auto h-auto p-4" style="max-width: 85rem;">
        <!-- Background -->
        <div class="relative">
            <img src="{{ asset('img/background card.png') }}" alt="Background" class="w-full h-auto object-cover rounded-xl shadow-md">
    
            <!-- Overlay Semua Konten -->
            <div class="absolute inset-0 flex flex-col p-2 md:p-10 space-y-6 overflow-auto">
    
            <!-- Baris Pertama: 3 kolom (custom ukuran) -->
            {{-- <div class="grid grid-cols-1 md:grid-cols-12 gap-2"> --}}
                <div class="flex flex-row md:grid md:grid-cols-12 gap-1 md:gap-2">
                <!-- Kolom 1: Header -->
                <div class="col-span-3 flex flex-col items-center w-1/4 md:w-full h-7/8 md:h-full p-2 rounded-xl shadow text-base"
                style="background: linear-gradient(to bottom, #2DC6D0, #25B3BD, #1397A0, #007B83);">
                
                @if (!empty($employee['foto_pegawai']))
                <img src="{{ asset('storage/foto_pegawai/'.$employee['foto_pegawai']) }}" 
                     alt="Foto {{ $employee['nama'] }}"
                     class="w-10 h-10 md:w-32 md:h-32 rounded-full shadow-lg mb-3 md:mb-6 object-cover">
                @else
                    <div class="w-10 h-10 md:w-32 md:h-32  bg-white rounded-full shadow-lg mb-3 md:mb-6 flex items-center justify-center text-gray-400">
                        No Image
                    </div>
                @endif     
                           
                <div class="text-white text-center space-y-2 md:w-full md:max-w-sm">
                    <div class="text-xs md:text-xl py-0.5 font-bold md:py-4 px-6 rounded-lg" style="background-color: rgba(255, 255, 255, 0.5);">
                        {{ $employee['nama'] }}
                    </div>
                    <div class="text-xs md:text-xl py-0.5 md:py-4 px-6 font-bold rounded-lg" style="background-color: rgba(255, 255, 255, 0.5);">
                        {{ $employee['id_pegawai'] }}
                    </div>
                </div>
            </div>
            

                <!-- Kolom 2: Judul dan Informasi -->
                {{-- <div class="flex flex-row md:grid md:grid-cols-12 gap-1 md:gap-2"> --}}
                <div class="col-span-7 font-bold text-left">
                    <h1 class="text-base md:text-5xl text-white text-center font-bold drop-shadow-xl mb-1 md:mb-3 mt-1">EMPLOYEE TRAINING PROFILES</h1>
                    <div class="space-y-3">
                        <p class="h-5 md:h-12 px-2 py-1 rounded-lg flex items-center justify-start text-left text-ellipsis overflow-hidden text-xs md:text-base" style="background-color: rgba(255, 255, 255, 0.8);">
                            {{ $employee['nama'] }}
                        </p>
                        <p class="h-5 md:h-12 px-2 py-1 rounded-lg flex items-center justify-start text-left text-ellipsis overflow-hidden text-xs md:text-base" style="background-color: rgba(255, 255, 255, 0.8);">
                            {{ $employee['id_pegawai'] }}
                        </p>
                        <p class="h-5 md:h-12 px-2 py-1 rounded-lg flex items-center justify-start text-left text-ellipsis overflow-hidden text-xs md:text-base" style="background-color: rgba(255, 255, 255, 0.8);">
                            {{ $employee['Roles'] }}
                        </p>
                        <p class="h-5 md:h-12 px-2 py-1 rounded-lg flex items-center justify-start text-left text-ellipsis overflow-hidden text-xs md:text-base" style="background-color: rgba(255, 255, 255, 0.8);">
                            {{ $employee['bidang'] }}
                        </p>
                    </div>                    
                </div>
                

                <!-- Kolom 3: Icon Star -->
                <div class="col-span-2 flex justify-center">
                    <img src="{{ asset('img/star.png') }}" alt="Star Icon" class="w-20 md:w-40 aspect-square object-contain ml-6 -mt-10 md:ml-0 md:mt-0">
                </div>
            </div>

    
                <!-- Baris Kedua: New Info Section -->
                <div class="rounded-xl shadow-lg p-6 space-y-6 mt-3" style="background-color: rgba(255, 255, 255, 0.7);">
                    <div class="grid md:grid-cols-2 gap-4">
                        <div class="h-12 font-bold bg-white text-sm md:text-lg flex items-center justify-start pl-5">Skill or Competence Level </div>
                        <div class="h-12 font-black bg-white text-lg md:text-xl flex items-center justify-center">{{ $employee['level'] ?? '' }}</div>
    
                        <div class="h-12 font-bold bg-white text-sm md:text-lg flex items-center justify-start pl-5">Number of Training Sessions Attended </div>
                        <div class="h-12 font-bold bg-white text-sm md:text-lg flex items-center justify-center">{{ $employee->trainings()->count() }}</div>
    
                        <div class="h-12 font-bold bg-white text-sm md:text-lg flex items-center justify-start pl-5">List of Training Sessions Attended </div>
                        <div>
                            <select id="trainingDropdown" onchange="showTrainingFromDropdown()" class="w-full h-12 p-2 border rounded">
                                <option value="">-- Pelatihan yang di ikuti --</option>
                                @foreach($employee->trainings as $training)
                                    <option value="{{ $training->id }}"
                                            data-nama="{{ $training->nama_pelatihan }}"
                                            data-deskripsi="{{ $training->deskripsi_pelatihan }}"
                                            data-relevansi="{{ $training->pivot->tingkat_relevansi }}"
                                            data-alasan="{{ $training->pivot->alasan_relevansi }}">
                                        {{ $training->nama_pelatihan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
    
                    <div class="text-center">
                        <div class="h-12 font-bold bg-white text-sm md:text-lg flex items-center justify-center pl-5 ext-blue-700 hover:text-blue-900 cursor-pointer"
                             onclick="loadRecommendations({{ $employee->id_pegawai }})">
                            Employee Training Development Recommendations
                        </div>
                    </div>
                </div>
    
            </div>
        </div>
    </div>
    


<!-- Modal Pelatihan & Rekomendasi -->
<div id="recommendationModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-sm hidden z-50 transition-opacity duration-300 ease-in-out">
    <div class="bg-gradient-to-br from-white via-blue-50 to-blue-100 rounded-2xl w-full max-w-5xl mx-4 p-4 md:p-8 border border-blue-200 shadow-2xl animate-fade-in overflow-y-auto max-h-[90vh]">
        <div class="mb-6 text-center">
            <h3 class="text-2xl md:text-5xl font-extrabold text-blue-800">REKOMENDASI PELATIHAN</h3>
            <h3 id="modalJenisRekomendasi" class="text-xl md:text-3xl font-extrabold text-blue-700 mt-1"></h3>
        </div>

        <div id="recommendationContent" class="space-y-3 text-sm md:text-lg"></div>

        <div class="text-center mt-10">
            <button onclick="closeRecommendationModal()" class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold px-4 md:px-6 py-2 rounded-full shadow-md hover:shadow-lg transition text-sm md:text-base">
                Close
            </button>
        </div>
    </div>
</div>



<!-- Modal Detail Training -->
<div id="trainingModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-sm hidden z-50 transition-opacity duration-300 ease-in-out">
    <div class="bg-gradient-to-br from-white via-blue-50 to-blue-100 rounded-2xl w-full max-w-5xl mx-4 p-4 md:p-8 border border-blue-200 shadow-2xl animate-fade-in overflow-y-auto max-h-[90vh]">
        <div class="mb-4 text-center">
            <h3 class="text-2xl md:text-5xl font-extrabold text-blue-800" id="modalNamaPelatihan">📘 Nama Pelatihan</h3>
            <p class="text-base md:text-xl text-gray-600 mt-1">
                Tingkat Relavansi : <span id="modalRelevansi" class="text-xl md:text-4xl font-extrabold text-blue-700"></span>
            </p>
            <p class="italic text-xs md:text-sm text-gray-400">Sertifikasi Teknis / Soft Skill Training</p>
        </div>

        <div class="mb-6">
            <h4 class="text-xl md:text-3xl font-bold text-blue-700 mb-2">🔍 TRAINING OVERVIEW</h4>
            <p id="modalDeskripsiPelatihan" class="text-gray-800 leading-relaxed text-sm md:text-xl">
                (Deskripsi Pelatihan akan muncul di sini)
            </p>
        </div>

        <div class="mb-8">
            <h4 class="text-xl md:text-3xl font-bold text-blue-700 mb-2">💡 WHY RELEVANT ?</h4>
            <p id="modalAlasan" class="text-gray-800 leading-relaxed text-sm md:text-xl">
                (Alasan Relevansi akan muncul di sini)
            </p>
        </div>

        <div class="text-center">
            <button onclick="closeTrainingModal()" class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold px-4 md:px-6 py-2 rounded-full shadow-md hover:shadow-lg transition text-sm md:text-base">
                Close
            </button>
        </div>
    </div>
</div>

<script>
function showTrainingFromDropdown() {
    var dropdown = document.getElementById('trainingDropdown');
    var selectedOption = dropdown.options[dropdown.selectedIndex];

    if (dropdown.selectedIndex > 0) {
        showTrainingDetail(
            selectedOption.getAttribute('data-nama'),
            selectedOption.getAttribute('data-deskripsi'),
            selectedOption.getAttribute('data-relevansi'),
            selectedOption.getAttribute('data-alasan')
        );
    }
}

function showTrainingDetail(nama, deskripsi, relevansi, alasan) {
    document.getElementById('modalNamaPelatihan').innerText = nama;
    document.getElementById('modalDeskripsiPelatihan').innerText = deskripsi;
    document.getElementById('modalRelevansi').innerText = relevansi;
    document.getElementById('modalAlasan').innerText = alasan;
    document.getElementById('trainingModal').classList.remove('hidden');
}

function closeTrainingModal() {
    document.getElementById('trainingModal').classList.add('hidden');
    document.getElementById('trainingDropdown').selectedIndex = 0;
}

function loadRecommendations(idPegawai) {
    fetch(`/recommendations/${idPegawai}`)
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById('recommendationContent');
            container.innerHTML = '';

            if (data.length === 0) {
                container.innerHTML = '<p class="text-gray-600 text-center">Tidak ada rekomendasi pelatihan.</p>';
            } else {
                data.forEach(item => {
                    const block = `
                    <div class="bg-white rounded-xl p-5 shadow-md border border-blue-100 mb-4">
                        <p class="text-xl md:text-2xl font-bold text-gray-500 mb-1">JENIS REKOMENDASI :</p>
                        <p class="text-2xl md:text-4xl font-extrabold text-blue-700 mb-2">${item.nama_recommendasi}</p>
                        <div>
                            <br>
                            <p class="text-xl md:text-2xl font-bold text-gray-500 mb-1"> NAMA PROGRAM :</p>
                            <p class="text-base md:text-xl text-gray-800 leading-tight whitespace-pre-line">${formatProgramText(item.nama_program)}</p>
                        </div>
                    </div>`;
                    container.innerHTML += block;
                });
            }

            document.getElementById('recommendationModal').classList.remove('hidden');
        });
}

function closeRecommendationModal() {
    document.getElementById('recommendationModal').classList.add('hidden');
}

function formatProgramText(text) {
    return text.replace(/(\d+\.\s)/g, '$1');
}
</script>

@endsection