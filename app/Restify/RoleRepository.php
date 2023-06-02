<?php

namespace App\Restify;

use App\Models\Role;
use Binaryk\LaravelRestify\Http\Requests\RestifyRequest;


class RoleRepository extends Repository
{
    public static string $model = Role::class;
    public static array $search = ['id', 'name'];
    public static array $sort = ['id', 'name'];
    public static array $match = [
        'id' => 'int',
        'name' => 'string',
    ];

    public function fields(RestifyRequest $request): array
    {
        return [
            id(),
            field('name')->rules('required'),
            field('permissions')->rules('required'),
        ];
    }
}
