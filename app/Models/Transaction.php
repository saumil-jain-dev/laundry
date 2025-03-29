<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    //
    use SoftDeletes,HasFactory;
    protected $fillable = [
        'order_id',
        'user_id',
        'payment_method',
        'transaction_status',
        'transaction_id',
        'transaction_response',
        'transaction_complete_date',
        'amount'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
