@extends('layout.master')

@section('content')

<style>
.btn-add {
    background: #0F3387; color: #fff !important; border: none; border-radius: 8px;
    padding: 8px 14px; font-size: 14px; font-weight: 500; text-decoration: none !important;
    display: inline-flex !important; align-items: center; justify-content: center;
    width: fit-content !important; gap: 6px; margin-bottom: 15px; transition: 0.3s;
}
.btn-add:hover { background: #1b4ab8; color: #fff !important; }

.action-btn {
    border-radius: 8px; padding: 5px 12px; margin-right: 6px; font-size: 13px;
    transition: all 0.3s ease;
}
.action-btn:hover { transform: translateY(-2px); box-shadow: 0 3px 10px rgba(0,0,0,0.15); }

.row-number-badge {
    display: inline-flex; align-items: center; justify-content: center;
    width: 28px; height: 28px; border-radius: 50%;
    background: rgba(15, 51, 135, 0.1); color: #0F3387; font-weight: 600; font-size: 13px;
}

.jenis-badge {
    display: inline-flex; align-items: center; gap: 6px;
    background: rgba(106, 62, 193, 0.1); color: #6a3ec1;
    font-weight: 600; font-size: 12px; padding: 4px 10px; border-radius: 20px;
}

.program-text {
    font-size: 13px; max-width: 280px;
    display: block; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
}

.table {
    border-collapse: separate; border-spacing: 0; background: #fff;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05); border-radius: 10px; overflow: hidden;
}
.table thead th {
    background: #0F3387; color: #fff; font-weight: 500; font-size: 13px;
    text-transform: uppercase; letter-spacing: 0.3px; vertical-align: middle; border: none;
}
.table thead th:first-child { border-radius: 10px 0 0 10px; text-align: center; width: 60px; }
.table thead th:last-child { border-radius: 0 10px 10px 0; }
.table tbody tr:hover { background: rgba(15, 51, 135, 0.03); }
.table tbody td { vertical-align: middle; }
.table tbody tr:not(:last-child) td { border-bottom: 1px solid #eef0f4; }
.table tbody td:not(:last-child) { border-right: 1px solid #eef0f4; }

.modal-header-custom {
    background: #0F3387; color: white; border-radius: 15px 15px 0 0; padding: 18px 24px;
    display: flex; align-items: center; justify-content: space-between;
}
.modal-close-btn {
    background: rgba(255,255,255,0.15); border: none; color: white;
    width: 34px; height: 34px; border-radius: 50%; font-size: 20px;
    display: flex; align-items: center; justify-content: center; transition: all 0.3s ease;
}
.modal-close-btn:hover { background: rgba(255,255,255,0.25); transform: rotate(90deg); color: white; }
</style>

<h1>Employee Recommendation List</h1>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div>
    <a href="#" data-bs-toggle="modal" data-bs-target="#addRecModal" class="btn-add">
        <i class="bi bi-plus-lg"></i> Add Recommendation
    </a>
</div>

<table class="table mt-2">
    <thead>
        <tr>
            <th>No</th>
            <th>Employee</th>
            <th>Program Name</th>
            <th>Recommendation Type</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse($recommendations as $rec)
            <tr>
                <td class="text-center">
                    <span class="row-number-badge">
                        {{ $recommendations->firstItem() + $loop->index }}
                    </span>
                </td>
                <td class="fw-semibold">{{ $rec->employee->nama ?? 'N/A' }}</td>
                <td>
                    <span class="program-text" title="{{ $rec->nama_program }}">
                        {{ $rec->nama_program }}
                    </span>
                </td>
                <td>
                    <span class="jenis-badge">
                        <i class="bi bi-tree-fill"></i> {{ $rec->recommendationType->nama_rekomendasi ?? 'N/A' }}
                    </span>
                </td>
                <td>
                    <button type="button"
                            class="btn btn-warning btn-sm action-btn"
                            data-bs-toggle="modal"
                            data-bs-target="#editRecModal{{ $rec->id_rekomendasi }}">
                        <i class="bi bi-pencil-square"></i> Edit
                    </button>

                    <form action="{{ route('admin.training-recommendations.destroy', $rec->id_rekomendasi) }}"
                          method="POST" style="display:inline;"
                          onsubmit="return confirm('Are you sure you want to delete this recommendation?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm action-btn">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center text-muted py-4">No employee recommendation data yet.</td>
            </tr>
        @endforelse
    </tbody>
</table>

{{ $recommendations->links() }}

<!--begin::Add Modal-->
<div class="modal fade" id="addRecModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content shadow border-0" style="border-radius:15px;">
            <form action="{{ route('admin.training-recommendations.store') }}" method="POST">
                @csrf
                <div class="modal-header-custom border-0">
                    <h5 class="modal-title mb-0 fw-bold">
                        <i class="bi bi-tree-fill me-2"></i>Add Employee Recommendation
                    </h5>
                    <button type="button" class="modal-close-btn" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                </div>
                <div class="modal-body px-4 py-4">
                    <div class="form-group">
                        <label>Employee</label>
                        <select class="form-control" name="id_pegawai" required>
                            <option value="">SELECT EMPLOYEE</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id_pegawai }}">{{ $employee->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mt-3">
                        <label>Program Name</label>
                        <input type="text" class="form-control" name="nama_program" required>
                    </div>
                    <div class="form-group mt-3">
                        <label>Recommendation Type</label>
                        <select class="form-control" name="id_jenis_rekomendasi" required>
                            <option value="">SELECT RECOMMENDATION TYPE</option>
                            @foreach($recommendationTypes as $type)
                                <option value="{{ $type->id_jenis_rekomendasi }}">{{ $type->nama_rekomendasi }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn" style="background:#0F3387;color:white;">
                        <i class="bi bi-save"></i> Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end::Add Modal-->

<!--begin::Edit Modal-->
@foreach($recommendations as $rec)
    <div class="modal fade" id="editRecModal{{ $rec->id_rekomendasi }}" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content shadow border-0" style="border-radius:15px;">
                <form action="{{ route('admin.training-recommendations.update', $rec->id_rekomendasi) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header-custom border-0">
                        <h5 class="modal-title mb-0 fw-bold">
                            <i class="bi bi-pencil-square me-2"></i>Edit Employee Recommendation
                        </h5>
                        <button type="button" class="modal-close-btn" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                    </div>
                    <div class="modal-body px-4 py-4">
                        <div class="form-group">
                            <label>Employee</label>
                            <select class="form-control" name="id_pegawai" required>
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->id_pegawai }}"
                                        {{ $rec->id_pegawai == $employee->id_pegawai ? 'selected' : '' }}>
                                        {{ $employee->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mt-3">
                            <label>Program Name</label>
                            <input type="text" class="form-control" name="nama_program"
                                   value="{{ $rec->nama_program }}" required>
                        </div>
                        <div class="form-group mt-3">
                            <label>Recommendation Type</label>
                            <select class="form-control" name="id_jenis_rekomendasi" required>
                                @foreach($recommendationTypes as $type)
                                    <option value="{{ $type->id_jenis_rekomendasi }}"
                                        {{ $rec->id_jenis_rekomendasi == $type->id_jenis_rekomendasi ? 'selected' : '' }}>
                                        {{ $type->nama_rekomendasi }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn" style="background:#0F3387;color:white;">
                            <i class="bi bi-save"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
<!--end::Edit Modal-->

@endsection