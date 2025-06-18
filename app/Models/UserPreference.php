<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPreference extends Model
{
    protected $fillable = [
        'user_id',
        'language',
        'notify_job_alerts',
        'notify_message_alerts',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
    use HasFactory;
}
