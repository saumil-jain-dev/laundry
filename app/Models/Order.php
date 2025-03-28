<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    //
    use SoftDeletes, HasFactory;
    protected $fillable = [
        'user_id',
        'business_id',
        'total_price',
        'gross_anount',
        'discount_amount',
        'diccount_id',
        'coupon_code',
        'pickup_date_time',
        'drop_date_time',
        'address',
        'customer_notes',
        'canceled_by',
        'cancel_remark',
        'cancel_reason',
        'status'
    ];
}
