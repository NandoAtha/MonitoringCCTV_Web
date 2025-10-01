<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use App\Models\Permission;
use App\Models\RoleHasPermission;
class Role extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'roles';

    protected $fillable = ['name', 'permissions'];

    protected $casts = [
        'permissions' => 'array'
    ];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, null, 'role_ids', 'permission_ids');

    }
    

    public function permissionsList()
    {
        $permissionIds = RoleHasPermissions::where('role_id', (string) $this->_id)
                                        ->pluck('permission_id')
                                        ->toArray();

        return Permission::whereIn('_id', $permissionIds)->get();
    }



    // public function permissions()
    // {
    //     return $this->hasMany(Permission::class, '_id', 'permissions');
    // }

}

