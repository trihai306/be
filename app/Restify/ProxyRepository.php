<?php

namespace App\Restify;

use App\Models\Proxy;
use Binaryk\LaravelRestify\Http\Requests\RestifyRequest;

class ProxyRepository extends Repository
{
    public static string $model = Proxy::class;

    public function fields(RestifyRequest $request): array
    {
        return [
            id(),
        ];
    }
}
