<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proxy extends Model
{
    use HasFactory;
    protected $table = 'proxys';
    protected $fillable = [
        'domain',
        'port',
        'username',
        'password',
        'status',
        'type',
        'user_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
