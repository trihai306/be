<?php

namespace App\Restify;

use App\Models\DepositHistory;
use Binaryk\LaravelRestify\Http\Requests\RestifyRequest;

class DepositHistoryRepository extends Repository
{
    public static string $model = DepositHistory::class;
    public static array $search = ['id', 'user_id', 'amount', 'transaction_date', 'note', 'approved_by', 'status', 'created_at', 'updated_at'];

    public static array $with = ['user', 'approver'];

    public static array $count = ['user', 'approver'];

    public static array $filter = [
        'user_id',
        'amount',
        'transaction_date',
        'note',
        'approved_by',
        'status',
    ];

    public static array $orderBy = [
        'user_id',
        'amount',
        'transaction_date',
        'note',
        'approved_by',
        'status',
    ];

    public static array $groupBy = [
        'user_id',
        'amount',
        'transaction_date',
        'note',
        'approved_by',
        'status',
    ];

    public static array $match = [
     'user_id'=>'integer',
        'amount'=>'integer',
        'transaction_date'=>'date',
        'note'=>'string',
        'approved_by'=>'integer',
        'status'=>'string',
    ];
    public function fields(RestifyRequest $request): array
    {
        return [
            id(),
            field('user_id')->rules('required'),
            field('amount')->rules('required'),
            field('transaction_date')->rules('required'),
            field('note'), // Thêm trường note
            field('approved_by')->rules('required'),
            field('status')->rules('required'),
        ];
    }
}
