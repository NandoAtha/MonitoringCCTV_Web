<?php

namespace App\Providers;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 🔹 Definisikan gate dinamis dari MongoDB
    // $permissions = \App\Models\Permission::all();

    //     foreach ($permissions as $permission) {
    //         Gate::define($permission->name, function (User $user) use ($permission) {
    //             // Cek apakah user punya role yang memiliki permission ini
    //             $role = \App\Models\Role::where('_id', $user->role_id)->first();
    //             if (!$role) return false;
    //             // Ambil array ID permission dari field atau relasi
    //             // Ambil permission id dari relasi belongsToMany (pivot role_has_permissions)
    //             $permissionIds = $role->permissions()->pluck('_id')->toArray();
    //             $permissionIds = array_map('strval', $permissionIds);
    //             return in_array((string)$permission->_id, $permissionIds);
    //         });
    //     }
    }
}
