@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Manajemen Role & Permission</h2>

    {{-- Form Tambah Role --}}
    <form action="{{ route('roles.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Nama Role</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Pilih Permission</label><br>
            @foreach($permissions as $permission)
                <label>
                    <input type="checkbox" name="permissions[]" value="{{ $permission->_id }}">
                    {{ $permission->name }}
                </label><br>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary">Tambah Role</button>
    </form>

    <hr>

    {{-- List Role --}}
    <h3>Daftar Role</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Nama Role</th>
                <th>Permissions</th>
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
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
