<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Division;
use App\Models\Deputy;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Total keseluruhan
        $totalPegawai = Employee::count();
        $totalDivisi  = Division::count();
        $totalDeputi  = Deputy::count();

        // Pegawai yang bergabung di bulan & tahun berjalan
        $pegawaiBaruBulanIni = Employee::whereMonth('tanggal_bergabung', now()->month)
            ->whereYear('tanggal_bergabung', now()->year)
            ->count();

        // Distribusi jumlah pegawai per level (untuk donut chart)
        $levelChartData = [
            'JUNIOR'       => Employee::where('level', 'JUNIOR')->count(),
            'PRACTICIONER' => Employee::where('level', 'PRACTICIONER')->count(),
            'PROFESIONAL'  => Employee::where('level', 'PROFESIONAL')->count(),
            'EXPERT'       => Employee::where('level', 'EXPERT')->count(),
        ];

        // 5 pegawai yang paling baru bergabung
        $recentEmployees = Employee::latest('tanggal_bergabung')->take(5)->get();

        return view('admin.dashboard', compact(
            'totalPegawai',
            'totalDivisi',
            'totalDeputi',
            'pegawaiBaruBulanIni',
            'levelChartData',
            'recentEmployees'
        ));
    }

    public function daftarPegawai()
    {
        return redirect()->route('admin.employees.index');
    }
}