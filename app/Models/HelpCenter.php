<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HelpCenter extends Model
{
    //
    Use HasFactory,SoftDeletes;

    protected $fillable = [
        'user_id',
        'user_type',
        'subject',
        'description',
        'status'
    ];
}
