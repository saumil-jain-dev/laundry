<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusinessDetail extends Model
{
    //
    Use SoftDeletes,HasFactory;

    protected $fillable = [
        'user_id',
        'business_name',
        'business_type_id',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'country',
        'zipcode',
        'lattitude',
        'longitude',
        'about',
        'media',
        'store_timings',
        'pricing',
        'is_verified',
        'status'
    ];

    public function businessType()
    {
        return $this->belongsTo(BusinessType::class, 'business_type_id', 'id');
    }

}
