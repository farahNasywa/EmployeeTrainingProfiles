<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Deputy;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    /**
     * Tampilkan daftar divisi beserta deputi induk & jumlah pegawainya.
     */
    public function index()
    {
        $divisions = Division::with('deputy')
            ->withCount('employees')
            ->orderBy('nama_divisi')
            ->paginate(10);

        $deputies = Deputy::orderBy('nama_deputi')->get();

        return view('admin.divisions.index', compact('divisions', 'deputies'));
    }

    /**
     * Simpan divisi baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_divisi' => 'required|string|max:255',
            'id_deputi'   => 'required|exists:Deputies,id_deputi',
        ]);

        $division = new Division();
        $division->nama_divisi = $request->nama_divisi;
        $division->id_deputi   = $request->id_deputi;
        $division->save();

        return redirect()
            ->route('admin.divisions.index')
            ->with('success', 'Divisi berhasil ditambahkan.');
    }

    /**
     * Perbarui data divisi.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_divisi' => 'required|string|max:255',
            'id_deputi'   => 'required|exists:Deputies,id_deputi',
        ]);

        $division = Division::findOrFail($id);
        $division->nama_divisi = $request->nama_divisi;
        $division->id_deputi   = $request->id_deputi;
        $division->save();

        return redirect()
            ->route('admin.divisions.index')
            ->with('success', 'Divisi berhasil diperbarui.');
    }

    /**
     * Hapus divisi.
     */
    public function destroy($id)
    {
        $division = Division::findOrFail($id);

        if ($division->employees()->exists()) {
            return redirect()
                ->route('admin.divisions.index')
                ->with('error', 'Divisi tidak bisa dihapus karena masih memiliki pegawai terkait.');
        }

        $division->delete();

        return redirect()
            ->route('admin.divisions.index')
            ->with('success', 'Divisi berhasil dihapus.');
    }
}