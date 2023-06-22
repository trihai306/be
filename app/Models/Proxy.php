<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proxy extends Model
{
    use HasFactory;
    protected $guarded = [
        'id',
        'ip',
        'port',
        'username',
        'password',
        'status',
        'created_at',
        'updated_at',
    ];
}
