<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserDevice extends Model
{
    //
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'user_id',
        'device_id',
        'device_type',
        'device_token',
        'os_version',
        'app_version',
        'device_name',
        'model_name',
        'status'
    ];
}
