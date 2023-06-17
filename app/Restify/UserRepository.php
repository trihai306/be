<?php

namespace App\Restify;

use App\Models\User;
use Binaryk\LaravelRestify\Http\Requests\RestifyRequest;
use Illuminate\Support\Facades\Hash;

class UserRepository extends Repository
{
    public static string $model = User::class;
    public static array $search = ['id', 'name', 'email', 'phone', 'created_at', 'updated_at'];
    public static array $sort = ['id', 'name', 'email', 'phone', 'created_at', 'updated_at'];
    public static array $match = [
        'id' => 'int',
        'name' => 'string',
        'email' => 'string',
        'phone' => 'string',
        'password' => 'string',
        'created_at'=>'between',
        'updated_at'=>'between',
    ];
    public function fields(RestifyRequest $request): array
    {
        return [
            field('name')->rules('required'),

            field('email')->storingRules('required', 'unique:users')->messages([
                'required' => 'This field is required.',
            ]),
            field('phone'),
            field('password')->storingRules('required')->
            storeCallback(function () use ($request) {
                return Hash::make($request->input('password'));
            })
                ->updateCallback(function () use ($request) {
                    return Hash::make($request->input('password'));
                })
                ->canSee(function () {
                    return false;
                }),
            field('created_at'),
            field('email_verified_at'),
        ];
    }
}
