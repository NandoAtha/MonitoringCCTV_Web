<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class RoleHasPermissions extends Model
{
    protected $connection = 'mongodb'; // pakai koneksi mongodb
    protected $collection = 'role_has_permissions'; // nama collection pivot

    protected $fillable = [
        'role_id',
        'permission_id',
    ];
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', '_id');
    }

    public function permission()
    {
        return $this->belongsTo(Permission::class, 'permission_id', '_id');
    }

}
