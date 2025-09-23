<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();

        return view('roles.index', compact('roles', 'permissions'));
    }

    public function store(Request $request)
    {
        $role = new Role();
        $role->name = $request->name;
        $role->permissions = $request->permissions ?? [];
        $role->save();

        return redirect()->back()->with('success', 'Role berhasil dibuat!');
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $role->name = $request->name;
        $role->permissions = $request->permissions ?? [];
        $role->save();

        return redirect()->back()->with('success', 'Role berhasil diperbarui!');
    }
}
