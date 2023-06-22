<?php

namespace App\Restify;

use App\Models\Account;
use Binaryk\LaravelRestify\Http\Requests\RestifyRequest;

class AccountRepository extends Repository
{
    public static string $model = Account::class;

    public static array $search = [
        'id',
        'name',
        'email',
        'phone',
        'password',
        'status',
        'created_at',
    ];

    public static array $sort = [
        'id',
        'name',
        'email',
        'phone',
        'password',
        'status',
        'created_at',
    ];

    public static array $filter = [
        'id',
        'name',
        'email',
        'phone',
        'password',
        'status',
        'created_at',
    ];

    public static array $match = [
        'id' => 'int',
        'name' => 'string',
        'email' => 'string',
        'phone' => 'string',
        'password' => 'string',
        'status' => 'string',
        'created_at' => 'between',
    ];
    public function fields(RestifyRequest $request): array
    {
        return [
            id(),
            field('name'),
            field('email'),
            field('phone'),
            field('password'),
            field('cookie'),
            field('status'),
            field('created_at'),
        ];
    }
}
