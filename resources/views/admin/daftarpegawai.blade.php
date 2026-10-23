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
    border-radius: 8px; padding: 5px 10px; margin-right: 4px; font-size: 12px;
    transition: all 0.3s ease; white-space: nowrap;
}
.action-btn:hover { transform: translateY(-2px); box-shadow: 0 3px 10px rgba(0,0,0,0.15); }

.row-number-badge {
    display: inline-flex; align-items: center; justify-content: center;
    width: 26px; height: 26px; border-radius: 50%;
    background: rgba(15, 51, 135, 0.1); color: #0F3387; font-weight: 600; font-size: 12px;
}

/* Horizontal scroll wrapper for mobile responsiveness */
.table-wrap {
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.table {
    border-collapse: separate; border-spacing: 0; background: #fff;
    border-radius: 10px; overflow: hidden;
    font-size: 12.5px;
    min-width: 900px; /* so it can scroll on mobile, fits fine on desktop */
    margin-bottom: 0;
    box-shadow: none; /* shadow already on .table-wrap */
}
.table thead th {
    background: #0F3387; color: #fff; font-weight: 500; font-size: 11.5px;
    text-transform: uppercase; letter-spacing: 0.3px; vertical-align: middle; border: none;
    white-space: nowrap; padding: 10px 8px;
}
.table thead th:first-child { border-radius: 10px 0 0 10px; text-align: center; width: 50px; }
.table thead th:last-child { border-radius: 0 10px 10px 0; }
.table thead th:not(:last-child) { border-right: 1px solid rgba(255,255,255,0.15); }
.table tbody tr:hover { background: rgba(15, 51, 135, 0.03); }
.table tbody td { vertical-align: top; padding: 8px; }
.table tbody tr:not(:last-child) td { border-bottom: 1px solid #eef0f4; }
.table tbody td:not(:last-child) { border-right: 1px solid #eef0f4; }

/* Field & Division columns: wrap down, not truncated */
.cell-wrap {
    white-space: normal;
    word-break: break-word;
    min-width: 180px;
    max-width: 260px;
    line-height: 1.4;
}

/* Action column: buttons stack vertically if they don't fit */
.aksi-wrap {
    display: flex;
    flex-direction: column;
    gap: 4px;
    min-width: 80px;
}

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
.modal-close-btn:focus { outline: none; box-shadow: none; }

/* Mobile responsiveness */
@media (max-width: 767.98px) {
    /*
        FIX: previously ".modal-content" had "min-height: 100vh" which
        CONFLICTED with Bootstrap's internal "modal-dialog-scrollable"
        mechanism (it needs MAX-height, not MIN-height, so the modal-body
        can scroll on its own while the header & footer/Save button stay
        fixed in place). Since min-height > max-height, the browser always
        favors min-height, forcing the modal to render at full length with
        no cap -> the footer/Save button gets pushed off-screen and can't
        be scrolled to.

        Fix: ".modal-dialog" is given height:100% (so Bootstrap's
        percentage-based max-height calculation has a fixed reference),
        and ".modal-content" no longer has a min-height.
    */
    .modal-dialog { margin: 0; max-width: 100%; height: 100%; }
    .modal-content { border-radius: 0 !important; max-height: 100%; }
    .modal-header-custom { border-radius: 0 !important; padding: 14px 16px; }
    .modal-body { padding: 16px; }
    h1 { font-size: 1.35rem !important; }

    /* Hide the table, show the card layout */
    .table-wrap { display: none; }

    /* Card layout for each employee row */
    .card-list { display: flex; flex-direction: column; gap: 12px; }

    .pegawai-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.07);
        padding: 14px 16px;
    }

    .pegawai-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 10px;
    }

    .pegawai-card-name {
        font-weight: 700;
        font-size: 14px;
        color: #212529;
    }

    .pegawai-card-id {
        font-size: 11px;
        color: #8a90a2;
        margin-top: 2px;
    }

    .pegawai-card-body {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px 12px;
        font-size: 12.5px;
    }

    .pegawai-card-item label {
        font-size: 10.5px;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        color: #8a90a2;
        font-weight: 600;
        display: block;
        margin-bottom: 2px;
    }

    .pegawai-card-item span {
        color: #212529;
        font-weight: 500;
        word-break: break-word;
    }

    .pegawai-card-footer {
        display: flex;
        gap: 8px;
        margin-top: 12px;
        padding-top: 10px;
        border-top: 1px solid #eef0f4;
    }

    .pegawai-card-footer .btn {
        flex: 1;
        font-size: 12px;
        padding: 6px 10px;
        border-radius: 8px;
    }
}

