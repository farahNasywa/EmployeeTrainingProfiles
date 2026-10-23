<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Training;
use App\Models\EmployeeTraining;
use Illuminate\Http\Request;

class EmployeeTrainingController extends Controller
{
    public function index()
    {
        $employeeTrainings = EmployeeTraining::with(['employee', 'training'])
            ->orderByDesc('id_pegawai')
            ->paginate(10);

        $employees = Employee::orderBy('nama')->get();
        $trainings = Training::orderBy('nama_pelatihan')->get();

        return view('admin.employee-trainings.index', compact('employeeTrainings', 'employees', 'trainings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_pegawai'        => 'required|exists:Employees,id_pegawai',
            'id_pelatihan'      => 'required|exists:Trainings,id_pelatihan',
            'bobot'             => 'nullable|numeric',
            'tingkat_relevansi' => 'required|in:Low,Medium,High',
            'alasan_relevansi'  => 'nullable|string',
        ]);

        // Cegah duplikat kombinasi pegawai + pelatihan yang sama
        $exists = EmployeeTraining::where('id_pegawai', $request->id_pegawai)
            ->where('id_pelatihan', $request->id_pelatihan)
            ->exists();

        if ($exists) {
            return redirect()
                ->route('admin.employee-trainings.index')
                ->with('error', 'Pegawai ini sudah tercatat mengikuti pelatihan tersebut.');
        }

        EmployeeTraining::create([
            'id_pegawai'        => $request->id_pegawai,
            'id_pelatihan'      => $request->id_pelatihan,
            'bobot'             => $request->bobot,
            'tingkat_relevansi' => $request->tingkat_relevansi,
            'alasan_relevansi'  => $request->alasan_relevansi,
        ]);

        return redirect()
            ->route('admin.employee-trainings.index')
            ->with('success', 'Data pelatihan pegawai berhasil ditambahkan.');
    }

    public function update(Request $request, $id_pegawai, $id_pelatihan)
    {
        $request->validate([
            'bobot'             => 'nullable|numeric',
            'tingkat_relevansi' => 'required|in:Low,Medium,High',
            'alasan_relevansi'  => 'nullable|string',
        ]);

        EmployeeTraining::where('id_pegawai', $id_pegawai)
            ->where('id_pelatihan', $id_pelatihan)
            ->firstOrFail();

        EmployeeTraining::where('id_pegawai', $id_pegawai)
            ->where('id_pelatihan', $id_pelatihan)
            ->update([
                'bobot'             => $request->bobot,
                'tingkat_relevansi' => $request->tingkat_relevansi,
                'alasan_relevansi'  => $request->alasan_relevansi,
            ]);

        return redirect()
            ->route('admin.employee-trainings.index')
            ->with('success', 'Data pelatihan pegawai berhasil diperbarui.');
    }

    public function destroy($id_pegawai, $id_pelatihan)
    {
        EmployeeTraining::where('id_pegawai', $id_pegawai)
            ->where('id_pelatihan', $id_pelatihan)
            ->delete();

        return redirect()
            ->route('admin.employee-trainings.index')
            ->with('success', 'Data pelatihan pegawai berhasil dihapus.');
    }
}