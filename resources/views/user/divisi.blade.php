@extends('layout.master2')
@section('content1')

    <div class="header-wrapper">
        @if(request()->get('ref') == 'beranda')
        <a href="/user/dashboard" class="backbutton">
            <svg fill="#003e5e" width="55px" height="55px" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg">
                <path d="M222.927 580.115l301.354 328.512c24.354 28.708 20.825 71.724-7.883 96.078s-71.724 20.825-96.078-7.883L19.576 559.963a67.846 67.846 0 01-13.784-20.022 68.03 68.03 0 01-5.977-29.488l.001-.063a68.343 68.343 0 017.265-29.134 68.28 68.28 0 011.384-2.6 67.59 67.59 0 0110.102-13.687L429.966 21.113c25.592-27.611 68.721-29.247 96.331-3.656s29.247 68.721 3.656 96.331L224.088 443.784h730.46c37.647 0 68.166 30.519 68.166 68.166s-30.519 68.166-68.166 68.166H222.927z"/>
              </svg>
        </a>
    @else
        <a href="/user/strukturorganisasi" class="backbutton">
            <svg fill="#003e5e" width="55px" height="55px" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg">
                <path d="M222.927 580.115l301.354 328.512c24.354 28.708 20.825 71.724-7.883 96.078s-71.724 20.825-96.078-7.883L19.576 559.963a67.846 67.846 0 01-13.784-20.022 68.03 68.03 0 01-5.977-29.488l.001-.063a68.343 68.343 0 017.265-29.134 68.28 68.28 0 011.384-2.6 67.59 67.59 0 0110.102-13.687L429.966 21.113c25.592-27.611 68.721-29.247 96.331-3.656s29.247 68.721 3.656 96.331L224.088 443.784h730.46c37.647 0 68.166 30.519 68.166 68.166s-30.519 68.166-68.166 68.166H222.927z"/>
              </svg>
        </a>
    @endif
    <div class="divisi">
        {{ $division->nama_divisi }}

        @if($employees->isEmpty())
            <span> (Tidak ada pegawai)</span>
        @endif
    </div>
</div>
  
    <table class="table-auto w-full border-collapse border border-gray-300 shadow-lg mt-4">
        <thead class="bg-gray-200 text-gray-700">
            <tr>
                <th class="px-6 py-3 text-left text-sm font-semibold">No</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">Nama</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">Jabatan</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">Number of Training</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">Relevance</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">Level</th>
            </tr>
        </thead>
        <tbody class="bg-white">
            @foreach ($employees as $employee)
    <tr class="hover:bg-gray-100 cursor-pointer" onclick="window.location.href='/user/divisi/{{ $employee->id_pegawai }}';">
        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $loop->iteration }}</td>
        <td class="px-6 py-4 text-sm text-gray-700">{{ $employee->nama }}</td>
        <td class="px-6 py-4 text-sm text-gray-700">{{ strtoupper($employee->bidang) }}</td>
        <td class="px-6 py-4 text-sm text-gray-700">
            {{ $employee->trainings()->count() }}  {{-- Menghitung jumlah pelatihan --}}
        </td>
        <td class="px-6 py-4 text-sm text-gray-700">
            @switch($employee->level)
                @case('JUNIOR') LOW @break
                @case('PRACTICIONER') MEDIUM @break
                @case('PROFESIONAL') HIGH @break
                @case('EXPERT') HIGHEST @break
                @default ...
            @endswitch
        </td>
        <td class="px-6 py-4 text-sm text-gray-700">{{ $employee->level }}</td>
    </tr>
@endforeach
        </tbody>
    </table>

@endsection
