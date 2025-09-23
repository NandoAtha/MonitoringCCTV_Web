<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;

class User extends Model implements Authenticatable
{
    use AuthenticatableTrait;

    protected $connection = 'mongodb';   
    protected $collection = 'users';     

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // user hanya punya satu role
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', '_id');
    }

    // cek role
    public function hasRole($roleName)
    {
        return $this->role && $this->role->name === $roleName;
    }

    // cek permission
    public function hasPermission($permissionName)
    {
        $permission = Permission::where('name', $permissionName)->first();
        if (!$permission) {
            return false;
        }

        return \DB::connection('mongodb')
            ->table('role_has_permissions') // pakai table, bukan collection
            ->where('role_id', (string) $this->role_id)
            ->where('permission_id', (string) $permission->_id)
            ->exists();
    }

    // alias biar bisa pakai $user->can('xxx')
    public function can($permissionName)
    {
        return $this->hasPermission($permissionName);
    }
}

