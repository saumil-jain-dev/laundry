<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faq extends Model
{
    //
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'question',
        'answer',
        'status'
    ];
}
