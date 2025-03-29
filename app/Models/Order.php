<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Order extends Model
{
    //
    use SoftDeletes, HasFactory;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            $order->order_number = self::generateUniqueOrderNumber();
        });
    }

    public static function generateUniqueOrderNumber()
    {
        do {
            $orderNumber = 'ORD-' . strtoupper(Str::random(8)); // Example: ORD-AB12CD34
        } while (self::where('order_number', $orderNumber)->exists());

        return $orderNumber;
    }
    protected $fillable = [
        'order_number',
        'user_id',
        'business_id',
        'total_amount',
        'gross_amount',
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

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }
    public function business()
    {
        return $this->belongsTo(BusinessDetail::class, 'business_id');
    }
}
