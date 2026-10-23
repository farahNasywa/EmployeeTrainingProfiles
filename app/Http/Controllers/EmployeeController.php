<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Division;
use App\Models\Deputy;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    // Menampilkan daftar pegawai dengan pagination
    public function index()
    {
        $employees = Employee::with('division', 'deputy') 
            ->paginate(10);
        $divisions = Division::all(); 
        $deputies = Deputy::all(); 

        return view('admin.daftarpegawai', compact('employees', 'divisions', 'deputies'));
    }

    // Menyimpan data pegawai baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'bidang' => 'required|string|max:100',
            'level' => 'required|in:JUNIOR,PRACTICIONER,PROFESIONAL,EXPERT',
            'tanggal_bergabung' => 'required|date',
            'id_divisi' => 'nullable|exists:Divisions,id_divisi',
            'id_deputi' => 'nullable|exists:Deputies,id_deputi',
            'Roles' => 'nullable|string|max:100',
        ]);

        Employee::create($request->all());

        return back()->with('success', 'Pegawai berhasil ditambahkan');
    }

    // Menampilkan form edit pegawai
    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        $divisions = Division::all();
        $deputies = Deputy::all();

        return view('admin.employees.modal_edit', compact('employee', 'divisions', 'deputies'));
    }

    // Memperbarui data pegawai
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:100',
            'bidang' => 'required|string|max:100',
            'level' => 'required|in:JUNIOR,PRACTICIONER,PROFESIONAL,EXPERT',
            'tanggal_bergabung' => 'required|date',
            'id_divisi' => 'nullable|exists:Divisions,id_divisi',
            'id_deputi' => 'nullable|exists:Deputies,id_deputi',
            'Roles' => 'nullable|string|max:100',
        ]);

        // Mencari pegawai berdasarkan ID
        $employee = Employee::findOrFail($id);

        // Memperbarui data pegawai
        $employee->update($request->all());

        // Redirect kembali ke daftar pegawai dengan pesan sukses
        return redirect()->route('admin.employees.index')->with('success', 'Pegawai berhasil diperbarui');
    }

    // Menghapus data pegawai
    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        return back()->with('success', 'Pegawai berhasil dihapus');
    }
}
