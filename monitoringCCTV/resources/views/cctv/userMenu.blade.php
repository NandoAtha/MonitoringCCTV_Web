@extends('layouts.admin')

@section('title', 'User Management')

@section('content')

<div class="bg-dark vh-100 d-flex flex-column">

    <div class="container-fluid flex-grow-1 mt-4">
        <div class="row h-100">

            {{-- Main content --}}
            <div class="col-lg-8 mx-auto mb-4">
                <div class="card bg-dark-subtle h-100 border-secondary text-white">
                    <div class="card-header bg-secondary">
                        <h5 class="mb-0 fw-semibold"><i class="fas fa-user-edit me-2 mr-1"></i>Manajemen Role & Permission</h5>
                    </div>
                    <div class="card-body">
                        {{-- === Manajemen Role & Permission === --}}
                        {{-- Form Tambah Role --}}
                        <form action="{{ route('roles.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label>Nama Role</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label>Pilih Permission:</label><br>
                                @foreach($permissions as $permission)
                                <label>
                                    <input type="checkbox" name="permissions[]" value="{{ $permission->_id }}">
                                    {{ $permission->name }}
                                </label><br>
                                @endforeach
                            </div>

                            <button type="submit" class="btn btn-primary">Tambah Role</button>
                        </form>

                        <hr class="border-secondary">

                        {{-- List Role --}}
                        <h3 class="text-white">Daftar Role</h3>
                        <table class="table table-dark table-bordered">
                            <thead>
                                <tr>
                                    <th>Nama Role</th>
                                    <th>Permissions</th>
                                    <th style="width: 200px;">Aksi</th> {{-- Tambah kolom --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($roles as $role)
                                <tr>
                                    <td>{{ $role->name }}</td>
                                    <td>
                                        @foreach($role->permissions as $perm)
                                        <span class="badge bg-success">{{ $perm->name }}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        {{-- Tombol Edit --}}
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editRoleModal{{ $role->_id }}">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>

                                        {{-- Tombol Delete --}}
                                        <form action="{{ route('roles.update', $role->_id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus role ini?')">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                {{-- Modal Edit Role --}}
                                <div class="modal fade" id="editRoleModal{{ $role->_id }}" tabindex="-1" aria-labelledby="editRoleLabel{{ $role->_id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form action="{{ route('roles.update', $role->_id) }}" method="POST">
                                            @csrf
                                            {{-- Jika pakai update dengan PUT --}}
                                            @method('POST')
                                            <div class="modal-content bg-dark text-white">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editRoleLabel{{ $role->_id }}">Edit Role</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label>Nama Role</label>
                                                        <input type="text" name="name" class="form-control" value="{{ $role->name }}" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label>Pilih Permission:</label><br>
                                                        @php
                                                            $rolePermissionIds = $role->permissions->pluck('_id')->toArray();
                                                        @endphp

                                                        @foreach($permissions as $permission)
                                                        <label>
                                                            <input type="checkbox" name="permissions[]" value="{{ $permission->_id }}"
                                                                {{ in_array($permission->_id, $rolePermissionIds) ? 'checked' : '' }}>
                                                            {{ $permission->name }}
                                                        </label><br>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Styles --}}
<style>
    :root {
        --primary-color: #0d6efd;
    }

    .bg-dark-subtle {
        background-color: #2c3034;
    }

    .border-secondary {
        border-color: #495057 !important;
    }

    .nav-item {
        transition: all 0.3s ease;
        border-radius: 8px;
        position: relative;
    }

    .nav-item:hover {
        background-color: rgba(255, 255, 255, 0.1);
    }

    .nav-item.active {
        background-color: rgba(13, 110, 253, 0.15);
    }

    .active-indicator {
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 40px;
        height: 3px;
        background: var(--primary-color);
        border-radius: 2px;
    }

    .list-group-item-action.bg-dark:hover {
        background-color: #343a40 !important;
    }

    .nav-tabs-dark .nav-link {
        color: #adb5bd;
        border-color: transparent;
        border-bottom-color: #495057;
    }

    .nav-tabs-dark .nav-link:hover {
        border-color: #495057;
        isolation: isolate;
    }

    .nav-tabs-dark .nav-link.active {
        color: #fff;
        background-color: #343a40;
        border-color: #495057 #495057 #343a40;
        font-weight: 600;
    }
</style>
@endsection