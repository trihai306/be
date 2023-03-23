<?php

namespace App\Restify;

use App\Models\AccountFB;
use Binaryk\LaravelRestify\Http\Requests\RestifyRequest;

class AccountFBRepository extends Repository
{
    public static string $model = AccountFB::class;
    public static bool|array $public = true;
    public static string $uriKey = 'accountfb';

    public static array $match = [
        'id' => 'int',
        'user_id' => 'int',
        'fb_id' => 'string',
        'name' => 'string',
        'email' => 'string',
        'phone' => 'string',
        'password' => 'string',
        'created_at'=>'between',
        'updated_at'=>'between',
    ];
    public static array $search = ['id','user_id', 'fb_id', 'name', 'email', 'phone', 'password','created_at','updated_at'];
    public function fields(RestifyRequest $request): array
    {
        return [
            id(),
            field('user_id')->required(),
            field('fb_id')->required()->storingRules('unique:account_fb,fb_id')->messages([
                'required' => 'This field is required.',
            ]),
            field('name')->required(),
            field('email')->required(),
            field('phone'),
            field('password')->required(),
            field('cookie'),
            field('token')
        ];
    }
}
