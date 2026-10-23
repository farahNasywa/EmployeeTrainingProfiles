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

.badge-relevansi {
    font-size: 12px; font-weight: 700; padding: 5px 12px; border-radius: 20px;
    white-space: nowrap; display: inline-block;
}
.badge-low    { background: rgba(220, 53, 69, 0.1); color: #dc3545; }
.badge-medium { background: rgba(245, 166, 35, 0.1); color: #e08e0b; }
.badge-high   { background: rgba(15, 157, 88, 0.1); color: #0f9d58; }

.alasan-text {
    font-size: 13px; color: #6c757d; max-width: 260px;
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

<h1>Employee Training List</h1>

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
    <a href="#" data-bs-toggle="modal" data-bs-target="#addEmployeeTrainingModal" class="btn-add">
        <i class="bi bi-plus-lg"></i> Add Data
    </a>
</div>

<table class="table mt-2">
    <thead>
        <tr>
            <th>No</th>
            <th>Employee</th>
            <th>Training</th>
            <th>Weight</th>
            <th>Relevance</th>
            <th>Reason</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse($employeeTrainings as $item)
            <tr>
                <td class="text-center">
                    <span class="row-number-badge">
                        {{ $employeeTrainings->firstItem() + $loop->index }}
                    </span>
                </td>
                <td class="fw-semibold">{{ $item->employee->nama ?? 'N/A' }}</td>
                <td>{{ $item->training->nama_pelatihan ?? 'N/A' }}</td>
                <td>{{ $item->bobot ?? '-' }}</td>
                <td>
                    @php
                        $badgeClass = match($item->tingkat_relevansi) {
                            'Low' => 'badge-low',
                            'Medium' => 'badge-medium',
                            'High' => 'badge-high',
                            default => 'badge-low',
                        };
                    @endphp
                    <span class="badge-relevansi {{ $badgeClass }}">{{ $item->tingkat_relevansi }}</span>
                </td>
                <td>
                    <span class="alasan-text" title="{{ $item->alasan_relevansi }}">
                        {{ $item->alasan_relevansi ?: '-' }}
                    </span>
                </td>
                <td>
                    <button type="button"
                            class="btn btn-warning btn-sm action-btn"
                            data-bs-toggle="modal"
                            data-bs-target="#editETModal{{ $item->id_pegawai }}_{{ $item->id_pelatihan }}">
                        <i class="bi bi-pencil-square"></i> Edit
                    </button>

                    <form action="{{ route('admin.employee-trainings.destroy', [$item->id_pegawai, $item->id_pelatihan]) }}"
                          method="POST" style="display:inline;"
                          onsubmit="return confirm('Are you sure you want to delete this data?');">
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
                <td colspan="7" class="text-center text-muted py-4">No employee training data yet.</td>
            </tr>
        @endforelse
    </tbody>
</table>

{{ $employeeTrainings->links() }}

<!--begin::Add Modal-->
<div class="modal fade" id="addEmployeeTrainingModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content shadow border-0" style="border-radius:15px;">
            <form action="{{ route('admin.employee-trainings.store') }}" method="POST">
                @csrf
                <div class="modal-header-custom border-0">
                    <h5 class="modal-title mb-0 fw-bold">
                        <i class="bi bi-person-plus-fill me-2"></i>Add Employee Training
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
                        <label>Training</label>
                        <select class="form-control" name="id_pelatihan" required>
                            <option value="">SELECT TRAINING</option>
                            @foreach($trainings as $training)
                                <option value="{{ $training->id_pelatihan }}">{{ $training->nama_pelatihan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mt-3">
                        <label>Weight</label>
                        <input type="number" step="0.01" class="form-control" name="bobot">
                    </div>
                    <div class="form-group mt-3">
                        <label>Relevance Level</label>
                        <select class="form-control" name="tingkat_relevansi" required>
                            <option value="Low">Low</option>
                            <option value="Medium">Medium</option>
                            <option value="High">High</option>
                        </select>
                    </div>
                    <div class="form-group mt-3">
                        <label>Relevance Reason</label>
                        <textarea class="form-control" name="alasan_relevansi" rows="3"></textarea>
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

<!--begin::Edit Modal (one per row)-->
@foreach($employeeTrainings as $item)
    <div class="modal fade" id="editETModal{{ $item->id_pegawai }}_{{ $item->id_pelatihan }}" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content shadow border-0" style="border-radius:15px;">
                <form action="{{ route('admin.employee-trainings.update', [$item->id_pegawai, $item->id_pelatihan]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header-custom border-0">
                        <h5 class="modal-title mb-0 fw-bold">
                            <i class="bi bi-pencil-square me-2"></i>Edit Employee Training
                        </h5>
                        <button type="button" class="modal-close-btn" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                    </div>
                    <div class="modal-body px-4 py-4">
                        <div class="form-group">
                            <label>Employee</label>
                            <input type="text" class="form-control" value="{{ $item->employee->nama ?? 'N/A' }}" readonly>
                        </div>
                        <div class="form-group mt-3">
                            <label>Training</label>
                            <input type="text" class="form-control" value="{{ $item->training->nama_pelatihan ?? 'N/A' }}" readonly>
                        </div>
                        <div class="form-group mt-3">
                            <label>Weight</label>
                            <input type="number" step="0.01" class="form-control" name="bobot" value="{{ $item->bobot }}">
                        </div>
                        <div class="form-group mt-3">
                            <label>Relevance Level</label>
                            <select class="form-control" name="tingkat_relevansi" required>
                                <option value="Low" {{ $item->tingkat_relevansi == 'Low' ? 'selected' : '' }}>Low</option>
                                <option value="Medium" {{ $item->tingkat_relevansi == 'Medium' ? 'selected' : '' }}>Medium</option>
                                <option value="High" {{ $item->tingkat_relevansi == 'High' ? 'selected' : '' }}>High</option>
                            </select>
                        </div>
                        <div class="form-group mt-3">
                            <label>Relevance Reason</label>
                            <textarea class="form-control" name="alasan_relevansi" rows="3">{{ $item->alasan_relevansi }}</textarea>
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