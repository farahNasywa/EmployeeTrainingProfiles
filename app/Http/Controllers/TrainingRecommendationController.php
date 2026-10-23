<?php

namespace App\Http\Controllers;

use App\Models\TrainingRecommendation;
use App\Models\RecommendationType;
use App\Models\Employee;
use Illuminate\Http\Request;

class TrainingRecommendationController extends Controller
{
    public function index()
    {
        $recommendations = TrainingRecommendation::with(['employee', 'recommendationType'])
            ->orderByDesc('id_rekomendasi')
            ->paginate(10);

        $employees = Employee::orderBy('nama')->get();
        $recommendationTypes = RecommendationType::orderBy('nama_rekomendasi')->get();

        return view('admin.training-recommendations.index', compact(
            'recommendations', 'employees', 'recommendationTypes'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_pegawai'          => 'required|exists:Employees,id_pegawai',
            'id_jenis_rekomendasi'=> 'required|exists:Recommendations_type,id_jenis_rekomendasi',
            'nama_program'        => 'required|string|max:255',
        ]);

        $rec = new TrainingRecommendation();
        $rec->id_pegawai           = $request->id_pegawai;
        $rec->id_jenis_rekomendasi = $request->id_jenis_rekomendasi;
        $rec->nama_program         = $request->nama_program;
        $rec->save();

        return redirect()
            ->route('admin.training-recommendations.index')
            ->with('success', 'Rekomendasi pegawai berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_pegawai'          => 'required|exists:Employees,id_pegawai',
            'id_jenis_rekomendasi'=> 'required|exists:Recommendations_type,id_jenis_rekomendasi',
            'nama_program'        => 'required|string|max:255',
        ]);

        $rec = TrainingRecommendation::findOrFail($id);
        $rec->id_pegawai           = $request->id_pegawai;
        $rec->id_jenis_rekomendasi = $request->id_jenis_rekomendasi;
        $rec->nama_program         = $request->nama_program;
        $rec->save();

        return redirect()
            ->route('admin.training-recommendations.index')
            ->with('success', 'Rekomendasi pegawai berhasil diperbarui.');
    }

    public function destroy($id)
    {
        TrainingRecommendation::findOrFail($id)->delete();

        return redirect()
            ->route('admin.training-recommendations.index')
            ->with('success', 'Rekomendasi pegawai berhasil dihapus.');
    }
}