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
                        <h5 class="mb-0 fw-semibold"><i class="fas fa-users me-2"></i>Manajemen User</h5>
                    </div>
                    <div class="card-body">

                        {{-- === Form Tambah User === --}}
                        <form action="{{ route('accounts.store') }}" method="POST" class="mb-4">
                            @csrf
                            <div class="mb-3">
                                <label>Nama</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label>Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label>Pilih Role</label>
                                <select name="role_id" class="form-control" required>
                                    <option value="">-- Pilih Role --</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->_id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Buat User</button>
                        </form>

                        <hr class="border-secondary">

                        {{-- === Daftar User === --}}
                        <h3 class="text-white">Daftar User</h3>
                        <table class="table table-dark table-bordered">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th style="width: 200px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->role ? $user->role->name : '-' }}</td>
                                    <td>
                                        {{-- Tombol Edit --}}
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->_id }}">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>

                                        {{-- Tombol Delete --}}
                                        <form action="{{ route('accounts.destroy', $user->_id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus user ini?')">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                {{-- Modal Edit User --}}
                                <div class="modal fade" id="editUserModal{{ $user->_id }}" tabindex="-1" aria-labelledby="editUserLabel{{ $user->_id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form action="{{ route('accounts.update', $user->_id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-content bg-dark text-white">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editUserLabel{{ $user->_id }}">Edit User</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label>Nama</label>
                                                        <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label>Email</label>
                                                        <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label>Role</label>
                                                        <select name="role_id" class="form-control" required>
                                                            @foreach ($roles as $role)
                                                                <option value="{{ $role->_id }}" {{ $user->role_id == $role->_id ? 'selected' : '' }}>
                                                                    {{ $role->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
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
    .bg-dark-subtle {
        background-color: #2c3034;
    }
    .border-secondary {
        border-color: #495057 !important;
    }
</style>
@endsection
