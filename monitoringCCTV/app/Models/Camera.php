<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model; // PENTING: gunakan ini, bukan Illuminate

class Camera extends Model
{
    protected $collection = 'cameras'; // nama collection di MongoDB
    protected $connection = 'mongodb'; // koneksi MongoDB di config/database.php

    protected $fillable = [
        'name',
        'ip',
        'port',
        'rtsp_url',
        'stream_url',
        'online',
        'type',
        'location',
    ];

     protected $casts = [
        'online' => 'boolean',
    ];

    protected $attributes = [
        'port' => '554',
        'online' => true,
        'type' => 'IP Camera',
    ];
}

   


