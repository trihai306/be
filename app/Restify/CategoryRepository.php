<?php

namespace App\Restify;

use App\Models\Category;
use Binaryk\LaravelRestify\Http\Requests\RestifyRequest;

class CategoryRepository extends Repository
{
    public static string $model = Category::class;

    public static array $search = ['id', 'name', 'created_at', 'updated_at'];

    public static array $sort = ['id', 'name', 'created_at', 'updated_at'];

    public static array $match = [
        'id' => 'int',
        'name' => 'string',
        'created_at' => 'between',
        'updated_at' => 'between',
    ];
    public function fields(RestifyRequest $request): array
    {
        return [
            id(),
            field('name')->rules('required'),
        ];
    }
}
