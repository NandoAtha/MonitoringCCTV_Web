<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use App\Models\RoleHasPermission; // model pivot
use App\Models\RoleHasPermissions;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        $permissions = Permission::all();

        return view('roles.index', compact('roles', 'permissions'));
    }

    public function store(Request $request)
    {
        $role = new Role();
        $role->name = $request->name;
        $role->guard_name = 'web';
        $role->save();

        // Simpan permissions ke pivot
        if ($request->has('permissions')) {
            foreach ($request->permissions as $permissionId) {
                RoleHasPermissions::create([
                    'role_id'       => $role->_id,
                    'permission_id' => $permissionId,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Role berhasil dibuat!');
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $role->name = $request->name;
        $role->save();

        // Hapus relasi lama
        RoleHasPermissions::where('role_id', $role->_id)->delete();

        // Simpan ulang permission baru
        if ($request->has('permissions')) {
            foreach ($request->permissions as $permissionId) {
                RoleHasPermissions::create([
                    'role_id'       => $role->_id,
                    'permission_id' => $permissionId,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Role berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);

        // Hapus relasi permissions juga
        RoleHasPermissions::where('role_id', $role->_id)->delete();

        $role->delete();

        return redirect()->back()->with('success', 'Role berhasil dihapus!');
    }
}
