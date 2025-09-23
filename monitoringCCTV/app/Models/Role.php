<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use App\Models\Permission;
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

    // public function permissions()
    // {
    //     return $this->hasMany(Permission::class, '_id', 'permissions');
    // }

}

