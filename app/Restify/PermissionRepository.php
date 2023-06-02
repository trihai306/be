<?php

namespace App\Restify;

use App\Models\Permission;
use Binaryk\LaravelRestify\Http\Requests\RestifyRequest;

class PermissionRepository extends Repository
{
    public static string $model = Permission::class;

    public function fields(RestifyRequest $request): array
    {
        return [
            id(),
            field('name')->rules('required'),
        ];
    }
}