/* Desktop: hide the card list */
@media (min-width: 768px) {
    .card-list { display: none; }
}
</style>

<h1>Employee List</h1>

<div>
    <a href="#"
       data-bs-toggle="modal"
       data-bs-target="#addEmployeeModal"
       class="btn-add">
        <i class="bi bi-plus-lg"></i> Add Employee
    </a>
</div>

<div class="table-wrap mt-2">
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Employee ID</th>
                <th>Name</th>
                <th>Field</th>
                <th>Level</th>
                <th>Join Date</th>
                <th>Division</th>
                <th>Deputy</th>
                <th>Roles</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($employees as $employee)
                <tr>
                    <td class="text-center" style="vertical-align:middle;">
                        <span class="row-number-badge">
                            {{ $employees->firstItem() + $loop->index }}
                        </span>
                    </td>
                    <td style="vertical-align:middle;">{{ $employee->id_pegawai }}</td>
                    <td class="fw-semibold" style="vertical-align:middle; white-space:nowrap;">
                        {{ $employee->nama }}
                    </td>
                    <td>
                        {{-- Wrap down, not truncated --}}
                        <span class="cell-wrap">{{ $employee->bidang ?: '-' }}</span>
                    </td>
                    <td style="vertical-align:middle; white-space:nowrap;">
                        {{ $employee->level ?: '-' }}
                    </td>
                    <td style="vertical-align:middle; white-space:nowrap;">
                        {{ \Carbon\Carbon::parse($employee->tanggal_bergabung)->format('Y-m-d') }}
                    </td>
                    <td>
                        {{-- Wrap down, not truncated --}}
                        <span class="cell-wrap">
                            {{ $employee->division ? $employee->division->nama_divisi : 'N/A' }}
                        </span>
                    </td>
                    <td style="vertical-align:middle; white-space:nowrap;">
                        {{ $employee->deputy ? $employee->deputy->nama_deputi : 'N/A' }}
                    </td>
                    <td style="vertical-align:middle;">{{ $employee->Roles ?: '-' }}</td>
                    <td style="vertical-align:middle;">
                        <div class="aksi-wrap">
                            <button type="button"
                                class="btn btn-warning btn-sm action-btn"
                                data-bs-toggle="modal"
                                data-bs-target="#editEmployeeModal{{ $employee->id_pegawai }}">
                                <i class="bi bi-pencil-square"></i> Edit
                            </button>

                            <form action="{{ route('admin.employees.destroy', $employee->id_pegawai) }}"
                                  method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm action-btn w-100"
                                        onclick="return confirm('Are you sure you want to delete this employee?')">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="mt-3">
    {{ $employees->links() }}
</div>

