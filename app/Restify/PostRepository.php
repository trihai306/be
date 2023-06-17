<?php

namespace App\Restify;

use App\Models\Post;
use Binaryk\LaravelRestify\Fields\Image;
use Binaryk\LaravelRestify\Http\Requests\RestifyRequest;

class PostRepository extends Repository
{
    public static string $model = Post::class;
    public static array $search = [  'id','title',
        'content',
        'image',
        'user_id',
        'category_id',
        'price',
        'gender',
        'note',
        'quantity',
        'material',
        'size',
        'status'];
    public static array $sort = [   'title',
        'content',
        'image',
        'user_id',
        'category_id',
        'price',
        'gender',
        'note',
        'quantity',
        'material',
        'size',
        'status'];
    public static array $match = [
        'id' => 'int',
        'title'=>'string',
        'content'=>'string',
        'image'=>'string',
        'user_id'=>'int',
        'category_id'=>'int'];
    public function fields(RestifyRequest $request): array
    {
        return [
            id(),
            field('title')->rules('required'),
            field('content')->rules('required'),
            Image::make('image')->rules('required'),
            field('user.name')->rules('required'),
            field('category.name')->rules('required'),
            field('price')->rules('required'),
            field('gender')->rules('required'),
            field('note')->rules('required'),
            field('quantity')->rules('required'),
            field('material')->rules('required'),
            field('size')->rules('required'),
            field('status')->rules('required'),
            field('created_at'),
            field('updated_at'),
        ];
    }
}
