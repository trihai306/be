<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepositHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'note',
        'transaction_date',
        'approved_by',
        'status',
    ];

    protected $casts = [
        'transaction_date' => 'datetime',
    ];

    /**
     * Get the user who made the deposit.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the user who approved the deposit.
     */
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
