<?php

namespace App\Http\Controllers;

use App\Models\Training;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class TrainingController extends Controller
{
    public function index()
    {
        $trainings = Training::with(['category', 'subcategory'])
            ->orderBy('nama_pelatihan')
            ->paginate(10);

        $categories = Category::orderBy('nama_kategori')->get();
        $subcategories = Subcategory::orderBy('nama_subkategori')->get();

        return view('admin.trainings.index', compact('trainings', 'categories', 'subcategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pelatihan'      => 'required|string|max:255',
            'deskripsi_pelatihan' => 'nullable|string',
            'id_kategori'         => 'required|exists:Categories,id_kategori',
            'id_subkategori'      => 'nullable|exists:Subcategories,id_subkategori',
        ]);

        $training = new Training();
        $training->nama_pelatihan      = $request->nama_pelatihan;
        $training->deskripsi_pelatihan = $request->deskripsi_pelatihan;
        $training->id_kategori         = $request->id_kategori;
        $training->id_subkategori      = $request->id_subkategori;
        $training->save();

        return redirect()
            ->route('admin.trainings.index')
            ->with('success', 'Pelatihan berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_pelatihan'      => 'required|string|max:255',
            'deskripsi_pelatihan' => 'nullable|string',
            'id_kategori'         => 'required|exists:Categories,id_kategori',
            'id_subkategori'      => 'nullable|exists:Subcategories,id_subkategori',
        ]);

        $training = Training::findOrFail($id);
        $training->nama_pelatihan      = $request->nama_pelatihan;
        $training->deskripsi_pelatihan = $request->deskripsi_pelatihan;
        $training->id_kategori         = $request->id_kategori;
        $training->id_subkategori      = $request->id_subkategori;
        $training->save();

        return redirect()
            ->route('admin.trainings.index')
            ->with('success', 'Pelatihan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $training = Training::findOrFail($id);

        if ($training->employees()->exists()) {
            return redirect()
                ->route('admin.trainings.index')
                ->with('error', 'Pelatihan tidak bisa dihapus karena masih diikuti oleh pegawai.');
        }

        $training->delete();

        return redirect()
            ->route('admin.trainings.index')
            ->with('success', 'Pelatihan berhasil dihapus.');
    }
}