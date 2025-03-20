<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookMark extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'device_id',
        'user_id',
        'business_id',
    ];

    public function business()
    {
        return $this->belongsTo(BusinessDetail::class);
    }
}