<!-- Card layout for mobile (hidden on desktop) -->
<div class="card-list mt-2">
    @foreach($employees as $employee)
        <div class="pegawai-card">
            <div class="pegawai-card-header">
                <div>
                    <div class="pegawai-card-name">{{ $employee->nama }}</div>
                    <div class="pegawai-card-id">ID: {{ $employee->id_pegawai }}</div>
                </div>
                <span class="row-number-badge">
                    {{ $employees->firstItem() + $loop->index }}
                </span>
            </div>

            <div class="pegawai-card-body">
                <div class="pegawai-card-item">
                    <label>Field</label>
                    <span>{{ $employee->bidang ?: '-' }}</span>
                </div>
                <div class="pegawai-card-item">
                    <label>Level</label>
                    <span>{{ $employee->level ?: '-' }}</span>
                </div>
                <div class="pegawai-card-item">
                    <label>Join Date</label>
                    <span>{{ \Carbon\Carbon::parse($employee->tanggal_bergabung)->format('d M Y') }}</span>
                </div>
                <div class="pegawai-card-item">
                    <label>Roles</label>
                    <span>{{ $employee->Roles ?: '-' }}</span>
                </div>
                <div class="pegawai-card-item" style="grid-column: span 2;">
                    <label>Division</label>
                    <span>{{ $employee->division ? $employee->division->nama_divisi : 'N/A' }}</span>
                </div>
                <div class="pegawai-card-item" style="grid-column: span 2;">
                    <label>Deputy</label>
                    <span>{{ $employee->deputy ? $employee->deputy->nama_deputi : 'N/A' }}</span>
                </div>
            </div>

            <div class="pegawai-card-footer">
                <button type="button"
                    class="btn btn-warning btn-sm"
                    data-bs-toggle="modal"
                    data-bs-target="#editEmployeeModal{{ $employee->id_pegawai }}">
                    <i class="bi bi-pencil-square"></i> Edit
                </button>

                <form action="{{ route('admin.employees.destroy', $employee->id_pegawai) }}"
                      method="POST" style="flex:1;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm w-100"
                            onclick="return confirm('Are you sure you want to delete this employee?')">
                        <i class="bi bi-trash"></i> Delete
                    </button>
                </form>
            </div>
        </div>
    @endforeach
</div>

<!-- Modal for adding an employee -->
@include('admin.employees.modal_add')

