<?php

namespace App\Restify;

use App\Models\User;
use Binaryk\LaravelRestify\Http\Requests\RestifyRequest;

class UserRepository extends Repository
{
    public static string $model = User::class;
    public static array $search = ['id', 'name', 'email','phone','address','state','country','avatar','points','role','status'];

    public static array $with = ['accountfb', 'proxy'];
    public function fields(RestifyRequest $request): array
    {
        return [
            field('name')->rules('required'),

            field('email')->storingRules('required', 'unique:users')->messages([
                'required' => 'This field is required.',
            ]),
            field('phone')->storingRules('required', 'unique:users')->messages([
                'required' => 'This field is required.',
            ]),
            field('address'),
            field('state'),
            field('country'),
            field('avatar'),
            field('points'),
            field('role')->rules('required'),
            field('status')->rules('required'),
        ];
    }
}
