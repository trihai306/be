<?php

namespace App\Restify;

use App\Models\InforFacebook;
use Binaryk\LaravelRestify\Http\Requests\RestifyRequest;

class InforFacebookRepository extends Repository
{
    public static string $model = InforFacebook::class;

    public function fields(RestifyRequest $request): array
    {
        return [
            id(),
        ];
    }
}
