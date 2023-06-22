<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;
    protected $guarded = [
        'id',
        'name',
        'email',
        'phone',
        'password',
        'cookie',
        'status',
        'proxy_id',
        'created_at',
        'updated_at',
    ];
    public function proxy()
    {
        return $this->belongsTo(Proxy::class);
    }
}
