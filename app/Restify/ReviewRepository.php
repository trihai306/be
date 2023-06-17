<?php

namespace App\Restify;

use App\Models\Review;
use Binaryk\LaravelRestify\Http\Requests\RestifyRequest;

class ReviewRepository extends Repository
{
    public static string $model = Review::class;
    public static array $search = ['id', 'user_id', 'post_id', 'star', 'content', 'image', 'status', 'created_at', 'updated_at'];
    public static array $with = ['user', 'post'];
    public static array $count = ['user', 'post'];
    public static array $filter = [
        'user_id',
        'post_id',
        'star',
        'content',
        'image',
        'status',
    ];
    public static array $orderBy = [
        'user_id',
        'post_id',
        'star',
        'content',
        'image',
        'status',
    ];

    public static array $match = [
        'user_id' => 'integer',
        'post_id' => 'integer',
        'star' => 'integer',
        'content' => 'string',
        'image' => 'string',
        'status' => 'string',
    ];

    public function fields(RestifyRequest $request): array
    {
        return [
            id(),
            field('user.name')->rules('required'),
            field('post.title')->rules('required'),
            field('star')->rules('required'),
            field('content')->rules('required'),
            field('image')->rules('required'),
            field('status')->rules('required'),
            field('created_at'),
            field('updated_at'),
        ];
    }
}
