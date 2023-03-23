<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountFB extends Model
{
    use HasFactory;
    protected $table = 'account_fb';
    protected $fillable = ['user_id','fb_id','name','email','phone','password','cookie','token'];
}
