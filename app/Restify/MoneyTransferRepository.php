<?php

namespace App\Restify;

use App\Models\MoneyTransfer;
use Binaryk\LaravelRestify\Http\Requests\RestifyRequest;

class MoneyTransferRepository extends Repository
{
    public static string $model = MoneyTransfer::class;

    public static array $search = ['id', 'user_id', 'type', 'amount', 'note', 'bank_name', 'bank_account', 'number_account', 'status', 'created_at', 'updated_at'];

    public static array $sort = ['id', 'user_id', 'type', 'amount', 'note', 'bank_name', 'bank_account', 'number_account', 'status', 'created_at', 'updated_at'];

    public static array $match = [
        'id' => 'int',
        'user_id' => 'int',
        'type' => 'string',
        'amount' => 'decimal',
        'note' => 'string',
        'bank_name' => 'string',
        'bank_account' => 'string',
        'number_account' => 'string',
        'status' => 'string',
        'created_at' => 'between',
        'updated_at' => 'between',
    ];
    public function fields(RestifyRequest $request): array
    {
        return [
            id(),
            field('user_id')->rules('required'),
            field('type')->rules('required'),
            field('amount')->rules('required'),
            field('note')->nullable(),
            field('bank_name')->rules('required'),
            field('bank_account')->rules('required'),
            field('number_account')->rules('required'),
            field('status')->rules('required'),
        ];
    }
}
