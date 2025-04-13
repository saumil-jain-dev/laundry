<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotificationReceiver extends Model
{
    //
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'notification_id',
        'sender_id',
        'receiver_id',
        'status'
    ];

    public function notification()
    {
        return $this->belongsTo(Notification::class);
    }
}
