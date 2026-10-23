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

.user-avatar {
    width: 36px; height: 36px; border-radius: 50%;
    background: rgba(15, 51, 135, 0.1); color: #0F3387;
    display: inline-flex; align-items: center; justify-content: center;
    font-weight: 700; font-size: 14px; margin-right: 10px;
}

.role-badge-admin {
    display: inline-flex; align-items: center; gap: 5px;
    background: rgba(15, 51, 135, 0.1); color: #0F3387;
    font-weight: 700; font-size: 12px; padding: 4px 12px; border-radius: 20px;
}

.role-badge-user {
    display: inline-flex; align-items: center; gap: 5px;
    background: rgba(15, 157, 88, 0.1); color: #0f9d58;
    font-weight: 700; font-size: 12px; padding: 4px 12px; border-radius: 20px;
}

.me-badge {
    display: inline-flex; align-items: center; gap: 5px;
    background: rgba(245, 166, 35, 0.12); color: #e08e0b;
    font-weight: 600; font-size: 11px; padding: 2px 8px; border-radius: 20px;
    margin-left: 6px;
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

.password-hint {
    font-size: 12px; color: #8a90a2; margin-top: 4px;
}
</style>

<h1>User List</h1>

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
@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Failed to save:</strong>
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
<div>
    <a href="#" data-bs-toggle="modal" data-bs-target="#addUserModal" class="btn-add">
        <i class="bi bi-person-plus-fill"></i> Add User
    </a>
</div>

<table class="table mt-2">
    <thead>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Registered</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($users as $user)
            <tr>
                <td class="text-center">
                    <span class="row-number-badge">
                        {{ $users->firstItem() + $loop->index }}
                    </span>
                </td>
                <td>
                    <div style="display:flex; align-items:center;">
                        <span class="user-avatar">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </span>
                        <div>
                            <div class="fw-semibold" style="font-size:14px;">
                                {{ $user->name }}
                                @if(auth()->id() == $user->id)
                                    <span class="me-badge"><i class="bi bi-person-fill"></i> You</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </td>
                <td style="font-size:13px; color:#6c757d;">{{ $user->email }}</td>
                <td>
                    @if($user->role === 'admin')
                        <span class="role-badge-admin">
                            <i class="bi bi-shield-fill"></i> Admin
                        </span>
                    @else
                        <span class="role-badge-user">
                            <i class="bi bi-person-fill"></i> User
                        </span>
                    @endif
                </td>
                <td style="font-size:13px; color:#6c757d;">
                    {{ \Carbon\Carbon::parse($user->created_at)->format('d M Y') }}
                </td>
                <td>
                    <button type="button"
                            class="btn btn-warning btn-sm action-btn"
                            data-bs-toggle="modal"
                            data-bs-target="#editUserModal{{ $user->id }}">
                        <i class="bi bi-pencil-square"></i> Edit
                    </button>

                    @if(auth()->id() != $user->id)
                        <form action="{{ route('admin.users.destroy', $user->id) }}"
                              method="POST" style="display:inline;"
                              onsubmit="return confirm('Are you sure you want to delete user {{ $user->name }}?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm action-btn">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </form>
                    @else
                        {{-- Delete button disabled for own account --}}
                        <button class="btn btn-secondary btn-sm action-btn" disabled title="Cannot delete your own account">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center text-muted py-4">No user data yet.</td>
            </tr>
        @endforelse
    </tbody>
</table>

{{ $users->links() }}

<!--begin::Add User Modal-->
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content shadow border-0" style="border-radius:15px;">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="modal-header-custom border-0">
                    <h5 class="modal-title mb-0 fw-bold">
                        <i class="bi bi-person-plus-fill me-2"></i>Add User
                    </h5>
                    <button type="button" class="modal-close-btn" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                </div>
                <div class="modal-body px-4 py-4">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="form-group mt-3">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="form-group mt-3">
                        <label>Role</label>
                        <select class="form-control" name="role" required>
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                        </select>
                    </div>
                    <div class="form-group mt-3">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <div class="form-group mt-3">
                        <label>Confirm Password</label>
                        <input type="password" class="form-control" name="password_confirmation" required>
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
<!--end::Add User Modal-->

<!--begin::Edit User Modal-->
@foreach($users as $user)
    <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content shadow border-0" style="border-radius:15px;">
                <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header-custom border-0">
                        <h5 class="modal-title mb-0 fw-bold">
                            <i class="bi bi-pencil-square me-2"></i>Edit User
                        </h5>
                        <button type="button" class="modal-close-btn" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                    </div>
                    <div class="modal-body px-4 py-4">
                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" class="form-control" name="name"
                                   value="{{ $user->name }}" required>
                        </div>
                        <div class="form-group mt-3">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email"
                                   value="{{ $user->email }}" required>
                        </div>
                        <div class="form-group mt-3">
                            <label>Role</label>
                            <select class="form-control" name="role" required>
                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                            </select>
                        </div>
                        <div class="form-group mt-3">
                            <label>New Password <small class="text-muted">(leave blank if you don't want to change it)</small></label>
                            <input type="password" class="form-control" name="password">
                            <p class="password-hint">Minimum 8 characters. Leave blank if you don't want to change the password.</p>
                        </div>
                        <div class="form-group mt-3">
                            <label>Confirm New Password</label>
                            <input type="password" class="form-control" name="password_confirmation">
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
<!--end::Edit User Modal-->

@endsection