<!-- Employee edit modal -->
@foreach($employees as $employee)
    <div class="modal fade"
         id="editEmployeeModal{{ $employee->id_pegawai }}"
         tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content shadow border-0" style="border-radius:15px;">
                <form action="{{ route('admin.employees.update', $employee->id_pegawai) }}"
                      method="POST">
                    @csrf
                    @method('PUT')

                    <div class="modal-header-custom border-0">
                        <h5 class="modal-title mb-0 fw-bold">
                            <i class="bi bi-person-fill me-2"></i>Edit Employee
                        </h5>
                        <button type="button" class="modal-close-btn"
                                data-bs-dismiss="modal" aria-label="Close">&times;</button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label>Employee ID</label>
                            <input type="number" class="form-control" name="id_pegawai"
                                   value="{{ $employee->id_pegawai }}" readonly>
                        </div>
                        <div class="form-group mt-3">
                            <label>Name</label>
                            <input type="text" class="form-control" name="nama"
                                   value="{{ $employee->nama }}">
                        </div>
                        <div class="form-group mt-3">
                            <label>Field</label>
                            <input type="text" class="form-control" name="bidang"
                                   value="{{ $employee->bidang }}">
                        </div>
                        <div class="form-group mt-3">
                            <label>Level</label>
                            <select class="form-control" name="level">
                                <option value="JUNIOR"        {{ $employee->level=='JUNIOR'        ? 'selected':'' }}>JUNIOR</option>
                                <option value="PRACTICIONER"  {{ $employee->level=='PRACTICIONER'  ? 'selected':'' }}>PRACTICIONER</option>
                                <option value="PROFESIONAL"   {{ $employee->level=='PROFESIONAL'   ? 'selected':'' }}>PROFESIONAL</option>
                                <option value="EXPERT"        {{ $employee->level=='EXPERT'        ? 'selected':'' }}>EXPERT</option>
                            </select>
                        </div>
                        <div class="form-group mt-3">
                            <label>Join Date</label>
                            <input type="date" class="form-control" name="tanggal_bergabung"
                                   value="{{ \Carbon\Carbon::parse($employee->tanggal_bergabung)->format('Y-m-d') }}">
                        </div>
                        <div class="form-group mt-3">
                            <label>Division</label>
                            <select class="form-control" name="id_divisi">
                                @foreach($divisions as $division)
                                    <option value="{{ $division->id_divisi }}"
                                        {{ $employee->id_divisi == $division->id_divisi ? 'selected' : '' }}>
                                        {{ $division->nama_divisi }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mt-3">
                            <label>Deputy</label>
                            <select class="form-control" name="id_deputi">
                                @foreach($deputies as $deputy)
                                    <option value="{{ $deputy->id_deputi }}"
                                        {{ $employee->id_deputi == $deputy->id_deputi ? 'selected' : '' }}>
                                        {{ $deputy->nama_deputi }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mt-3">
                            <label>Roles</label>
                            <input type="text" class="form-control" name="Roles"
                                   value="{{ $employee->Roles }}">
                        </div>
                    </div>

                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn" style="background:#0F3387;color:white;">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

<script>
    // ============================================================
    // FORCE-FIX mobile modal: forces styles via JS + !important,
    // to GUARANTEE it wins against any CSS overriding it
    // (AdminLTE, cache, etc). The Cancel/Save buttons and the
    // scrollable form area are always guaranteed correct, whatever
    // the source of the conflict.
    // Landscape/desktop (>=768px) is NOT touched at all.
    // ============================================================
    (function () {
        function fixModalMobileLayout(modalEl) {
            // No longer checks window.innerWidth, and no longer forces
            // height:100vh / border-radius:0 (so desktop stays as usual -
            // a centered modal card with rounded corners).
            // What's fixed is ONLY the internal flex+scroll mechanism,
            // which is safe to apply at any screen size.

            var dialog = modalEl.querySelector('.modal-dialog');
            var content = modalEl.querySelector('.modal-content');
            var formEl = modalEl.querySelector('.modal-content > form');
            var body = modalEl.querySelector('.modal-body');
            var header = modalEl.querySelector('.modal-header, .modal-header-custom');
            var footer = modalEl.querySelector('.modal-footer');

            if (dialog) {
                dialog.style.setProperty('display', 'flex', 'important');
                dialog.style.setProperty('flex-direction', 'column', 'important');
                // height is left to Bootstrap's own control (modal-dialog-scrollable)
            }
            if (content) {
                content.style.setProperty('max-height', '100%', 'important');
                content.style.setProperty('display', 'flex', 'important');
                content.style.setProperty('flex-direction', 'column', 'important');
                content.style.setProperty('overflow', 'hidden', 'important');
            }
            // IMPORTANT: <form> wraps header+body+footer, so IT must be
            // the flex container - not just modal-content alone.
            // Without this, "flex:1" and "overflow-y:auto" on modal-body
            // would NEVER have any effect (this is the actual root cause).
            if (formEl) {
                formEl.style.setProperty('display', 'flex', 'important');
                formEl.style.setProperty('flex-direction', 'column', 'important');
                formEl.style.setProperty('overflow', 'hidden', 'important');
                formEl.style.setProperty('max-height', '100%', 'important');
                formEl.style.setProperty('min-height', '0', 'important');
            }
            if (body) {
                body.style.setProperty('overflow-y', 'auto', 'important');
                body.style.setProperty('flex', '1 1 auto', 'important');
                body.style.setProperty('min-height', '0', 'important');
            }
            if (header) header.style.setProperty('flex-shrink', '0', 'important');
            if (footer) footer.style.setProperty('flex-shrink', '0', 'important');
        }

        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.modal').forEach(function (modalEl) {
                // Applied IMMEDIATELY on page load (no need to wait for
                // the modal to open) - avoids possible failure due to
                // 'shown.bs.modal' event timing not being caught in time.
                fixModalMobileLayout(modalEl);

                // Re-applied every time the modal opens, as a double
                // safeguard (in case some other script resets styles in between).
                modalEl.addEventListener('shown.bs.modal', function () {
                    fixModalMobileLayout(modalEl);
                });
                modalEl.addEventListener('show.bs.modal', function () {
                    fixModalMobileLayout(modalEl);
                });
            });
        });

        // In case mobile orientation changes while the modal is still open
        window.addEventListener('resize', function () {
            var openModal = document.querySelector('.modal.show');
            if (openModal) fixModalMobileLayout(openModal);
        });
    })();
</script>

@endsection