<?php

namespace App\Http\Controllers;

use App\Models\Subcategory;
use App\Models\Category;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    public function index()
    {
        $subcategories = Subcategory::with('category')
            ->orderBy('nama_subkategori')
            ->paginate(10);

        $categories = Category::orderBy('nama_kategori')->get();

        return view('admin.subcategories.index', compact('subcategories', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_subkategori' => 'required|string|max:255',
            'id_kategori'      => 'required|exists:Categories,id_kategori',
        ]);

        $subcategory = new Subcategory();
        $subcategory->nama_subkategori = $request->nama_subkategori;
        $subcategory->id_kategori      = $request->id_kategori;
        $subcategory->save();

        return redirect()
            ->route('admin.subcategories.index')
            ->with('success', 'SubKategori berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_subkategori' => 'required|string|max:255',
            'id_kategori'      => 'required|exists:Categories,id_kategori',
        ]);

        $subcategory = Subcategory::findOrFail($id);
        $subcategory->nama_subkategori = $request->nama_subkategori;
        $subcategory->id_kategori      = $request->id_kategori;
        $subcategory->save();

        return redirect()
            ->route('admin.subcategories.index')
            ->with('success', 'SubKategori berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $subcategory = Subcategory::findOrFail($id);

        // Cegah hapus subkategori yang masih dipakai oleh pelatihan
        $usedByTraining = \App\Models\Training::where('id_subkategori', $id)->exists();

        if ($usedByTraining) {
            return redirect()
                ->route('admin.subcategories.index')
                ->with('error', 'SubKategori tidak bisa dihapus karena masih dipakai oleh data pelatihan.');
        }

        $subcategory->delete();

        return redirect()
            ->route('admin.subcategories.index')
            ->with('success', 'SubKategori berhasil dihapus.');
    }
}