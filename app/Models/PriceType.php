<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PriceType extends Model
{
    //
    Use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'status'
    ];
}
