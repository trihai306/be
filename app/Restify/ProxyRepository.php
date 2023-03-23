<?php

namespace App\Restify;

use App\Models\Proxy;
use Binaryk\LaravelRestify\Http\Requests\RestifyRequest;

class ProxyRepository extends Repository
{
    public static string $model = Proxy::class;
    public static bool|array $public = true;
    public static string $uriKey = 'proxy';
    public static array $search = ['id', 'domain', 'port', 'username', 'password', 'status', 'type','user_id'];

    public static array $with = ['user'];

    public function fields(RestifyRequest $request): array
    {
        return [
            id(),
            field('domain')->required(),
            field('port')->required(),
            field('username'),
            field('password'),
            field('status')->required(),
            field('type')->required(),
        ];
    }
}
