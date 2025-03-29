<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    //
    use SoftDeletes, HasFactory;
    protected $fillable = [
        'order_id',
        'business_id',
        'service_id',
        'category',
        'item_name',
        'unit_type',
        'quantity',
        'price_per_unit',
        'total_price',

    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
}
