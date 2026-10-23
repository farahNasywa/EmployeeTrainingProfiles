<?php

namespace App\Http\Controllers;

use App\Models\RecommendationType;
use Illuminate\Http\Request;

class RecommendationTypeController extends Controller
{
    public function index()
    {
        $recommendationTypes = RecommendationType::withCount('trainingRecommendations')
            ->orderBy('nama_rekomendasi')
            ->paginate(10);

        return view('admin.recommendation-types.index', compact('recommendationTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_rekomendasi' => 'required|string|max:255',
        ]);

        $type = new RecommendationType();
        $type->nama_rekomendasi = $request->nama_rekomendasi;
        $type->save();

        return redirect()
            ->route('admin.recommendation-types.index')
            ->with('success', 'Jenis rekomendasi berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_rekomendasi' => 'required|string|max:255',
        ]);

        $type = RecommendationType::findOrFail($id);
        $type->nama_rekomendasi = $request->nama_rekomendasi;
        $type->save();

        return redirect()
            ->route('admin.recommendation-types.index')
            ->with('success', 'Jenis rekomendasi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $type = RecommendationType::findOrFail($id);

        if ($type->trainingRecommendations()->exists()) {
            return redirect()
                ->route('admin.recommendation-types.index')
                ->with('error', 'Jenis rekomendasi tidak bisa dihapus karena masih dipakai di data rekomendasi pegawai.');
        }

        $type->delete();

        return redirect()
            ->route('admin.recommendation-types.index')
            ->with('success', 'Jenis rekomendasi berhasil dihapus.');
    }
}