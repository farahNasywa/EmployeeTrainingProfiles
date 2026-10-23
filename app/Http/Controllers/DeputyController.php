<?php

namespace App\Http\Controllers;

use App\Models\Deputy;
use Illuminate\Http\Request;

class DeputyController extends Controller
{
    /**
     * Tampilkan daftar deputi beserta jumlah divisi & pegawai di bawahnya.
     */
    public function index()
    {
        $deputies = Deputy::withCount(['divisions', 'employees'])
            ->orderBy('nama_deputi')
            ->paginate(10);

        return view('admin.deputies.index', compact('deputies'));
    }

    /**
     * Simpan deputi baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_deputi' => 'required|string|max:255',
        ]);

        $deputy = new Deputy();
        $deputy->nama_deputi = $request->nama_deputi;
        $deputy->save();

        return redirect()
            ->route('admin.deputies.index')
            ->with('success', 'Deputi berhasil ditambahkan.');
    }

    /**
     * Perbarui data deputi.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_deputi' => 'required|string|max:255',
        ]);

        $deputy = Deputy::findOrFail($id);
        $deputy->nama_deputi = $request->nama_deputi;
        $deputy->save();

        return redirect()
            ->route('admin.deputies.index')
            ->with('success', 'Deputi berhasil diperbarui.');
    }

    /**
     * Hapus deputi.
     */
    public function destroy($id)
    {
        $deputy = Deputy::findOrFail($id);

        // Cegah hapus deputi yang masih punya divisi/pegawai, biar data tidak yatim piatu.
        if ($deputy->divisions()->exists() || $deputy->employees()->exists()) {
            return redirect()
                ->route('admin.deputies.index')
                ->with('error', 'Deputi tidak bisa dihapus karena masih memiliki divisi atau pegawai terkait.');
        }

        $deputy->delete();

        return redirect()
            ->route('admin.deputies.index')
            ->with('success', 'Deputi berhasil dihapus.');
    }
}