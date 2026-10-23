<?php

namespace App\Http\Controllers;

use App\Models\Deputy;
use App\Models\Category;
use App\Models\Division;
use App\Models\Employee;
use App\Models\Training;
use Illuminate\Http\Request;
use App\Models\EmployeeTraining;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    // =====================
    // Dashboard Methods (from HomeController)
    // =====================

    /**
     * Nama deputi yang di-exclude dari list "Deputies" biasa di dashboard,
     * karena posisi ini adalah jabatan puncak (Kepala/Wakil Kepala BPMA),
     * bukan deputi struktural. Sesuaikan array ini kalau ada penambahan/
     * perubahan nama di masa depan.
     */
    private const EXCLUDED_DEPUTY_NAMES = ['HEAD OF BPMA', 'DEPUTY HEAD'];

    public function dashboard()
    {
        $deputies = Deputy::whereNotIn('nama_deputi', self::EXCLUDED_DEPUTY_NAMES)
            ->get(['id_deputi', 'nama_deputi']);

        $totalDeputy = Deputy::whereNotIn('nama_deputi', self::EXCLUDED_DEPUTY_NAMES)
            ->count();

        // Baris divisi yang kode_divisi-nya NULL adalah jabatan puncak
        // (Head of the Agency / Deputy Head), bukan divisi kerja asli.
        $divisions = Division::whereNotNull('kode_divisi')->get(['id_divisi', 'nama_divisi']);
        $totalDivision = Division::whereNotNull('kode_divisi')->count();

        $totalEmployees = Employee::count();

        // Fetch categories from the database
        $categories = Category::all();

        // Optionally, you can map the categories to include icon paths
        $categories = $categories->map(function ($category) {
            $category->icon = asset('icons/category-' . $category->id_kategori . '.png');
            return $category;
        });

        // Get Training Relevance Data
        $relevanceData = $this->getTrainingRelevanceData();

        // Get Division Training Data for Bar Chart
        $divisionTrainingData = $this->getDashboardChartData();

        // Get Division Relevance Data for Line Chart
        $divisionRelevanceData = $this->getDivisionRelevanceData();

        return view('user.dashboard', compact(
            'deputies',
            'totalDeputy',
            'totalDivision',
            'divisions',
            'totalEmployees',
            'categories',
            'relevanceData',
            'divisionTrainingData',
            'divisionRelevanceData'
        ));
    }

    public function getCategoryDetails($id_kategori)
    {
        // Mendapatkan kategori berdasarkan id_kategori
        $category = Category::find($id_kategori);

        // Mendapatkan subkategori berdasarkan id_kategori
        $subcategories = DB::table('Subcategories')
            ->where('id_kategori', $id_kategori)
            ->get();

        // Menghitung jumlah pegawai yang mengikuti pelatihan pada kategori ini
        $totalEmployeesInCategory = DB::table('Employees_training')
            ->join('Trainings', 'Employees_training.id_pelatihan', '=', 'Trainings.id_pelatihan')
            ->where('Trainings.id_kategori', $id_kategori)
            ->count();

        return response()->json([
            'category' => $category,
            'subcategories' => $subcategories,
            'totalEmployees' => $totalEmployeesInCategory
        ]);
    }

    // Function to calculate training relevance percentages
    private function getTrainingRelevanceData()
    {
        $totalTrainings = EmployeeTraining::count();

        // Count relevancies based on level
        $lowCount = EmployeeTraining::where('tingkat_relevansi', 'Low')->count();
        $mediumCount = EmployeeTraining::where('tingkat_relevansi', 'Medium')->count();
        $highCount = EmployeeTraining::where('tingkat_relevansi', 'High')->count();

        // Calculate percentage
        $lowPercentage = $totalTrainings > 0 ? ($lowCount / $totalTrainings) * 100 : 0;
        $mediumPercentage = $totalTrainings > 0 ? ($mediumCount / $totalTrainings) * 100 : 0;
        $highPercentage = $totalTrainings > 0 ? ($highCount / $totalTrainings) * 100 : 0;

        return [
            'low' => $lowPercentage,
            'medium' => $mediumPercentage,
            'high' => $highPercentage
        ];
    }

    // Modified UserController.php code for the chart data
    public function getDashboardChartData()
    {
        // Hanya ambil divisi kerja asli (yang punya kode_divisi).
        // Baris seperti "Head of the Agency" / "Deputy Head of the Agency"
        // punya kode_divisi NULL karena bukan divisi struktural, jadi
        // di-exclude dari chart.
        $divisions = Division::whereNotNull('kode_divisi')
            ->orderBy('nama_divisi')
            ->get(['id_divisi', 'nama_divisi', 'kode_divisi']);

        $trainingCounts = [];
        $divisionNames = [];
        $originalNames = [];
        $divisionIds = []; // Array to store division IDs for navigation

        foreach ($divisions as $division) {
            // Count trainings attended by employees in this division
            $count = DB::table('Employees_training')
                ->join('Employees', 'Employees_training.id_pegawai', '=', 'Employees.id_pegawai')
                ->where('Employees.id_divisi', $division->id_divisi)
                ->count();

            // Gunakan kode divisi dari database
            $divisionNames[] = $division->kode_divisi;

            // Store original name for tooltip
            $originalNames[] = $this->capitalizeEachWord($division->nama_divisi);

            // Store division ID for navigation
            $divisionIds[] = $division->id_divisi;

            $trainingCounts[] = $count;
        }

        return [
            'divisions' => $divisionNames,
            'trainingCounts' => $trainingCounts,
            'originalNames' => $originalNames,
            'divisionIds' => $divisionIds // Include division IDs in the response
        ];
    }

    // Function to get training relevance data for each division
    private function getDivisionRelevanceData()
    {
        // Hanya ambil divisi kerja asli (yang punya kode_divisi).
        // Baris seperti "Head of the Agency" / "Deputy Head of the Agency"
        // punya kode_divisi NULL karena bukan divisi struktural, jadi
        // di-exclude dari chart.
        $divisions = Division::whereNotNull('kode_divisi')
            ->orderBy('nama_divisi')
            ->get(['id_divisi', 'nama_divisi', 'kode_divisi']);

        $divisionNames = [];
        $originalNames = [];
        $lowRelevance = [];
        $mediumRelevance = [];
        $highRelevance = [];
        $lowCounts = [];
        $mediumCounts = [];
        $highCounts = [];

        foreach ($divisions as $division) {
            // Gunakan kode divisi dari database
            $divisionNames[] = $division->kode_divisi;

            // Store original name for tooltip
            $originalNames[] = $this->capitalizeEachWord($division->nama_divisi);

            // Count trainings by relevance for this division
            $lowCount = DB::table('Employees_training')
                ->join('Employees', 'Employees_training.id_pegawai', '=', 'Employees.id_pegawai')
                ->where('Employees.id_divisi', $division->id_divisi)
                ->where('Employees_training.tingkat_relevansi', 'Low')
                ->count();

            $mediumCount = DB::table('Employees_training')
                ->join('Employees', 'Employees_training.id_pegawai', '=', 'Employees.id_pegawai')
                ->where('Employees.id_divisi', $division->id_divisi)
                ->where('Employees_training.tingkat_relevansi', 'Medium')
                ->count();

            $highCount = DB::table('Employees_training')
                ->join('Employees', 'Employees_training.id_pegawai', '=', 'Employees.id_pegawai')
                ->where('Employees.id_divisi', $division->id_divisi)
                ->where('Employees_training.tingkat_relevansi', 'High')
                ->count();

            // Store the counts for tooltips
            $lowCounts[] = $lowCount;
            $mediumCounts[] = $mediumCount;
            $highCounts[] = $highCount;

            // Store the relevance counts
            $lowRelevance[] = $lowCount;
            $mediumRelevance[] = $mediumCount;
            $highRelevance[] = $highCount;
        }

        return [
            'divisions' => $divisionNames,
            'originalNames' => $originalNames,
            'lowRelevance' => $lowRelevance,
            'mediumRelevance' => $mediumRelevance,
            'highRelevance' => $highRelevance,
            'lowCounts' => $lowCounts,
            'mediumCounts' => $mediumCounts,
            'highCounts' => $highCounts
        ];
    }

    // =====================
    // Employee Methods (from EmployeeController)
    // =====================

    public function showEmployeeDetail($id_pegawai)
    {
        $employee = Employee::with(['trainings' => function ($query) {
            $query->withPivot(['tingkat_relevansi', 'alasan_relevansi']);
        }])->findOrFail($id_pegawai);

        return view('/user/card', compact('employee'));
    }

    public function getRecommendations($id_pegawai)
    {
        $employee = Employee::with('trainingRecommendations.recommendationType')
                            ->findOrFail($id_pegawai);

        $data = $employee->trainingRecommendations->map(function ($rec) {
            return [
                'nama_program' => $rec->nama_program,
                'nama_recommendasi' => $rec->recommendationType->nama_rekomendasi
            ];
        });

        return response()->json($data);
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        $results = Employee::with(['division.deputy']) // pastikan relasi lengkap
                    ->where('nama', 'like', '%' . $keyword . '%')
                    ->orWhere('id_pegawai', 'like', '%' . $keyword . '%')
                    ->get();

        return view('/user/search', [
            'keyword' => $keyword,
            'results' => $results
        ]);
    }

    // =====================
    // Division Methods (from DivisionController)
    // =====================

    public function showDivision($id_divisi)
    {
        $division = Division::findOrFail($id_divisi); // ambil data divisi berdasarkan ID
        $employees = Employee::where('id_divisi', $id_divisi)->get(); // ambil semua pegawai dari divisi itu
        return view('/user/divisi', compact('division', 'employees')); // kirim ke view
    }

    // =====================
    // Deputy Methods (from EmployeeController)
    // =====================

    public function showDeputy($id_deputi)
    {
        $deputi = Deputy::with('divisions')->findOrFail($id_deputi);
        $divisions = $deputi->divisions;
        $employees = Employee::where('id_deputi', $id_deputi)->get();

        // Urutkan pegawai sehingga yang tidak memiliki divisi muncul di atas
        $employees = $employees->sortBy(function ($employee) {
            return $employee->division ? 1 : 0; // Pegawai tanpa divisi diberi nilai 0 (urutan pertama)
        });

        return view('/user/deputi', compact('deputi', 'divisions', 'employees'));
    }

    public function showAllDeputies()
    {
        // Ambil semua data deputi beserta relasi trainings dari employees
        $deputiestraining = Deputy::with(['divisions.employees.trainings'])
            ->get()
            ->map(function ($deputi) {
                // Total pegawai
                $employees = $deputi->divisions->flatMap->employees;
                $totalEmployees = $employees->count();

                // Hitung jumlah pegawai dengan pelatihan
                $employeesWithTraining = $employees->filter(fn($emp) => $emp->trainings->isNotEmpty())->count();

                // Persentase pegawai yang telah mengikuti pelatihan
                $percentage = $totalEmployees > 0 ? ($employeesWithTraining / $totalEmployees) * 100 : 0;

                // Skor relevansi berdasarkan level pegawai
                $relevansiScores = $employees->map(function ($emp) {
                    return match ($emp->level) {
                        'JUNIOR' => 1,
                        'PRACTICIONER' => 2,
                        'PROFESIONAL' => 3,
                        'EXPERT' => 4,
                        default => 0
                    };
                });

                // Total skor relevansi
                $totalRelevansiScore = $relevansiScores->sum();
                $maxRelevansiScore = $totalEmployees * 4;
                $relevancePercentage = $maxRelevansiScore > 0 ? round(($totalRelevansiScore / $maxRelevansiScore) * 100, 2) : 0;

                return [
                    'id_deputi' => $deputi->id_deputi,
                    'nama_deputi' => $deputi->nama_deputi,
                    'persentase_training' => round($percentage, 2),
                    'log_persentase' => $percentage > 0 ? round(log10($percentage), 4) : 0,
                    'tingkat_relevansi' => $relevancePercentage
                ];
            });

        // Perhitungan tambahan: ambil semua divisi dengan training kategori
        $divisionsWithRelevance = Division::with(['employees.trainings.category'])
            ->get()
            ->map(function ($division) {
                $totalRelevansiScore = 0;
                $categories = collect();

                foreach ($division->employees as $employee) {
                    foreach ($employee->trainings as $training) {
                        // Ambil nama kategori
                        if ($training->category) {
                            $categories->push($training->category->nama_kategori);

                            // Hitung skor kategori (opsional bisa custom per kategori)
                            $score = match ($training->category->nama_kategori) {
                                default => 1
                            };
                            $totalRelevansiScore += $score;
                        }
                    }
                }

                $maxScore = $division->employees->count() * $totalRelevansiScore;
                $percentageScore = $maxScore > 0 ? round(($totalRelevansiScore / $maxScore) * 100, 2) : 0;

                return [
                    'id_divisi' => $division->id_divisi,
                    'nama_divisi' => $division->nama_divisi,
                    'kategori_pelatihan' => $categories->unique()->values(),
                    'total_relevansi_score' => $totalRelevansiScore,
                    'persentase_relevansi' => $percentageScore
                ];
            });

        $relevansiByKategori = DB::table('Trainings')
            ->join('Categories', 'Trainings.id_kategori', '=', 'Categories.id_kategori')
            ->join('Employees_training', 'Trainings.id_pelatihan', '=', 'Employees_training.id_pelatihan')
            ->join('Employees', 'Employees_training.id_pegawai', '=', 'Employees.id_pegawai')
            ->join('Divisions', 'Employees.id_divisi', '=', 'Divisions.id_divisi')
            ->join('Deputies', 'Divisions.id_deputi', '=', 'Deputies.id_deputi')
            ->select(
                'Deputies.id_deputi',
                'Employees_training.tingkat_relevansi',
                'Trainings.nama_pelatihan',
                'Categories.nama_kategori'
            )
            ->distinct()
            ->get()
            ->groupBy(['id_deputi', 'tingkat_relevansi']);

        $formattedRelevansi = [];

        foreach ($relevansiByKategori as $id_deputi => $relevansiGroup) {
            $formattedRelevansi[$id_deputi] = [
                'Low' => $relevansiGroup->get('Low', collect())->unique('nama_kategori')->map(fn($item) => [
                    'nama_kategori' => $this->sentenceCase($item->nama_kategori ?? 'No category'),
                    'tingkat_relevansi' => $item->tingkat_relevansi,
                ]),
                'Medium' => $relevansiGroup->get('Medium', collect())->unique('nama_kategori')->map(fn($item) => [
                    'nama_kategori' => $this->sentenceCase($item->nama_kategori ?? 'No category'),
                    'tingkat_relevansi' => $item->tingkat_relevansi,
                ]),
                'High' => $relevansiGroup->get('High', collect())->unique('nama_kategori')->map(fn($item) => [
                    'nama_kategori' => $this->sentenceCase($item->nama_kategori ?? 'No category'),
                    'tingkat_relevansi' => $item->tingkat_relevansi,
                ]),
            ];
        }

        // Kepala Sekretariat BPMA — dicari lewat id_pegawai langsung
        // (id_pegawai 231508823, sesuai baris "BPMA SECRETARIAT" di
        // tabel Deputies), karena posisi ini tidak mengikuti pola
        // "HEAD OF THE DEPUTY FOR..." seperti 4 kepala deputi lainnya.
        $kepaladeputi1 = Employee::find(231508823);

        // Kepala Deputi 2-5 — dicari lewat id_deputi (stabil, tidak
        // tergantung bahasa/redaksi teks kolom bidang), dikombinasikan
        // dengan pola bidang untuk memastikan yang terambil memang
        // posisi kepala, bukan pegawai biasa di deputi tersebut.
        $kepaladeputi2 = Employee::where('id_deputi', 2)
            ->where('bidang', 'like', 'HEAD OF THE DEPUTY%')
            ->first();
        $kepaladeputi3 = Employee::where('id_deputi', 3)
            ->where('bidang', 'like', 'HEAD OF THE DEPUTY%')
            ->first();
        $kepaladeputi4 = Employee::where('id_deputi', 4)
            ->where('bidang', 'like', 'HEAD OF THE DEPUTY%')
            ->first();
        $kepaladeputi5 = Employee::where('id_deputi', 5)
            ->where('bidang', 'like', 'HEAD OF THE DEPUTY%')
            ->first();

        // Data untuk view
        return view('/user/strukturorganisasi', [
            'deputiestraining' => $deputiestraining,
            'deputies' => Deputy::with('divisions')->get(),
            'divisions' => Division::with('employees')->get(),
            'divisionsWithRelevance' => $divisionsWithRelevance,
            'deputi' => Deputy::with('divisions.employees')->get(),
            'formattedRelevansi' => $formattedRelevansi,
            'kepaladeputi1' => $kepaladeputi1,
            'kepaladeputi2' => $kepaladeputi2,
            'kepaladeputi3' => $kepaladeputi3,
            'kepaladeputi4' => $kepaladeputi4,
            'kepaladeputi5' => $kepaladeputi5
        ]);
    }

    // =====================
    // Helper Methods
    // =====================

    // Function to capitalize each word in a string
    public function capitalizeEachWord($string)
    {
        return ucwords(strtolower($string));
    }

    // Function for sentence case formatting
    public function sentenceCase($string)
    {
        return ucfirst(strtolower($string));
    }
}