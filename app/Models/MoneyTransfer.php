<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MoneyTransfer extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'amount',
        'note',
        'bank_name',
        'bank_account',
        'number_account',
        'status',
    ];

    /**
     * Get the user associated with the money transfer.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
