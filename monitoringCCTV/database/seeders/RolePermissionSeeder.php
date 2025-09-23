<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use MongoDB\Client;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $client = new Client(env('DB_URI')); // mongodb://localhost:27017
        $db = $client->selectDatabase(env('DB_DATABASE'));

        $roles = $db->roles;
        $permissions = $db->permissions;
        $users = $db->users;
        $rolePermissions = $db->role_has_permissions;

        // Hapus data lama dulu biar bersih
        $roles->drop();
        $permissions->drop();
        $users->drop();
        $rolePermissions->drop();

        // Insert Roles
        $adminRole = $roles->insertOne([
            'name' => 'admin',
            'guard_name' => 'web',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $userRole = $roles->insertOne([
            'name' => 'user',
            'guard_name' => 'web',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Insert Permissions
        $permDashboard = $permissions->insertOne([
            'name' => 'view_dashboard',
            'guard_name' => 'web',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $permUsers = $permissions->insertOne([
            'name' => 'manage_users',
            'guard_name' => 'web',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $permCCTV = $permissions->insertOne([
            'name' => 'view_cctv',
            'guard_name' => 'web',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Insert Role ↔ Permissions
        // Admin dapat semua
        foreach ([$permDashboard, $permUsers, $permCCTV] as $perm) {
            $rolePermissions->insertOne([
                'role_id' => (string) $adminRole->getInsertedId(),
                'permission_id' => (string) $perm->getInsertedId(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // User hanya view_cctv
        $rolePermissions->insertOne([
            'role_id' => (string) $userRole->getInsertedId(),
            'permission_id' => (string) $permCCTV->getInsertedId(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Insert Users
        $users->insertOne([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role_id' => (string) $adminRole->getInsertedId(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $users->insertOne([
            'name' => 'User CCTV',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'role_id' => (string) $userRole->getInsertedId(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
