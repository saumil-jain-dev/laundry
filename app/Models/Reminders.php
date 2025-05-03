<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reminders extends Model
{
    //
    Use SoftDeletes,HasFactory;

    protected $table  = 'reminders';
    protected $casts = [
        'reminder_date_time' => 'datetime',
    ];
    protected $fillable = [
        'order_id',
        'business_id',
        'type',
        'reminder_date_time',
        'status'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
