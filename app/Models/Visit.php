<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;

    protected $fillable = [
        'ip_address_hash',
        'user_agent_hash',
        'device_type',
        'last_seen',
    ];

    protected $casts = [
        'last_seen' => 'datetime',
    ];
}